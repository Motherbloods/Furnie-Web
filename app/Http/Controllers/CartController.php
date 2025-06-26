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

        return view('transaksi.keranjang-saya', compact(
            'cartItems',
            'subtotal',
            'discount',
            'shippingCost',
            'total'
        ));
    }

    /**
     * Tampilkan halaman checkout
     */
    public function checkout()
    {
        $cartItems = Cart::with(['product', 'product.seller'])
            ->forUser(Auth::id())
            ->get();

        // Pastikan keranjang tidak kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong');
        }

        // Hitung total
        $subtotal = $cartItems->sum('total_price');
        $discount = $this->calculateDiscount($subtotal);
        $tax = $this->calculateTax($subtotal);

        // Default shipping cost (akan diupdate via JS)
        $defaultShippingCost = 25000;
        $total = $subtotal - $discount + $tax + $defaultShippingCost;

        return view('transaksi.checkout-screen', compact(
            'cartItems',
            'subtotal',
            'discount',
            'tax',
            'total'
        ));
    }

    /**
     * Process checkout (untuk AJAX request)
     */
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_method' => 'required|in:regular,express,sameday'
        ]);

        $cartItems = Cart::with(['product'])
            ->forUser(Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        // Hitung total berdasarkan shipping method
        $subtotal = $cartItems->sum('total_price');
        $discount = $this->calculateDiscount($subtotal);
        $tax = $this->calculateTax($subtotal);
        $shippingCost = $this->getShippingCost($validated['shipping_method']);
        $total = $subtotal - $discount + $tax + $shippingCost;

        // Di sini Anda bisa:
        // 1. Simpan order ke database
        // 2. Integrate dengan Midtrans untuk payment
        // 3. Clear cart setelah berhasil

        return response()->json([
            'success' => true,
            'message' => 'Checkout berhasil',
            'order_data' => [
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'shipping_info' => $validated
            ]
        ]);
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
     * Hitung pajak (11%)
     */
    private function calculateTax($subtotal)
    {
        return $subtotal * 0.11;
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
     * Get shipping cost berdasarkan method
     */
    private function getShippingCost($method)
    {
        $costs = [
            'regular' => 25000,
            'express' => 50000,
            'sameday' => 75000
        ];

        return $costs[$method] ?? 25000;
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