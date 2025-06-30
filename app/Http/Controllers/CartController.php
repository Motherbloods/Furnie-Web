<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        $cartItems = Cart::with(relations: ['product', 'product.seller'])
            ->forUser(Auth::id())
            ->get();

        $subtotal = $cartItems->sum('total_price');
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;
        return view('transaksi.keranjang-saya', compact(
            'cartItems',
            'subtotal',
        ));
    }

    /**
     * Tambah item ke keranjang
     */
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            // Validasi
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::findOrFail($validated['product_id']);

            // Cek stok
            if ($product->stock < $validated['quantity']) {
                return response()->json(['error' => 'Stok tidak mencukupi'], 400);
            }

            try {
                Cart::addToCart(Auth::id(), $validated['product_id'], $validated['quantity']);
                return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal menambahkan produk ke keranjang'], 500);
            }
        }

        // Default untuk request biasa (form)
        return back()->with('error', 'Invalid request');
    }

    /**
     * Update quantity item di keranjang
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Pastikan cart milik user yang sedang login
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Cek stok
        if ($cart->product->stock < $request->quantity) {
            return response()->json(['error' => 'Stok tidak mencukupi'], 400);
        }

        $cart->updateQuantity($request->quantity);

        return response()->json([
            'success' => true,
            'total_price' => $cart->total_price,
            'formatted_total' => 'Rp ' . number_format($cart->total_price, 0, ',', '.')
        ]);
    }

    /**
     * Hapus item dari keranjang
     */
    public function destroy(Cart $cart)
    {
        // Pastikan cart milik user yang sedang login
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json(['success' => true]);
    }

    public function rate(Request $request, Order $order)
    {
        Log::info('Memulai proses rating untuk order ID: ' . $order->order_id);
        Log::info('Request data:', $request->all());

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $user = Auth::user();

        // Pastikan user adalah pemilik order
        if ($user->id !== $order->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Load order items dengan relasi product dan seller sekaligus
        $order->load('items.product.seller');

        foreach ($order->items as $item) {
            $product = $item->product;

            Log::info("cek ini product {$product}");

            if (!$product) {
                Log::warning("Product tidak ditemukan untuk item ID: {$item->id}");
                continue;
            }

            // Cek apakah sudah pernah rating produk ini di order ini
            $alreadyRated = ProductRating::where([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'order_id' => $order->id,
            ])->exists();

            if ($alreadyRated) {
                Log::info("User {$user->id} sudah merating product {$product->id} di order {$order->id}");
                continue;
            }

            Log::info("Rating product {$product->id} oleh user {$user->id} untuk order {$order->id}");

            // Simpan rating baru
            ProductRating::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'order_id' => $order->id,
                'rating' => $request->rating,
            ]);

            Log::info("Rating disimpan untuk product ID {$product->id} oleh user {$user->id}");

            // Update average rating produk
            $avgProductRating = ProductRating::where('product_id', $product->id)->avg('rating');
            $product->rating = round($avgProductRating, 1);
            $product->save();

            // Update rating_toko (average dari semua produk seller)
            $seller = $product->seller;

            if (!$seller) {
                Log::error("Seller tidak ditemukan untuk product ID: {$product->id}");
                continue;
            }

            Log::info("Seller ditemukan: ID {$seller->id}, Name: {$seller->store_name}");

            // Hitung rata-rata rating dari semua produk seller yang memiliki rating
            $avgSellerRating = Product::where('seller_id', $seller->id)
                ->whereNotNull('rating')
                ->where('rating', '>', 0)
                ->avg('rating');

            if ($avgSellerRating) {
                $seller->rating_toko = round($avgSellerRating, 1);
                $seller->save();
                Log::info("Rating toko seller ID {$seller->id} diupdate menjadi {$seller->rating_toko}");
            } else {
                Log::info("Tidak ada rating untuk produk seller ID {$seller->id}");
            }
        }

        return response()->json(['message' => 'Rating saved']);
    }

    /**
     * Hitung diskon (contoh logic)
     */
    private function calculateDiscount($subtotal)
    {
        if ($subtotal >= 5000000) {
            return 500000; // Diskon 500k untuk pembelian >= 5 juta
        }
        return 0;
    }


    /**
     * Hitung ongkos kirim (contoh logic)
     */
    private function calculateShipping($subtotal)
    {
        if ($subtotal >= 10000000) {
            return 0; // Gratis ongkir untuk pembelian >= 10 juta
        }
        return 150000; // Ongkir standar 150k
    }


    /**
     * Get cart count untuk navbar
     */
    public function getCartCount()
    {
        $count = Cart::getItemCountForUser(Auth::id());
        return response()->json(['count' => $count]);
    }
}