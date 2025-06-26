<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;


class CheckoutController extends Controller
{

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

    public function getSnapToken(Request $request)
    {
        // Pastikan request adalah AJAX/JSON
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Request harus berupa JSON'], 400);
        }

        try {
            // Validasi request
            $validated = $request->validate([
                'shipping_method' => 'required|in:regular,express,sameday',
                'full_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'postal_code' => 'required|string|max:10',
            ]);

            // Set konfigurasi midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = false; // true untuk production
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Keranjang kosong'], 400);
            }

            // Hitung ulang total dengan perhitungan yang benar
            $subtotal = $cartItems->sum('total_price');
            $discount = $this->calculateDiscount($subtotal);
            $tax = $this->calculateTax($subtotal);
            $shippingCost = $this->getShippingCost($validated['shipping_method']);
            $grossAmount = $subtotal - $discount + $tax + $shippingCost;

            $orderId = 'ORDER-' . time() . '-' . Auth::id();

            // Buat item details untuk produk
            $itemDetails = [];

            foreach ($cartItems as $item) {
                $itemDetails[] = [
                    'id' => 'PROD-' . $item->product->id,
                    'price' => (int) $item->product->price,
                    'quantity' => (int) $item->quantity,
                    'name' => substr($item->product->name, 0, 50), // Limit nama produk
                ];
            }

            // Tambahkan item untuk diskon jika ada
            if ($discount > 0) {
                $itemDetails[] = [
                    'id' => 'DISCOUNT',
                    'price' => -(int) $discount, // Negatif untuk diskon
                    'quantity' => 1,
                    'name' => 'Diskon Pembelian',
                ];
            }

            // Tambahkan item untuk pajak
            if ($tax > 0) {
                $itemDetails[] = [
                    'id' => 'TAX',
                    'price' => (int) $tax,
                    'quantity' => 1,
                    'name' => 'Pajak (11%)',
                ];
            }

            // Tambahkan item untuk ongkir
            if ($shippingCost > 0) {
                $shippingMethodNames = [
                    'regular' => 'Pengiriman Regular',
                    'express' => 'Pengiriman Express',
                    'sameday' => 'Pengiriman Same Day'
                ];

                $itemDetails[] = [
                    'id' => 'SHIPPING',
                    'price' => (int) $shippingCost,
                    'quantity' => 1,
                    'name' => $shippingMethodNames[$validated['shipping_method']] ?? 'Ongkos Kirim',
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $grossAmount,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $validated['full_name'],
                    'email' => Auth::user()->email,
                    'phone' => $validated['phone'],
                    'billing_address' => [
                        'first_name' => $validated['full_name'],
                        'address' => $validated['address'],
                        'city' => $validated['city'],
                        'postal_code' => $validated['postal_code'],
                        'country_code' => 'IDN'
                    ],
                    'shipping_address' => [
                        'first_name' => $validated['full_name'],
                        'address' => $validated['address'],
                        'city' => $validated['city'],
                        'postal_code' => $validated['postal_code'],
                        'country_code' => 'IDN'
                    ]
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'token' => $snapToken,
                'order_id' => $orderId,
                'breakdown' => [
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'shipping_cost' => $shippingCost,
                    'total' => $grossAmount
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validasi gagal',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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