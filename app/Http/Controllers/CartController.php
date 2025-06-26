<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        $cartItems = Cart::with(['product', 'product.seller'])
            ->forUser(Auth::id())
            ->get();

        $subtotal = $cartItems->sum('total_price');
        $discount = $this->calculateDiscount($subtotal);
        $shippingCost = $this->calculateShipping($subtotal);
        $total = $subtotal - $discount + $shippingCost;

        return view('keranjang-saya', compact(
            'cartItems',
            'subtotal',
            'discount',
            'shippingCost',
            'total'
        ));
    }

    /**
     * Tambah item ke keranjang
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek stok
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // Cek apakah produk aktif
        if (!$product->isAvailable()) {
            return back()->with('error', 'Produk tidak tersedia');
        }

        try {
            Cart::addToCart(Auth::id(), $request->product_id, $request->quantity);
            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan produk ke keranjang');
        }
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