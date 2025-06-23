<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Furnie</title>
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
                        <p class="text-sm text-slate-500">3 produk dalam keranjang</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button
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
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Cart Item 1 -->
                <div
                    class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-lg border border-slate-200/50 p-6 animate-fade-in-up hover:shadow-xl transition-all duration-300">
                    <div class="flex items-start space-x-6">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=150&h=150&fit=crop&crop=center"
                                alt="Sofa Modern" class="w-24 h-24 rounded-2xl object-cover shadow-md">
                            <div
                                class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Sofa Modern Minimalis</h3>
                            <p class="text-sm text-slate-600 mb-3">Warna: Abu-abu | Ukuran: 3 Seater</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <button
                                        class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl flex items-center justify-center transition-all duration-200">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="text-lg font-semibold text-slate-900 min-w-[2rem] text-center">1</span>
                                    <button
                                        class="w-10 h-10 bg-emerald-100 hover:bg-emerald-200 rounded-xl flex items-center justify-center transition-all duration-200">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-slate-900">Rp 2.500.000</p>
                                    <p class="text-sm text-slate-500 line-through">Rp 3.000.000</p>
                                </div>
                            </div>
                        </div>
                        <button
                            class="w-10 h-10 bg-red-100/70 hover:bg-red-200/70 rounded-xl flex items-center justify-center transition-all duration-200 group">
                            <svg class="w-5 h-5 text-red-600 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-lg border border-slate-200/50 p-6 animate-fade-in-up hover:shadow-xl transition-all duration-300"
                    style="animation-delay: 0.1s">
                    <div class="flex items-start space-x-6">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=150&h=150&fit=crop&crop=center"
                                alt="Meja Makan" class="w-24 h-24 rounded-2xl object-cover shadow-md">
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Meja Makan Kayu Jati</h3>
                            <p class="text-sm text-slate-600 mb-3">Material: Kayu Jati | Kapasitas: 6 Orang</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <button
                                        class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl flex items-center justify-center transition-all duration-200">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="text-lg font-semibold text-slate-900 min-w-[2rem] text-center">1</span>
                                    <button
                                        class="w-10 h-10 bg-emerald-100 hover:bg-emerald-200 rounded-xl flex items-center justify-center transition-all duration-200">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-slate-900">Rp 4.200.000</p>
                                </div>
                            </div>
                        </div>
                        <button
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

                <!-- Cart Item 3 -->
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-lg border border-slate-200/50 p-6 animate-fade-in-up hover:shadow-xl transition-all duration-300"
                    style="animation-delay: 0.2s">
                    <div class="flex items-start space-x-6">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1549497538-303791108f95?w=150&h=150&fit=crop&crop=center"
                                alt="Lemari Pakaian" class="w-24 h-24 rounded-2xl object-cover shadow-md">
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Lemari Pakaian 3 Pintu</h3>
                            <p class="text-sm text-slate-600 mb-3">Warna: Cokelat | Material: MDF</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <button
                                        class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl flex items-center justify-center transition-all duration-200">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span
                                        class="text-lg font-semibold text-slate-900 min-w-[2rem] text-center">1</span>
                                    <button
                                        class="w-10 h-10 bg-emerald-100 hover:bg-emerald-200 rounded-xl flex items-center justify-center transition-all duration-200">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-slate-900">Rp 1.800.000</p>
                                </div>
                            </div>
                        </div>
                        <button
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
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div
                    class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-lg border border-slate-200/50 p-6 animate-fade-in-up-delay sticky top-28">
                    <h2 class="text-xl font-bold text-slate-900 mb-6">Ringkasan Pesanan</h2>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600">Subtotal (3 produk)</span>
                            <span class="font-semibold text-slate-900">Rp 8.500.000</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-slate-600">Diskon</span>
                            <span class="font-semibold text-emerald-600">-Rp 500.000</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-slate-600">Ongkos Kirim</span>
                            <span class="font-semibold text-slate-900">Rp 150.000</span>
                        </div>

                        <div class="border-t border-slate-200/60 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-slate-900">Total</span>
                                <span class="text-2xl font-bold text-slate-900">Rp 8.150.000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <button
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

                <!-- Shipping Info -->

            </div>
        </div>


    </div>

    <script>
        // Quantity update functionality
        document.querySelectorAll('button').forEach(button => {
            if (button.querySelector('svg path[d*="M20 12H4"]')) {
                button.addEventListener('click', function() {
                    const quantitySpan = this.parentElement.querySelector('span');
                    let quantity = parseInt(quantitySpan.textContent);
                    if (quantity > 1) {
                        quantitySpan.textContent = quantity - 1;
                        updateTotal();
                    }
                });
            } else if (button.querySelector('svg path[d*="M12 6v6m0 0v6m0-6h6m-6 0H6"]')) {
                button.addEventListener('click', function() {
                    const quantitySpan = this.parentElement.querySelector('span');
                    let quantity = parseInt(quantitySpan.textContent);
                    quantitySpan.textContent = quantity + 1;
                    updateTotal();
                });
            }
        });

        // Remove item functionality
        document.querySelectorAll('button').forEach(button => {
            if (button.querySelector('svg path[d*="M19 7l-.867 12.142"]')) {
                button.addEventListener('click', function() {
                    const cartItem = this.closest('.bg-white\\/70');
                    cartItem.style.transform = 'translateX(100%)';
                    cartItem.style.opacity = '0';
                    setTimeout(() => {
                        cartItem.remove();
                        updateTotal();
                        updateCartCount();
                    }, 300);
                });
            }
        });

        function updateTotal() {
            // Simulate total calculation
            console.log('Total updated');
        }

        function updateCartCount() {
            const remainingItems = document.querySelectorAll('.bg-white\\/70').length;
            const countElement = document.querySelector('p.text-sm.text-slate-500');
            if (countElement) {
                countElement.textContent = `${remainingItems} produk dalam keranjang`;
            }
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
    </script>
</body>

</html>
