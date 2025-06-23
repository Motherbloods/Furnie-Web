@extends('layouts.app')

@section('title', 'Pesanan Saya - Furnie')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100/50">
        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl border-b border-gray-100/50 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="flex items-center justify-between">
                    <div>
                        <h1
                            class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-600 bg-clip-text text-transparent">
                            Pesanan Saya
                        </h1>
                        <p class="text-slate-600 mt-2">Pantau status dan riwayat pesanan furniture Anda</p>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl border border-slate-200/50 shadow-lg p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-3">
                        <button
                            class="px-6 py-3 bg-blue-500 text-white rounded-2xl font-semibold shadow-md hover:bg-blue-600 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Semua Pesanan
                        </button>
                        <button
                            class="px-6 py-3 bg-white/80 text-slate-700 rounded-2xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Menunggu Pembayaran
                        </button>
                        <button
                            class="px-6 py-3 bg-white/80 text-slate-700 rounded-2xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Diproses
                        </button>
                        <button
                            class="px-6 py-3 bg-white/80 text-slate-700 rounded-2xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Selesai
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="Cari pesanan..."
                                class="pl-12 pr-4 py-3 bg-white/80 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 transform -translate-y-1/2"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            <div class="space-y-6">
                <!-- Order Item 1 - Menunggu Pembayaran -->
                <div
                    class="bg-white/70 backdrop-blur-xl rounded-3xl border border-slate-200/50 shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                    <div class="p-6">
                        <!-- Order Header -->
                        <div
                            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b border-slate-200/50">
                            <div>
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-xl font-bold text-slate-900">#FRN-2024-001</h3>
                                    <span class="px-4 py-2 bg-amber-100 text-amber-800 rounded-full text-sm font-semibold">
                                        Menunggu Pembayaran
                                    </span>
                                </div>
                                <p class="text-slate-600">Dipesan pada 20 Juni 2025 • 14:30 WIB</p>
                            </div>
                            <div class="text-right mt-3 md:mt-0">
                                <p class="text-sm text-slate-500">Total Pesanan</p>
                                <p class="text-2xl font-bold text-slate-900">Rp 4.500.000</p>
                            </div>
                        </div>

                        <!-- Product Items -->
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center space-x-4 p-4 bg-slate-50/50 rounded-2xl">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-6H5.41L12 5.59 18.59 12H17v6z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900">Sofa Minimalis Modern</h4>
                                    <p class="text-slate-600">Warna: Abu-abu • Ukuran: L 200cm</p>
                                    <p class="text-sm text-slate-500">Qty: 1 • Rp 3.500.000</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 p-4 bg-slate-50/50 rounded-2xl">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-6H5.41L12 5.59 18.59 12H17v6z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900">Meja Coffee Table</h4>
                                    <p class="text-slate-600">Material: Kayu Jati • Finishing: Natural</p>
                                    <p class="text-sm text-slate-500">Qty: 1 • Rp 1.000.000</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col md:flex-row gap-3 justify-end">
                            <button
                                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl font-semibold shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
                                Bayar Sekarang
                            </button>
                            <button
                                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl font-semibold hover:bg-slate-50 transition-all duration-300 hover:scale-105">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Item 2 - Diproses -->
                <div
                    class="bg-white/70 backdrop-blur-xl rounded-3xl border border-slate-200/50 shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                    <div class="p-6">
                        <!-- Order Header -->
                        <div
                            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b border-slate-200/50">
                            <div>
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-xl font-bold text-slate-900">#FRN-2024-002</h3>
                                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                        Sedang Diproses
                                    </span>
                                </div>
                                <p class="text-slate-600">Dipesan pada 18 Juni 2025 • 10:15 WIB</p>
                            </div>
                            <div class="text-right mt-3 md:mt-0">
                                <p class="text-sm text-slate-500">Total Pesanan</p>
                                <p class="text-2xl font-bold text-slate-900">Rp 2.750.000</p>
                            </div>
                        </div>

                        <!-- Progress Tracker -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-green-700">Pembayaran Dikonfirmasi</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center animate-pulse">
                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-blue-700">Sedang Diproduksi</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-slate-300 rounded-full flex items-center justify-center">
                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                    </div>
                                    <span class="text-sm text-slate-500">Siap Dikirim</span>
                                </div>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-500 to-blue-500 h-2 rounded-full"
                                    style="width: 60%"></div>
                            </div>
                        </div>

                        <!-- Product Items -->
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center space-x-4 p-4 bg-slate-50/50 rounded-2xl">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-6H5.41L12 5.59 18.59 12H17v6z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900">Set Meja Makan Keluarga</h4>
                                    <p class="text-slate-600">Material: Kayu Mahoni • Kapasitas: 6 orang</p>
                                    <p class="text-sm text-slate-500">Qty: 1 set • Rp 2.750.000</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col md:flex-row gap-3 justify-end">
                            <button
                                class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-2xl font-semibold shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
                                Lacak Pesanan
                            </button>
                            <button
                                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl font-semibold hover:bg-slate-50 transition-all duration-300 hover:scale-105">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Item 3 - Selesai -->
                <div
                    class="bg-white/70 backdrop-blur-xl rounded-3xl border border-slate-200/50 shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                    <div class="p-6">
                        <!-- Order Header -->
                        <div
                            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b border-slate-200/50">
                            <div>
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-xl font-bold text-slate-900">#FRN-2024-003</h3>
                                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                        Selesai
                                    </span>
                                </div>
                                <p class="text-slate-600">Dipesan pada 15 Juni 2025 • Diterima 19 Juni 2025</p>
                            </div>
                            <div class="text-right mt-3 md:mt-0">
                                <p class="text-sm text-slate-500">Total Pesanan</p>
                                <p class="text-2xl font-bold text-slate-900">Rp 1.850.000</p>
                            </div>
                        </div>

                        <!-- Product Items -->
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center space-x-4 p-4 bg-slate-50/50 rounded-2xl">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-6H5.41L12 5.59 18.59 12H17v6z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900">Lemari Pakaian 3 Pintu</h4>
                                    <p class="text-slate-600">Material: MDF • Warna: Putih Glossy</p>
                                    <p class="text-sm text-slate-500">Qty: 1 • Rp 1.850.000</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Section -->
                        <div class="bg-emerald-50/50 rounded-2xl p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-emerald-800 mb-1">Bagaimana pengalaman Anda?</p>
                                    <p class="text-xs text-emerald-600">Berikan rating untuk produk ini</p>
                                </div>
                                <div class="flex space-x-1">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col md:flex-row gap-3 justify-end">
                            <button
                                class="px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-2xl font-semibold shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
                                Beri Rating
                            </button>
                            <button
                                class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl font-semibold hover:bg-slate-50 transition-all duration-300 hover:scale-105">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State (jika tidak ada pesanan) -->
            {{-- 
        <div class="text-center py-16">
            <div class="w-32 h-32 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-16 h-16 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Belum Ada Pesanan</h3>
            <p class="text-slate-600 mb-8">Anda belum memiliki pesanan apapun. Mari mulai berbelanja furniture impian Anda!</p>
            <a href="/" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9"></path>
                </svg>
                Mulai Berbelanja
            </a>
        </div>
        --}}

            <!-- Pagination -->
            <div class="flex justify-center mt-12">
                <div class="flex items-center space-x-2">
                    <button
                        class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 hover:bg-slate-50 transition-all duration-300">
                        Sebelumnya
                    </button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-xl font-semibold shadow-md">1</button>
                    <button
                        class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 hover:bg-slate-50 transition-all duration-300">2</button>
                    <button
                        class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 hover:bg-slate-50 transition-all duration-300">3</button>
                    <button
                        class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 hover:bg-slate-50 transition-all duration-300">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter buttons functionality
            const filterButtons = document.querySelectorAll('.bg-blue-500, .bg-white\\/80');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('bg-blue-500', 'text-white');
                        btn.classList.add('bg-white/80', 'text-slate-700', 'border',
                            'border-slate-200');
                    });

                    // Add active class to clicked button
                    this.classList.remove('bg-white/80', 'text-slate-700', 'border',
                        'border-slate-200');
                    this.classList.add('bg-blue-500', 'text-white');
                });
            });

            // Search functionality
            const searchInput = document.querySelector('input[placeholder="Cari pesanan..."]');
            searchInput.addEventListener('input', function() {
                // Implementasi pencarian akan ditambahkan di controller
                console.log('Mencari:', this.value);
            });

            // Rating stars functionality
            const ratingStars = document.querySelectorAll('.text-yellow-400');
            ratingStars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    // Reset all stars
                    ratingStars.forEach(s => s.classList.remove('text-yellow-400'));
                    ratingStars.forEach(s => s.classList.add('text-slate-300'));

                    // Fill stars up to clicked one
                    for (let i = 0; i <= index; i++) {
                        ratingStars[i].classList.remove('text-slate-300');
                        ratingStars[i].classList.add('text-yellow-400');
                    }

                    console.log('Rating:', index + 1);
                });
            });

            // Enhanced hover effects for order cards
            const orderCards = document.querySelectorAll('.bg-white\\/70');
            orderCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.02) translateY(-4px)';
                    this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) translateY(0)';
                    this.style.boxShadow = '';
                });
            });


            // Progress animation for processing orders
            const progressBars = document.querySelectorAll('.bg-gradient-to-r.from-green-500');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                bar.style.transition = 'width 2s ease-in-out';

                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });

            // Auto-refresh untuk status pesanan (opsional)
            setInterval(() => {
                // Implementasi refresh status akan ditambahkan di controller
                console.log('Checking order status updates...');
            }, 30000); // Refresh setiap 30 detik
        });
    </script>
@endsection
