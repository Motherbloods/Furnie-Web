@extends('layouts.app')

@section('title', 'Dashboard Seller - Furnie')

@section('content')
    <!-- Store Banner -->
    <div class="bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700 rounded-xl p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <div class="bg-white p-4 rounded-xl">
                    <img src="https://via.placeholder.com/80" alt="Logo Toko" class="w-16 h-16 rounded-lg">
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-2">{{ auth()->user()->seller->store_name ?? 'Nama Toko Belum Ada' }}
                    </h2>
                    <p class="text-blue-100">{{ auth()->user()->seller->store_description ?? 'Belum ada deskripsi' }}</p>
                </div>
            </div>
            <button class="px-4 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition duration-300">
                <i class="fas fa-edit mr-2"></i>Edit Profile
            </button>

        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Produk</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $products->count() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rating Toko</p>
                    <div class="flex items-center space-x-2">
                        <p class="text-3xl font-bold text-gray-900">4.8</p>
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pesanan Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900">156</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-xl shadow-sm border mb-8">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="tab-button active border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600"
                    data-tab="products">
                    <i class="fas fa-box mr-2"></i>Produk Saya
                </button>
                <button
                    class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300"
                    data-tab="orders">
                    <i class="fas fa-clipboard-list mr-2"></i>Pesanan Saya
                </button>
            </nav>
        </div>

        <!-- Products Tab -->
        <div id="products-tab" class="tab-content p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Produk Saya</h3>
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Produk
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                            class="w-full h-32 object-cover rounded-lg mb-3">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $product->name }}</h4>
                        <p class="text-blue-600 font-bold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600 mb-3">Stok: {{ $product->stock }} unit</p>
                        <div class="flex space-x-2">
                            <a href=""
                                class="flex-1 bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm hover:bg-gray-50 text-center">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-50 border border-red-200 text-red-600 px-3 py-2 rounded-md text-sm hover:bg-red-100">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Orders Tab -->
        <div id="orders-tab" class="tab-content p-6 hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Pesanan Saya</h3>
                <div class="flex space-x-2">
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option>Semua Status</option>
                        <option>Menunggu Konfirmasi</option>
                        <option>Diproses</option>
                        <option>Dikirim</option>
                        <option>Selesai</option>
                    </select>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Order Item 1 -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="font-semibold text-gray-900">#ORDER-001234</p>
                            <p class="text-sm text-gray-600">22 Juni 2025</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">
                            Menunggu Konfirmasi
                        </span>
                    </div>
                    <div class="flex items-center space-x-3 mb-3">
                        <img src="https://via.placeholder.com/60" alt="Produk" class="w-12 h-12 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Smartphone Android Terbaru</p>
                            <p class="text-sm text-gray-600">Qty: 1 × Rp 3.499.000</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-gray-900">Total: Rp 3.499.000</p>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700">
                                Konfirmasi
                            </button>
                            <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md text-sm hover:bg-gray-300">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Item 2 -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="font-semibold text-gray-900">#ORDER-001233</p>
                            <p class="text-sm text-gray-600">21 Juni 2025</p>
                        </div>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                            Selesai
                        </span>
                    </div>
                    <div class="flex items-center space-x-3 mb-3">
                        <img src="https://via.placeholder.com/60" alt="Produk" class="w-12 h-12 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Headphone Wireless</p>
                            <p class="text-sm text-gray-600">Qty: 2 × Rp 899.000</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-gray-900">Total: Rp 1.798.000</p>
                        <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md text-sm hover:bg-gray-300">
                            Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script>
        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');

                // Remove active class from all buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });

                // Add active class to clicked button
                this.classList.add('active', 'border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500');

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Show selected tab content
                document.getElementById(tabName + '-tab').classList.remove('hidden');
            });
        });
    </script>
@endsection
