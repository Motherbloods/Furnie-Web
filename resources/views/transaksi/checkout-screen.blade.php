<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Furnie</title>
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

        /* Custom animations */
        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        /* Backdrop blur fallback */
        @supports not (backdrop-filter: blur(12px)) {
            .backdrop-blur-xl {
                background-color: rgba(255, 255, 255, 0.95) !important;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-white to-slate-100 min-h-screen">
    <!-- Navigation Bar (sama seperti yang sudah ada) -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-gray-100/50 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div
                                class="w-11 h-11 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-6H5.41L12 5.59 18.59 12H17v6z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-2xl font-bold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-600 bg-clip-text text-transparent">
                                Furnie
                            </span>
                            <span class="text-xs text-slate-500 font-medium -mt-1">Furniture Store</span>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="/keranjang" class="text-slate-600 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Header -->
        <div class="slide-up mb-8">
            <div class="flex items-center space-x-3 mb-2">
                <a href="/keranjang" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                    Checkout
                </h1>
            </div>
            <p class="text-slate-600">Selesaikan pesanan Anda dengan mudah dan aman</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Information -->
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-slate-200/50 p-8 slide-up">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900">Informasi Pengiriman</h2>
                    </div>

                    <form id="shippingForm" class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                                <input type="text" id="fullName" name="fullName" required
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300"
                                    placeholder="Masukkan nama lengkap">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-slate-700">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone" required
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700">Alamat Lengkap</label>
                            <textarea id="address" name="address" rows="3" required
                                class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 resize-none"
                                placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"></textarea>
                        </div>

                        <div class="grid md:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-slate-700">Kota</label>
                                <input type="text" id="city" name="city" required
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300"
                                    placeholder="Jakarta">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-slate-700">Provinsi</label>
                                <input type="text" id="province" name="province" required
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300"
                                    placeholder="DKI Jakarta">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-slate-700">Kode Pos</label>
                                <input type="text" id="postalCode" name="postalCode" required
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300"
                                    placeholder="12345">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Shipping Method -->
                <div
                    class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-slate-200/50 p-8 slide-up">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900">Metode Pengiriman</h2>
                    </div>

                    <div class="space-y-3">
                        <div class="shipping-option relative">
                            <input type="radio" id="regular" name="shipping" value="regular"
                                class="peer hidden" checked>
                            <label for="regular"
                                class="flex items-center justify-between w-full p-4 bg-slate-50/50 hover:bg-slate-100/50 border border-slate-200 rounded-2xl cursor-pointer transition-all duration-300 peer-checked:border-green-500 peer-checked:bg-green-50/50">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 8h14M5 8a2 2 0 110-4h1.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H20a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Reguler (5-7 hari)</p>
                                        <p class="text-sm text-slate-600">Pengiriman standar dengan keamanan terjamin
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-900">Rp 25.000</p>
                                    <div
                                        class="w-6 h-6 border-2 border-slate-300 rounded-full peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100">
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="shipping-option relative">
                            <input type="radio" id="express" name="shipping" value="express"
                                class="peer hidden">
                            <label for="express"
                                class="flex items-center justify-between w-full p-4 bg-slate-50/50 hover:bg-slate-100/50 border border-slate-200 rounded-2xl cursor-pointer transition-all duration-300 peer-checked:border-blue-500 peer-checked:bg-blue-50/50">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Express (2-3 hari)</p>
                                        <p class="text-sm text-slate-600">Pengiriman cepat untuk kebutuhan mendesak</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-900">Rp 50.000</p>
                                    <div
                                        class="w-6 h-6 border-2 border-slate-300 rounded-full peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100">
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="shipping-option relative">
                            <input type="radio" id="sameday" name="shipping" value="sameday"
                                class="peer hidden">
                            <label for="sameday"
                                class="flex items-center justify-between w-full p-4 bg-slate-50/50 hover:bg-slate-100/50 border border-slate-200 rounded-2xl cursor-pointer transition-all duration-300 peer-checked:border-purple-500 peer-checked:bg-purple-50/50">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Same Day (Hari ini)</p>
                                        <p class="text-sm text-slate-600">Khusus Jakarta & sekitarnya</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-900">Rp 75.000</p>
                                    <div
                                        class="w-6 h-6 border-2 border-slate-300 rounded-full peer-checked:border-purple-500 peer-checked:bg-purple-500 flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100">
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="space-y-6">
                <!-- Order Items -->
                <div
                    class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-slate-200/50 p-6 slide-up">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Pesanan</h3>

                    <!-- Sample Items -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center space-x-4 p-4 bg-slate-50/50 rounded-2xl">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-slate-900">Kursi Gaming RGB</h4>
                                <p class="text-sm text-slate-600">Qty: 1</p>
                            </div>
                            <p class="font-bold text-slate-900">Rp 2.500.000</p>
                        </div>

                        <div class="flex items-center space-x-4 p-4 bg-slate-50/50 rounded-2xl">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-slate-900">Meja Kerja Minimalis</h4>
                                <p class="text-sm text-slate-600">Qty: 1</p>
                            </div>
                            <p class="font-bold text-slate-900">Rp 1.200.000</p>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="border-t border-slate-200/60 pt-4 space-y-3">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span>Rp 3.700.000</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Ongkos Kirim</span>
                            <span id="shippingCost">Rp 25.000</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Pajak (11%)</span>
                            <span>Rp 407.000</span>
                        </div>
                        <div class="border-t border-slate-200/60 pt-3">
                            <div class="flex justify-between text-lg font-bold text-slate-900">
                                <span>Total</span>
                                <span id="totalAmount">Rp 4.132.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div
                    class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-slate-200/50 p-6 slide-up">
                    <div class="flex items-center space-x-3 mb-4">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Metode Pembayaran</h3>
                    </div>

                    <div
                        class="bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 rounded-2xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-emerald-800">Midtrans Payment</p>
                                <p class="text-sm text-emerald-600">Berbagai metode pembayaran tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button id="checkoutBtn"
                    class="w-full bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-xl hover:shadow-2xl slide-up">
                    <div class="flex items-center justify-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        <span>Bayar Sekarang</span>
                        <span id="totalInBtn">Rp 4.132.000</span>
                    </div>
                </button>

                <!-- Security Info -->
                <div class="text-center text-sm text-slate-500 fade-in">
                    <div class="flex items-center justify-center space-x-2 mb-2">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Pembayaran aman dengan enkripsi SSL</span>
                    </div>
                    <p>Data pribadi Anda dilindungi dengan keamanan tingkat bank</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Shipping cost calculator
            const shippingOptions = document.querySelectorAll('input[name="shipping"]');
            const shippingCostElement = document.getElementById('shippingCost');
            const totalAmountElement = document.getElementById('totalAmount');
            const totalInBtnElement = document.getElementById('totalInBtn');

            const shippingCosts = {
                'regular': 25000,
                'express': 50000,
                'sameday': 75000
            };

            const subtotal = 3700000;
            const tax = 407000;

            function updateTotal() {
                const selectedShipping = document.querySelector('input[name="shipping"]:checked').value;
                const shippingCost = shippingCosts[selectedShipping];
                const total = subtotal + shippingCost + tax;

                shippingCostElement.textContent = `Rp ${shippingCost.toLocaleString('id-ID')}`;
                totalAmountElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
                totalInBtnElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            shippingOptions.forEach(option => {
                option.addEventListener('change', updateTotal);
            });

            // Form validation and checkout
            const checkoutBtn = document.getElementById('checkoutBtn');
            const shippingForm = document.getElementById('shippingForm');

            checkoutBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Validate form
                const formData = new FormData(shippingForm);
                const isValid = shippingForm.checkValidity();

                if (!isValid) {
                    shippingForm.reportValidity();
                    return;
                }

                // Show loading state
                const originalText = checkoutBtn.innerHTML;
                checkoutBtn.innerHTML = `
                    <div class="flex items-center justify-center space-x-3">
                        <svg class="animate-spin w-6 h-6" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memproses...</span>
                    </div>
                `;
                checkoutBtn.disabled = true;

                // Simulate API call
                setTimeout(() => {
                    // Here you would integrate with Midtrans
                    // For now, we'll show success message
                    showSuccessMessage();
                    checkoutBtn.innerHTML = originalText;
                    checkoutBtn.disabled = false;
                }, 2000);
            });

            function showSuccessMessage() {
                const successDiv = document.createElement('div');
                successDiv.className =
                    'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50';
                successDiv.innerHTML = `
                    <div class="bg-white rounded-3xl p-8 max-w-md mx-4 text-center transform scale-95 opacity-0 transition-all duration-300">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Pesanan Berhasil!</h3>
                        <p class="text-slate-600 mb-6">Anda akan diarahkan ke halaman pembayaran Midtrans</p>
                        <button onclick="this.parentElement.parentElement.remove()" 
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-xl transition-colors">
                            OK
                        </button>
                    </div>
                `;

                document.body.appendChild(successDiv);

                // Animate in
                setTimeout(() => {
                    const modal = successDiv.querySelector('div');
                    modal.style.transform = 'scale(1)';
                    modal.style.opacity = '1';
                }, 100);
            }

            // Enhanced animations for shipping options
            const shippingLabels = document.querySelectorAll('.shipping-option label');
            shippingLabels.forEach(label => {
                label.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(4px)';
                });

                label.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Form field animations
            const formInputs = document.querySelectorAll('input, textarea');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Initialize total calculation
            updateTotal();

            // Smooth scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all slide-up elements
            document.querySelectorAll('.slide-up').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'all 0.6s ease-out';
                observer.observe(el);
            });
        });

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = value.substring(1);
            }
            if (value.length > 0) {
                value = '08' + value;
            }
            e.target.value = value;
        });

        // Postal code formatting
        document.getElementById('postalCode').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5);
            }
            e.target.value = value;
        });
    </script>
</body>

</html>
