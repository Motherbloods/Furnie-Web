<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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


    // Tambahkan method ini di CheckoutController

    public function checkoutLangsung(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0'
            ]);

            $productId = $request->product_id;
            $quantity = $request->quantity;
            $price = $request->price;

            // Ambil data produk dengan seller
            $product = Product::with('seller')->findOrFail($productId);
            \Log::error('Error in checkoutLangsung: ' . $productId);
            // Validasi harga (opsional, untuk keamanan)
            if (abs($product->price - $price) > 0.01) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harga produk tidak valid'
                ], 400);
            }

            // Validasi stok
            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi'
                ], 400);
            }

            // Hitung total
            $subtotal = $price * $quantity;
            $discount = $this->calculateDiscount($subtotal);
            $tax = $this->calculateTax($subtotal);
            $defaultShippingCost = 25000;
            $total = $subtotal - $discount + $tax + $defaultShippingCost;

            // Simpan data sementara di session untuk checkout
            $checkoutData = [
                'type' => 'direct', // Penanda bahwa ini beli langsung
                'items' => [
                    [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_image' => $product->image,
                        'seller_name' => $product->seller->name,
                        'seller_id' => $product->seller->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total_price' => $subtotal
                    ]
                ],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'shipping_cost' => $defaultShippingCost,
                'total' => $total
            ];

            // Simpan ke session
            session(['checkout_data' => $checkoutData]);

            return response()->json([
                'success' => true,
                'message' => 'Produk siap untuk checkout',
                'redirect_url' => route('transaksi.checkout-direct')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in checkoutLangsung: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    // Method untuk menampilkan halaman checkout langsung
    public function checkoutDirect()
    {
        // Ambil data dari session
        $checkoutData = session('checkout_data');

        if (!$checkoutData || $checkoutData['type'] !== 'direct') {
            return redirect()->route('home')->with('error', 'Data checkout tidak valid');
        }

        // Siapkan data untuk view (format sama seperti checkout biasa)
        $cartItems = collect($checkoutData['items'])->map(function ($item) {
            return (object) [
                'id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
                'product' => (object) [
                    'id' => $item['product_id'],
                    'name' => $item['product_name'],
                    'image' => $item['product_image'],
                    'price' => $item['price'],
                    'seller' => (object) [
                        'id' => $item['seller_id'],
                        'name' => $item['seller_name']
                    ]
                ]
            ];
        });

        $subtotal = $checkoutData['subtotal'];
        $discount = $checkoutData['discount'];
        $tax = $checkoutData['tax'];
        $total = $checkoutData['total'];

        return view('transaksi.checkout-screen', compact(
            'cartItems',
            'subtotal',
            'discount',
            'tax',
            'total'
        ));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'nullable|in:paid,cancelled',
            'payment_type' => 'nullable|string',
            'is_received' => 'nullable|boolean',
            'is_konfirmasi' => 'nullable|boolean',
            'is_dikirim' => 'nullable|boolean',
            'is_selesai' => 'nullable|boolean',
            'perlu_kirim' => 'nullable|boolean',
        ]);

        $order = Order::where('order_id', $request->order_id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order tidak ditemukan'], 404);
        }

        // Jika pesanan ditandai sudah diterima
        if ($request->boolean('is_received')) {
            $order->order_status = 'selesai';
            $order->confirmed_at = now();
            $order->completed_at = now();
            $order->save();

            return response()->json(['success' => true, 'message' => 'Pesanan dikonfirmasi diterima.']);
        }

        // Jika status pembayaran berhasil
        if ($request->status === 'paid') {
            $order->status = 'paid';
            $order->order_status = 'menunggu_konfirmasi';
            $order->payment_type = $request->payment_type ?? $order->payment_type;
            $order->paid_at = now();

            // Hapus cart hanya jika bukan checkout direct
            $checkoutData = session('checkout_data');
            if (!$checkoutData || $checkoutData['type'] !== 'direct') {
                // Checkout dari cart - hapus cart
                Cart::where('user_id', $order->user_id)->delete();
            } else {
                // Checkout direct - hapus session checkout_data
                session()->forget('checkout_data');
            }

            // Update stok produk
            $orderItems = OrderItem::where('order_id', $order->id)->get();
            foreach ($orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        }

        if ($request->boolean('is_konfirmasi')) {
            $order->order_status = 'diproses';
            $order->confirmed_at = now();
            $order->save();

            return response()->json(['success' => true, 'message' => 'Pesanan dikonfirmasi dan sedang diproses.']);
        }

        if ($request->boolean('is_dikirim')) {
            $order->order_status = 'dikirim';
            $order->processed_at = now();
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan dikirim.'
            ]);
        }

        if ($request->boolean('perlu_kirim')) {
            $order->order_status = 'dikirim';
            $order->processed_at = now();
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan sedang dikirim.'
            ]);
        }

        if ($request->status === 'cancelled') {
            $order->status = 'canceled';
            $order->order_status = 'dibatalkan';
            $order->canceled_at = now();

            // Jika dibatalkan, kembalikan stok (jika sudah dikurangi)
            if ($order->paid_at) {
                $orderItems = OrderItem::where('order_id', $order->id)->get();
                foreach ($orderItems as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }

            // Hapus session jika checkout direct
            $checkoutData = session('checkout_data');
            if ($checkoutData && $checkoutData['type'] === 'direct') {
                session()->forget('checkout_data');
            }
        }

        $order->save();

        return response()->json(['success' => true]);
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

            // Set konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Cek apakah ini checkout direct atau dari cart
            $checkoutData = session('checkout_data');
            $isDirectCheckout = $checkoutData && $checkoutData['type'] === 'direct';

            $cartItems = collect();
            $subtotal = 0;

            if ($isDirectCheckout) {
                // Checkout direct - ambil dari session
                $cartItems = collect($checkoutData['items'])->map(function ($item) {
                    return (object) [
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'total_price' => $item['total_price'],
                        'product' => (object) [
                            'id' => $item['product_id'],
                            'name' => $item['product_name'],
                            'price' => $item['price']
                        ]
                    ];
                });
                $subtotal = $checkoutData['subtotal'];
            } else {
                // Checkout dari cart - ambil dari database
                $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

                if ($cartItems->isEmpty()) {
                    return response()->json(['error' => 'Keranjang kosong'], 400);
                }

                $subtotal = $cartItems->sum('total_price');
            }

            // Hitung ulang total
            $discount = $this->calculateDiscount($subtotal);
            $tax = $this->calculateTax($subtotal);
            $shippingCost = $this->getShippingCost($validated['shipping_method']);
            $grossAmount = $subtotal - $discount + $tax + $shippingCost;

            // Gabungkan alamat lengkap
            $fullAddress = "{$validated['full_name']}, {$validated['phone']}, {$validated['address']}, {$validated['city']}, {$validated['province']}, {$validated['postal_code']}";

            // Buat Order ID unik
            $orderId = 'ORDER-' . time() . '-' . Auth::id();

            // Simpan order ke database
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_id' => $orderId,
                'status' => 'pending',
                'order_status' => 'menunggu_konfirmasi',
                'total_amount' => $grossAmount,
                'shipping_cost' => $shippingCost,
                'shipping_method' => $validated['shipping_method'],
                'shipping_address' => $fullAddress,
                'payment_type' => null,
                'payment_token' => null,
                'notes' => null,
            ]);

            // Simpan order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Buat item details untuk Midtrans
            $itemDetails = [];

            foreach ($cartItems as $item) {
                $itemDetails[] = [
                    'id' => 'PROD-' . $item->product->id,
                    'price' => (int) $item->product->price,
                    'quantity' => (int) $item->quantity,
                    'name' => substr($item->product->name, 0, 50),
                ];
            }

            // Tambahkan item untuk diskon jika ada
            if ($discount > 0) {
                $itemDetails[] = [
                    'id' => 'DISCOUNT',
                    'price' => -(int) $discount,
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
            $order->payment_token = $snapToken;
            $order->save();

            return response()->json([
                'success' => true,
                'token' => $snapToken,
                'order_id' => $orderId,
                'checkout_type' => $isDirectCheckout ? 'direct' : 'cart',
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


    public function pesananSaya()
    {
        $orders = Order::with([
            'items' => function ($query) {
                $query->with('product'); // Eager load product untuk setiap item
            },
            'user'
        ])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transaksi.pesanan-saya', compact('orders'));
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