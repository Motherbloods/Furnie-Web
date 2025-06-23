@extends('layouts.app')

@section('title', 'Product Detail')

@section('content')
    <!-- Product Detail Component -->
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
        <div class="max-w-7xl mx-auto px-4 py-8">
            @php
                // Sample product data - replace with actual data from database
                $product = [
                    'id' => 1,
                    'name' => 'Meja Kerja Modern Premium',
                    'category' => 'meja',
                    'price' => 1500000,
                    'original_price' => 2000000,
                    'images' => [
                        'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&h=600&fit=crop',
                        'https://images.unsplash.com/photo-1549497538-303791108f95?w=600&h=600&fit=crop',
                        'https://images.unsplash.com/photo-1549497538-303791108f95?w=600&h=600&fit=crop&sat=-100',
                        'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&h=600&fit=crop&sat=-50',
                    ],
                    'rating' => 4.8,
                    'reviews' => 124,
                    'discount' => 25,
                    'stock' => 15,
                    'description' =>
                        'Meja kerja modern dengan desain minimalis yang cocok untuk ruang kerja Anda. Terbuat dari bahan berkualitas tinggi dengan finishing yang elegan. Dilengkapi dengan laci penyimpanan dan kabel management yang rapi.',
                    'specifications' => [
                        'Material' => 'Kayu Oak Premium',
                        'Dimensi' => '120 x 60 x 75 cm',
                        'Berat' => '25 kg',
                        'Warna' => 'Natural Wood',
                        'Garansi' => '2 Tahun',
                        'Assembly' => 'Required',
                    ],
                    'features' => [
                        'Desain minimalis dan modern',
                        'Laci penyimpanan tersembunyi',
                        'Cable management system',
                        'Permukaan anti-gores',
                        'Kaki meja adjustable',
                        'Eco-friendly material',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div
                        class="aspect-square bg-white/60 backdrop-blur-sm rounded-3xl border border-slate-200/50 shadow-lg overflow-hidden">
                        <img id="mainImage" src="{{ $product['images'][0] }}" alt="{{ $product['name'] }}"
                            class="w-full h-full object-cover">

                        @if ($product['discount'])
                            <div
                                class="absolute top-6 left-6 bg-gradient-to-r from-red-500 to-pink-500 text-white 
                                   px-4 py-2 rounded-xl text-sm font-bold shadow-lg z-10">
                                -{{ $product['discount'] }}%
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Images -->
                    <div class="grid grid-cols-4 gap-3">
                        @foreach ($product['images'] as $index => $image)
                            <button onclick="changeMainImage('{{ $image }}')"
                                class="aspect-square bg-white/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 
                                       shadow-lg overflow-hidden hover:border-blue-500 hover:shadow-xl transition-all 
                                       duration-300 cursor-pointer">
                                <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}"
                                    class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Category Badge -->
                    <div>
                        <span
                            class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-sm 
                                font-medium rounded-lg capitalize">
                            {{ $product['category'] }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl lg:text-4xl font-bold text-slate-900">{{ $product['name'] }}</h1>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= floor($product['rating']) ? 'text-yellow-400' : 'text-slate-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-lg font-semibold text-slate-900">{{ $product['rating'] }}</span>
                        <span class="text-slate-600">({{ $product['reviews'] }} ulasan)</span>

                    </div>

                    <!-- Price -->
                    <div class="space-y-2">
                        <div class="flex items-center space-x-4">
                            <span class="text-3xl font-bold text-slate-900">
                                Rp {{ number_format($product['price'], 0, ',', '.') }}
                            </span>
                            @if ($product['original_price'])
                                <span class="text-xl text-slate-500 line-through">
                                    Rp {{ number_format($product['original_price'], 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        @if ($product['discount'])
                            <p class="text-green-600 font-medium">
                                Hemat Rp {{ number_format($product['original_price'] - $product['price'], 0, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center space-x-2">
                        @if ($product['stock'] > 0)
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-green-600 font-medium">Stok tersedia ({{ $product['stock'] }} unit)</span>
                        @else
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-red-600 font-medium">Stok habis</span>
                        @endif
                    </div>

                    <!-- Quantity Selector -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-slate-700">Jumlah:</label>
                        <div class="flex items-center space-x-3">
                            <button onclick="decreaseQuantity()"
                                class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl flex items-center 
                                       justify-center transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </button>
                            <input type="number" id="quantity" value="1" min="1"
                                max="{{ $product['stock'] }}"
                                class="w-16 h-10 text-center border border-slate-200 rounded-xl focus:outline-none 
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button onclick="increaseQuantity()"
                                class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl flex items-center 
                                       justify-center transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-6 
                                  rounded-2xl font-semibold text-lg hover:from-blue-700 hover:to-purple-700 
                                  transition-all duration-300 shadow-lg hover:shadow-xl flex items-center 
                                  justify-center space-x-2 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01">
                                </path>
                            </svg>
                            <span>Tambah ke Keranjang</span>
                        </button>

                        <button
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-4 rounded-xl 
                                      font-medium transition-colors flex items-center justify-center space-x-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>Beli Sekarang</span>
                        </button>

                    </div>

                    <!-- Quick Info -->
                    <div class="bg-blue-50/50 backdrop-blur-sm rounded-2xl p-4 border border-blue-200/50">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="text-slate-700">Gratis Ongkir</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-slate-700">Garansi 2 Tahun</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                                <span class="text-slate-700">Cicilan 0%</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                                <span class="text-slate-700">Return 7 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="bg-white/60 backdrop-blur-sm rounded-3xl border border-slate-200/50 shadow-lg overflow-hidden">
                <!-- Tab Navigation -->
                <div class="border-b border-slate-200/50">
                    <nav class="flex">
                        <button onclick="showTab('description')"
                            class="tab-button active px-8 py-6 text-sm font-medium border-b-2 border-transparent 
                                   hover:text-blue-600 hover:border-blue-300 transition-colors cursor-pointer">
                            Deskripsi
                        </button>
                        <button onclick="showTab('specifications')"
                            class="tab-button px-8 py-6 text-sm font-medium border-b-2 border-transparent 
                                   hover:text-blue-600 hover:border-blue-300 transition-colors cursor-pointer">
                            Spesifikasi
                        </button>
                        <button onclick="showTab('reviews')"
                            class="tab-button px-8 py-6 text-sm font-medium border-b-2 border-transparent 
                                   hover:text-blue-600 hover:border-blue-300 transition-colors cursor-pointer">
                            Ulasan ({{ $product['reviews'] }})
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-8">
                    <!-- Description Tab -->
                    <div id="description" class="tab-content">
                        <div class="prose max-w-none">
                            <p class="text-slate-700 text-lg leading-relaxed mb-6">{{ $product['description'] }}</p>

                            <h3 class="text-xl font-bold text-slate-900 mb-4">Fitur Unggulan:</h3>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($product['features'] as $feature)
                                    <li class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-slate-700">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    <div id="specifications" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($product['specifications'] as $key => $value)
                                <div class="flex items-center justify-between py-3 border-b border-slate-200/50">
                                    <span class="font-medium text-slate-900">{{ $key }}:</span>
                                    <span class="text-slate-700">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div id="reviews" class="tab-content hidden">
                        <div class="space-y-6">
                            <!-- Review Summary -->
                            <div class="bg-slate-50/50 rounded-2xl p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="text-center">
                                        <div class="text-4xl font-bold text-slate-900 mb-2">{{ $product['rating'] }}</div>
                                        <div class="flex items-center justify-center mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= floor($product['rating']) ? 'text-yellow-400' : 'text-slate-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="text-slate-600">{{ $product['reviews'] }} ulasan</p>
                                    </div>
                                    <div class="space-y-2">
                                        @foreach ([5, 4, 3, 2, 1] as $star)
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-slate-600 w-8">{{ $star }}</span>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                <div class="flex-1 bg-slate-200 rounded-full h-2">
                                                    <div class="bg-yellow-400 h-2 rounded-full"
                                                        style="width: {{ $star == 5 ? '70' : ($star == 4 ? '20' : '5') }}%">
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm text-slate-600 w-8">{{ $star == 5 ? '87' : ($star == 4 ? '25' : ($star == 3 ? '6' : ($star == 2 ? '4' : '2'))) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Individual Reviews -->
                            <div class="space-y-4">
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="bg-white/50 rounded-2xl p-6 border border-slate-200/50">
                                        <div class="flex items-start space-x-4">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ chr(64 + $i) }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="font-semibold text-slate-900">Pembeli {{ $i }}
                                                    </h4>
                                                    <span class="text-sm text-slate-500">{{ $i }} hari yang
                                                        lalu</span>
                                                </div>
                                                <div class="flex items-center mb-3">
                                                    @for ($j = 1; $j <= 5; $j++)
                                                        <svg class="w-4 h-4 {{ $j <= 6 - $i ? 'text-yellow-400' : 'text-slate-300' }}"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                            </path>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <p class="text-slate-700">
                                                    {{ $i == 1 ? 'Produk sangat berkualitas dan sesuai dengan deskripsi. Pengiriman cepat dan packing aman.' : ($i == 2 ? 'Meja kerja yang bagus, desainnya modern dan pas untuk ruang kerja saya.' : 'Kualitas kayu premium, finishing rapi. Sangat puas dengan pembelian ini.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <!-- Write Review Button -->
                            <div class="text-center">
                                <button
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl 
                                          font-medium transition-colors cursor-pointer">
                                    Tulis Ulasan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeMainImage(imageSrc) {
            document.getElementById('mainImage').src = imageSrc;
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.max);
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        }

        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active', 'text-blue-600', 'border-blue-500');
                button.classList.add('text-slate-600');
            });

            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');

            // Add active class to clicked tab button
            event.target.classList.add('active', 'text-blue-600', 'border-blue-500');
            event.target.classList.remove('text-slate-600');
        }

        // Initialize first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            const firstTabButton = document.querySelector('.tab-button');
            firstTabButton.classList.add('text-blue-600', 'border-blue-500');
            firstTabButton.classList.remove('text-slate-600');
        });
    </script>

    <style>
        .tab-button.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        .tab-button {
            color: #64748b;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom scrollbar for mobile */
        @media (max-width: 768px) {
            .overflow-x-auto::-webkit-scrollbar {
                height: 4px;
            }

            .overflow-x-auto::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 2px;
            }

            .overflow-x-auto::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 2px;
            }

            .overflow-x-auto::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .grid.grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 0.5rem;
            }

            .text-3xl.lg\\:text-4xl {
                font-size: 1.875rem;
                line-height: 2.25rem;
            }

            .px-8.py-6 {
                padding: 1rem 1.5rem;
            }
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Hover effects for buttons */
        .cursor-pointer:hover {
            transform: translateY(-1px);
        }

        /* Image zoom effect */
        #mainImage {
            transition: transform 0.3s ease;
        }

        #mainImage:hover {
            transform: scale(1.05);
        }

        /* Gradient backgrounds */
        .bg-gradient-to-r.from-blue-600.to-purple-600:hover {
            background: linear-gradient(to right, #1d4ed8, #7c3aed);
        }

        .bg-gradient-to-r.from-red-500.to-pink-500 {
            background: linear-gradient(to right, #ef4444, #ec4899);
        }

        /* Glass morphism effect */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }

        /* Custom focus styles */
        .focus\\:ring-2:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        /* Improved mobile navigation */
        @media (max-width: 768px) {
            .tab-button {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
        }
    </style>

    <!-- Related Products Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-slate-900 mb-8">Produk Serupa</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $relatedProducts = [
                    [
                        'id' => 11,
                        'name' => 'Meja Kerja Klasik',
                        'price' => 1200000,
                        'original_price' => 1500000,
                        'image' => 'https://images.unsplash.com/photo-1549497538-303791108f95?w=400&h=300&fit=crop',
                        'rating' => 4.6,
                        'reviews' => 89,
                        'discount' => 20,
                    ],
                    [
                        'id' => 12,
                        'name' => 'Meja Kerja Industrial',
                        'price' => 1800000,
                        'original_price' => null,
                        'image' =>
                            'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop&sat=-30',
                        'rating' => 4.7,
                        'reviews' => 156,
                        'discount' => null,
                    ],
                    [
                        'id' => 13,
                        'name' => 'Meja Kerja Standing',
                        'price' => 2200000,
                        'original_price' => 2500000,
                        'image' =>
                            'https://images.unsplash.com/photo-1549497538-303791108f95?w=400&h=300&fit=crop&hue=180',
                        'rating' => 4.8,
                        'reviews' => 203,
                        'discount' => 12,
                    ],
                    [
                        'id' => 14,
                        'name' => 'Meja Kerja Kompak',
                        'price' => 980000,
                        'original_price' => null,
                        'image' =>
                            'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop&hue=60',
                        'rating' => 4.5,
                        'reviews' => 67,
                        'discount' => null,
                    ],
                ];
            @endphp

            @foreach ($relatedProducts as $relatedProduct)
                <div
                    class="group bg-white/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 shadow-lg 
                        hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">

                    <!-- Product Image -->
                    <div class="relative">
                        <img src="{{ $relatedProduct['image'] }}" alt="{{ $relatedProduct['name'] }}"
                            class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">

                        @if ($relatedProduct['discount'])
                            <div
                                class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-pink-500 text-white 
                                   px-2 py-1 rounded-lg text-xs font-bold shadow-lg">
                                -{{ $relatedProduct['discount'] }}%
                            </div>
                        @endif

                        <!-- Quick View Button -->
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 
                               transition-opacity duration-300 flex items-center justify-center">
                            <button
                                class="bg-white/90 backdrop-blur-sm text-slate-900 px-4 py-2 rounded-xl 
                                      font-medium hover:bg-white transition-colors cursor-pointer">
                                Lihat Detail
                            </button>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-5">
                        <h3 class="font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $relatedProduct['name'] }}
                        </h3>

                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= floor($relatedProduct['rating']) ? 'text-yellow-400' : 'text-slate-300' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-slate-600 ml-2">
                                {{ $relatedProduct['rating'] }} ({{ $relatedProduct['reviews'] }})
                            </span>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-lg font-bold text-slate-900">
                                    Rp {{ number_format($relatedProduct['price'], 0, ',', '.') }}
                                </span>
                                @if ($relatedProduct['original_price'])
                                    <span class="text-sm text-slate-500 line-through block">
                                        Rp {{ number_format($relatedProduct['original_price'], 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        <button
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white 
                                  py-2.5 px-4 rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 
                                  transition-all duration-300 shadow-lg hover:shadow-xl cursor-pointer">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
