<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Furnie</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.5);
        }

        /* Backdrop blur fallback */
        @supports not (backdrop-filter: blur(12px)) {
            .backdrop-blur-xl {
                background-color: rgba(255, 255, 255, 0.95) !important;
            }
        }

        /* Animation keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-fade-in-up-delay {
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-white to-slate-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white/80 backdrop-blur-xl border-b border-gray-100/50 shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button onclick="history.back()"
                        class="flex items-center justify-center w-12 h-12 bg-slate-100/70 hover:bg-slate-200/70 rounded-2xl transition-all duration-300 group">
                        <svg class="w-6 h-6 text-slate-600 group-hover:text-slate-800" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Keranjang Belanja</h1>
                        <p class="text-sm text-slate-500" id="cart-count">{{ count($cartItems) }} produk dalam keranjang
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="clearCart()"
                        class="flex items-center justify-center w-12 h-12 bg-red-100/70 hover:bg-red-200/70 rounded-2xl transition-all duration-300 group">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        @if ($cartItems->isEmpty())
            <!-- Empty Cart State -->
            <div class="text-center py-16">
                <div class="w-32 h-32 mx-auto mb-6 bg-slate-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Keranjang Kosong</h2>
                <p class="text-slate-600 mb-6">Belum ada produk dalam keranjang belanja Anda</p>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors">
                    Mulai Berbelanja
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4" id="cart-items">
                    @foreach ($cartItems as $index => $item)
                        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-lg border border-slate-200/50 p-6 animate-fade-in-up hover:shadow-xl transition-all duration-300 cart-item"
                            style="animation-delay: {{ $index * 0.1 }}s" data-cart-id="{{ $item->id }}">
                            <div class="flex items-start space-x-6">
                                <div class="relative">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=150&h=150&fit=crop&crop=center' }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-24 h-24 rounded-2xl object-cover shadow-md">

                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-slate-600 mb-3">
                                        Kategori: {{ ucfirst($item->product->kategori) }} |
                                        Stok: {{ $item->product->stock }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <button onclick="updateQuantity({{ $item->id }}, -1)"
                                                class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl flex items-center justify-center transition-all duration-200">
                                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span
                                                class="text-lg font-semibold text-slate-900 min-w-[2rem] text-center quantity-display">{{ $item->quantity }}</span>
                                            <button onclick="updateQuantity({{ $item->id }}, 1)"
                                                class="w-10 h-10 bg-emerald-100 hover:bg-emerald-200 rounded-xl flex items-center justify-center transition-all duration-200">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-bold text-slate-900 item-total">Rp
                                                {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                            <p class="text-sm text-slate-500">{{ $item->product->formatted_price }} per
                                                item</p>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="removeItem({{ $item->id }})"
                                    class="w-10 h-10 bg-red-100/70 hover:bg-red-200/70 rounded-xl flex items-center justify-center transition-all duration-200 group">
                                    <svg class="w-5 h-5 text-red-600 group-hover:scale-110 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="space-y-6">
                    <!-- Summary Card -->
                    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-lg border border-slate-200/50 p-6 animate-fade-in-up-delay sticky top-28"
                        id="order-summary">
                        <h2 class="text-xl font-bold text-slate-900 mb-6">Ringkasan Pesanan</h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">Subtotal (<span
                                        id="item-count">{{ count($cartItems) }}</span> produk)</span>
                                <span class="font-semibold text-slate-900" id="subtotal">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-slate-600">Diskon</span>
                                <span class="font-semibold text-emerald-600" id="discount">-Rp
                                    {{ number_format($discount, 0, ',', '.') }}</span>
                            </div>

                            <div class="border-t border-slate-200/60 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-slate-900">Total</span>
                                    <span class="text-2xl font-bold text-slate-900" id="total">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <button onclick="checkout()"
                            class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9"></path>
                            </svg>
                            <span>Lanjutkan ke Pembayaran</span>
                        </button>

                        <!-- Security Info -->
                        <div class="mt-4 flex items-center justify-center space-x-2 text-sm text-slate-500">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Pembayaran aman dan terpercaya</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Setup CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Update quantity
        function updateQuantity(cartId, change) {
            const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
            const quantityElement = cartItem.querySelector('.quantity-display');
            const currentQuantity = parseInt(quantityElement.textContent);
            const newQuantity = currentQuantity + change;

            if (newQuantity < 1) return;

            fetch(`/cart/${cartId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        quantityElement.textContent = newQuantity;
                        cartItem.querySelector('.item-total').textContent = data.formatted_total;
                        updateOrderSummary();
                    } else {
                        alert(data.error || 'Gagal mengupdate quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                });
        }

        // Remove item
        function removeItem(cartId) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) return;

            fetch(`/cart/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
                        cartItem.style.transform = 'translateX(100%)';
                        cartItem.style.opacity = '0';
                        setTimeout(() => {
                            cartItem.remove();
                            updateOrderSummary();
                            updateCartCount();

                            // Check if cart is empty
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload();
                            }
                        }, 300);
                    } else {
                        alert('Gagal menghapus item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                });
        }

        // Clear cart
        function clearCart() {
            if (!confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) return;

            // Remove all items
            document.querySelectorAll('.cart-item').forEach(item => {
                const cartId = item.getAttribute('data-cart-id');
                removeItem(cartId);
            });
        }

        // Update order summary
        function updateOrderSummary() {
            // Calculate new totals
            let subtotal = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const totalText = item.querySelector('.item-total').textContent;
                const total = parseInt(totalText.replace(/[^\d]/g, ''));
                subtotal += total;
            });

            // Calculate discount and shipping
            const discount = subtotal >= 5000000 ? 500000 : 0;
            const shipping = subtotal >= 10000000 ? 0 : 150000;
            const total = subtotal - discount + shipping;

            // Update display
            document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('discount').textContent = `-Rp ${discount.toLocaleString('id-ID')}`;
            document.getElementById('shipping').textContent = `Rp ${shipping.toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        // Update cart count
        function updateCartCount() {
            const itemCount = document.querySelectorAll('.cart-item').length;
            document.getElementById('cart-count').textContent = `${itemCount} produk dalam keranjang`;
            document.getElementById('item-count').textContent = itemCount;
        }

        // Checkout function
        function checkout() {
            if (document.querySelectorAll('.cart-item').length === 0) {
                alert('Keranjang kosong');
                return;
            }

            // Redirect to checkout page
            window.location.href = '/checkout';
        }

        // Smooth animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.transform = 'translateY(0)';
                    entry.target.style.opacity = '1';
                }
            });
        }, observerOptions);

        // Observe all cart items
        document.querySelectorAll('.animate-fade-in-up').forEach(el => {
            observer.observe(el);
        });

        // Show success/error messages
        @if (session('success'))
            setTimeout(() => {
                alert('{{ session('success') }}');
            }, 100);
        @endif

        @if (session('error'))
            setTimeout(() => {
                alert('{{ session('error') }}');
            }, 100);
        @endif
    </script>
</body>

</html>
