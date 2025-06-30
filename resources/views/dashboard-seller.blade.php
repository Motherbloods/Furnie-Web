@extends('layouts.app')

@section('title', 'Dashboard Seller - Furnie')

@section('content')
    <!-- Store Banner -->
    <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-700 rounded-2xl p-8 mb-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <div class="bg-white/20 backdrop-blur-lg p-4 rounded-2xl border border-white/30">
                        <img src="https://via.placeholder.com/80" alt="Logo Toko" class="w-16 h-16 rounded-xl">
                    </div>
                    <div class="absolute -top-2 -right-2 bg-green-400 w-6 h-6 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-xs"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-2">{{ auth()->user()->seller->store_name ?? 'Nama Toko Belum Ada' }}
                    </h2>
                    <p class="text-white/80 text-lg">
                        {{ auth()->user()->seller->store_description ?? 'Belum ada deskripsi' }}</p>
                    <div class="flex items-center mt-2 space-x-4">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-store mr-1"></i>Toko Aktif
                        </span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-clock mr-1"></i>Bergabung 2023
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('profile.view') }}"
                    class="bg-white/20 backdrop-blur-lg border border-white/30 hover:bg-white/30 px-6 py-3 rounded-xl text-sm font-medium text-white transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-edit mr-2"></i>Edit Profile
                </a>
            </div>

        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Produk</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $products->count() }}</p>

                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-2xl shadow-lg">
                    <i class="fas fa-box text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Rating Toko</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <p class="text-3xl font-bold text-gray-900">
                            {{ $products->first()?->seller?->rating_toko ?? '0' }}
                        </p>
                        <div class="flex text-yellow-400">
                            @php
                                $rating = floatval($products->first()?->seller?->rating_toko ?? 0);
                                $fullStars = floor($rating); // Bintang penuh
                                $hasHalfStar = $rating - $fullStars >= 0.5; // Apakah ada setengah bintang
                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0); // Bintang kosong
                            @endphp

                            {{-- Bintang penuh --}}
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star text-sm"></i>
                            @endfor

                            {{-- Setengah bintang --}}
                            @if ($hasHalfStar)
                                <i class="fas fa-star-half-alt text-sm"></i>
                            @endif

                            {{-- Bintang kosong --}}
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star text-sm"></i>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-orange-500 p-4 rounded-2xl shadow-lg">
                    <i class="fas fa-star text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-8" aria-label="Tabs">
                <button
                    class="tab-button active border-b-3 border-indigo-500 py-6 px-2 text-sm font-semibold text-indigo-600 flex items-center"
                    data-tab="products">
                    <i class="fas fa-box mr-3 text-lg"></i>Produk Saya
                    <span
                        class="bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full text-xs ml-2">{{ $products->count() }}</span>
                </button>f
                <button
                    class="tab-button border-b-3 border-transparent py-6 px-2 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center transition-all duration-200"
                    data-tab="orders">
                    <i class="fas fa-clipboard-list mr-3 text-lg"></i>Pesanan Saya
                    <span
                        class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs ml-2">{{ $orders->count() }}</span>
                </button>
            </nav>
        </div>

        <!-- Products Tab -->
        <div id="products-tab" class="tab-content p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Produk Saya</h3>
                    <p class="text-gray-600">Kelola semua produk yang Anda jual</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('seller.product.create') }}"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-2 rounded-xl text-sm font-medium transition-all duration-300 transform hover:scale-105 shadow-lg inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                    </a>

                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    @php

                        $productRating = floatval($product->rating);
                        $fullStars = floor($productRating);
                        $hasHalfStar = $productRating - $fullStars >= 0.5;
                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                    @endphp

                    <div
                        class="bg-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                        <div class="relative mb-4">
                            @php
                                $image = $product->image ?? null;
                                $imageUrl = $image
                                    ? (str_starts_with($image, 'storage/')
                                        ? asset($image)
                                        : asset('storage/' . $image))
                                    : 'https://via.placeholder.com/300x200';
                            @endphp

                            <img src="{{ $imageUrl }}" alt="Product Image" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover rounded-xl group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-3 right-3">
                                @if ($product->stock > 10)
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-check mr-1"></i>Stok Aman
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-exclamation mr-1"></i>Stok Terbatas
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-times mr-1"></i>Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2 text-lg">{{ $product->name }}</h4>
                        <p class="text-indigo-600 font-bold mb-3 text-xl">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-boxes mr-2"></i>Stok: {{ $product->stock }} unit
                            </p>
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star text-xs text-yellow-400"></i>
                            @endfor

                            {{-- Setengah bintang --}}
                            @if ($hasHalfStar)
                                <i class="fas fa-star-half-alt text-xs text-yellow-400"></i>
                            @endif

                            {{-- Bintang kosong --}}
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star text-xs text-yellow-400"></i>
                            @endfor
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('seller.product.edit', $product->id) }}"
                                class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-medium text-center transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>

                            <form action="{{ route('seller.product.destroy', $product->id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-trash mr-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-box text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada produk</h3>
                        <p class="text-gray-600 mb-6">Mulai jual produk pertama Anda dan raih keuntungan!</p>
                        <button
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>Tambah Produk Sekarang
                        </button>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Orders Tab -->
        <div id="orders-tab" class="tab-content p-8 hidden">
            {{-- <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Pesanan Saya</h3>
                    <p class="text-gray-600">Kelola semua pesanan yang masuk</p>
                </div>
                <div class="flex space-x-3">
                    <select id="statusFilter"
                        class="border border-gray-300 rounded-xl px-4 py-2 text-sm font-medium bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Pesanan</option>
                        <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                        <option value="diproses">Perlu Diproses</option>
                        <option value="dikirim">Perlu Dikirim</option>
                        <option value="selesai">Selesai</option>
                        <option value="canceled">Dibatalkan</option>
                    </select>
                    <button
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div> --}}

            <!-- Status Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-700">{{ $orderCounts['menunggu_konfirmasi'] ?? 0 }}</div>
                    <div class="text-sm text-yellow-600">Menunggu Konfirmasi</div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-purple-700">{{ $orderCounts['diproses'] ?? 0 }}</div>
                    <div class="text-sm text-purple-600">Perlu Diproses dan Perlu Dikirim</div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-blue-700">{{ $orderCounts['dikirim'] ?? 0 }}</div>
                    <div class="text-sm text-blue-600">Dikirim</div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-green-700">{{ $orderCounts['selesai'] ?? 0 }}</div>
                    <div class="text-sm text-green-600">Selesai</div>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-red-700">{{ $orderCounts['dibatalkan'] ?? 0 }}</div>
                    <div class="text-sm text-red-600">Dibatalkan</div>
                </div>
            </div>
            <div class="space-y-6" id="ordersContainer">
                @forelse ($orders as $order)
                    <div class="order-card bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300"
                        data-status="{{ $order->order_status }}">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="bg-indigo-100 p-3 rounded-xl">
                                    <i class="fas fa-receipt text-indigo-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">#{{ $order->order_id }}</h4>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-calendar mr-2"></i>{{ $order->created_at->format('d F Y, H:i') }}
                                    </p>
                                    @if ($order->user)
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-user mr-2"></i>{{ $order->user->name }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                @php
                                    $status = $order->order_status;
                                    $statusConfig = [
                                        'menunggu_konfirmasi' => [
                                            'bg-yellow-100',
                                            'text-yellow-800',
                                            'border-yellow-200',
                                            'fas fa-clock',
                                            'Menunggu Konfirmasi',
                                        ],
                                        'diproses' => [
                                            'bg-purple-100',
                                            'text-purple-800',
                                            'border-purple-200',
                                            'fas fa-cog',
                                            'Perlu Diproses',
                                        ],
                                        'dikirim' => [
                                            'bg-blue-100',
                                            'text-blue-800',
                                            'border-blue-200',
                                            'fas fa-truck',
                                            'Dikirim',
                                        ],
                                        'selesai' => [
                                            'bg-green-100',
                                            'text-green-800',
                                            'border-green-200',
                                            'fas fa-check-circle',
                                            'Selesai',
                                        ],
                                        'canceled' => [
                                            'bg-red-100',
                                            'text-red-800',
                                            'border-red-200',
                                            'fas fa-times-circle',
                                            'Dibatalkan',
                                        ],
                                    ];
                                    $config = $statusConfig[$status] ?? [
                                        'bg-gray-100',
                                        'text-gray-800',
                                        'border-gray-200',
                                        'fas fa-question',
                                        ucfirst($status),
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold border {{ $config[0] }} {{ $config[1] }} {{ $config[2] }}">
                                    <i class="{{ $config[3] }} mr-2"></i>{{ $config[4] }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Items dari Seller Ini Saja -->
                        @php
                            $sellerItems = $orderItems->where('order_id', $order->id);
                            $sellerTotal = $sellerItems->sum(fn($item) => $item->price * $item->quantity);
                        @endphp

                        <div class="bg-gray-50 rounded-xl p-4 mb-6">
                            <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-box mr-2"></i>Produk yang Dipesan
                            </h5>
                            @foreach ($sellerItems as $item)
                                @if ($item->product && $item->product->seller_id == Auth::id())
                                    <div class="flex items-center space-x-4 mb-4 last:mb-0">
                                        <img src="{{ $item->product->image ?? 'https://via.placeholder.com/60' }}"
                                            alt="Produk" class="w-16 h-16 rounded-xl object-cover shadow-md">
                                        <div class="flex-1">
                                            <h6 class="font-semibold text-gray-900">{{ $item->product->name }}</h6>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                                <span><i class="fas fa-hashtag mr-1"></i>Qty: {{ $item->quantity }}</span>
                                                <span><i class="fas fa-tag mr-1"></i>Rp
                                                    {{ number_format($item->price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-lg text-gray-900">
                                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <div>
                                <p class="font-bold text-xl text-gray-900">
                                    Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </p>

                                @if ($order->shipping_method)
                                    <p class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-shipping-fast mr-2"></i>{{ $order->shipping_method }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex space-x-3">
                                @if ($order->order_status === 'menunggu_konfirmasi')
                                    <form id="konfirmasiForm" action="{{ route('orders.updateStatus') }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('POST')

                                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                        <input type="hidden" name="is_konfirmasi" value="1">

                                        <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-2xl font-semibold hover:bg-slate-50 transition-all duration-300 hover:scale-105">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Konfirmasi
                                        </button>
                                    </form>
                                @elseif ($order->order_status === 'diproses')
                                    <form id="formKirim" action="/checkout/update-status" method="POST" class="inline"
                                        id="formKirim">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                        <input type="hidden" name="is_dikirim" value="1">

                                        <button type="submit"
                                            class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 transform hover:scale-105">
                                            <i class="fas fa-truck mr-2"></i>Perlu Diproses dan Dikirim
                                        </button>
                                    </form>
                                @endif
                                <button
                                    class="btn-detail px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl font-semibold hover:bg-slate-50 transition-all duration-300 hover:scale-105"
                                    data-order="{{ $order->order_id }}">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Lihat Detail
                                </button>

                            </div>
                        </div>
                    </div>
                    <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 backdrop-blur-sm">
                        <div class="flex items-center justify-center min-h-screen p-4">
                            <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-screen overflow-y-auto">
                                <div class="p-6 border-b border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-2xl font-bold text-slate-900">Detail Pesanan</h3>
                                        <button id="closeModal"
                                            class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div id="modalContent" class="p-6">
                                    <!-- Content will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Toast Notification -->
                    <div id="toast"
                        class="fixed top-4 right-4 bg-white border border-slate-200 rounded-2xl shadow-lg p-4 transform translate-x-full transition-transform duration-300 z-50">
                        <div class="flex items-center space-x-3">
                            <div id="toastIcon" class="w-8 h-8 rounded-full flex items-center justify-center">
                                <!-- Icon will be set dynamically -->
                            </div>
                            <div>
                                <p id="toastTitle" class="font-semibold text-slate-900"></p>
                                <p id="toastMessage" class="text-sm text-slate-600"></p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-shopping-cart text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada pesanan</h3>
                        <p class="text-gray-600 mb-6">Pesanan akan muncul di sini setelah ada yang membeli produk Anda</p>
                        <button
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>Tambah Produk
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const savedTab = localStorage.getItem('activeTab');
            if (savedTab) {
                const button = document.querySelector(`.tab-button[data-tab="${savedTab}"]`);
                if (button) button.click(); // ✅ Klik otomatis tab yang terakhir aktif
            } else {
                // Optional: jika tidak ada, klik tab pertama secara default
                document.querySelector('.tab-button')?.click();
            }
        });

        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');


                localStorage.setItem('activeTab', tabName);
                // Remove active class from all buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });

                // Add active class to clicked button
                this.classList.add('active', 'border-indigo-500', 'text-indigo-600');
                this.classList.remove('border-transparent', 'text-gray-500');

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Show selected tab content
                document.getElementById(tabName + '-tab').classList.remove('hidden');
            });
        });

        function updateSummaryCards(selectedStatus) {
            // This would typically update the summary cards based on filtered results
            // For now, we'll just add a visual indicator
            const summaryCards = document.querySelectorAll('.grid > div');
            summaryCards.forEach(card => {
                if (selectedStatus === '') {
                    card.classList.remove('opacity-50');
                } else {
                    // Add logic to highlight relevant card based on status
                    card.classList.add('opacity-50');
                }
            });
        }

        // Add fade in animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .border-b-3 {
                border-bottom-width: 3px;
            }
        `;
        document.head.appendChild(style);

        function handleFormSubmit(formId) {
            const form = document.getElementById(formId);

            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                console.log('Form Data:', Object.fromEntries(formData.entries()));

                fetch('/checkout/update-status', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async response => {
                        let data;
                        try {
                            data = await response.json();
                        } catch (err) {
                            console.error('Gagal parse JSON:', err);
                            showToast('error', 'Error', 'Response bukan JSON valid');
                            return;
                        }

                        console.log('Response JSON:', data);

                        if (response.ok && data.success) {
                            showToast('success', 'Success', data.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 500)
                        } else {
                            showToast('error', 'Error', data.message || 'Gagal memproses permintaan.');
                        }
                    })
                    .catch(error => {
                        console.error('Errordasd:', error);
                        showToast('error', 'Error', 'Terjadi kesalahan saat mengirim permintaan.');
                    });
            });
        }
        handleFormSubmit('konfirmasiForm');
        handleFormSubmit('formKirim');
        handleFormSubmit('siapkirim');

        function showToast(type, title, message) {
            console.log('Showing toast:', type, title, message);
            const toast = document.getElementById('toast');
            const toastIcon = document.getElementById('toastIcon');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');

            // Set icon and colors based on type
            const types = {
                success: {
                    icon: `<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                               </svg>`,
                    bgColor: 'bg-green-500'
                },
                error: {
                    icon: `<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                               </svg>`,
                    bgColor: 'bg-red-500'
                },
                info: {
                    icon: `<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                               </svg>`,
                    bgColor: 'bg-blue-500'
                }
            };

            const config = types[type] || types.info;

            toastIcon.className = `w-8 h-8 rounded-full flex items-center justify-center ${config.bgColor}`;
            toastIcon.innerHTML = config.icon;
            toastTitle.textContent = title;
            toastMessage.textContent = message;

            // Show toast
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');

            // Hide toast after 4 seconds
            setTimeout(() => {
                toast.classList.remove('translate-x-0');
                toast.classList.add('translate-x-full');
            }, 4000);
        }
    </script>
    <script>
        window.orderData = @json($orders->keyBy('order_id'));
        console.log(orderData);
    </script>
    <script src="{{ asset('js/order-modal.js') }}"></script>
@endsection
