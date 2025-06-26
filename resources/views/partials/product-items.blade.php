@forelse($products as $product)
    <div
        class="group bg-white/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 shadow-lg 
            hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden flex flex-col h-full">

        <!-- Product Image Section -->
        <div class="relative flex-shrink-0">
            <img src="{{ $product['image'] ?? 'https://via.placeholder.com/300x200' }}" alt="{{ $product['name'] }}"
                class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">

            <!-- Discount Badge -->
            @if (isset($product['discount']) && $product['discount'])
                <div
                    class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-pink-500 text-white 
                       px-2 py-1 rounded-lg text-xs font-bold shadow-lg">
                    -{{ $product['discount'] }}%
                </div>
            @endif
        </div>

        <!-- Product Info Section -->
        <div class="p-5 flex flex-col flex-grow items-center">
            <!-- Category Badge -->
            <div class="mb-2 flex-shrink-0">
                <span
                    class="inline-block px-2 py-1 bg-slate-100 text-slate-600 text-xs 
                            font-medium rounded-lg capitalize">
                    {{ $product['kategori'] ?? ($product['category'] ?? 'Umum') }}
                </span>
            </div>

            <!-- Product Name -->
            <h3
                class="font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors 
                     line-clamp-2 min-h-[3rem] flex items-start flex-shrink-0 text-center">
                {{ $product['nama'] ?? $product['name'] }}
            </h3>

            <!-- Rating -->
            <div class="flex items-center mb-3 flex-shrink-0 h-5">
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= floor($product['rating'] ?? 4.5) ? 'text-yellow-400' : 'text-slate-300' }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    @endfor
                </div>
                <span class="text-sm text-slate-600 ml-2">
                    {{ $product['rating'] ?? '4.5' }} ({{ $product['reviews'] ?? '0' }})
                </span>
            </div>

            <!-- Price Section -->
            <div class="flex items-center justify-between mb-4 flex-shrink-0 min-h-[2rem]">
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-slate-900">
                        Rp {{ number_format($product['harga'] ?? ($product['price'] ?? 0), 0, ',', '.') }}
                    </span>
                    @if (isset($product['original_price']) && $product['original_price'])
                        <span class="text-sm text-slate-500 line-through">
                            Rp {{ number_format($product['original_price'], 0, ',', '.') }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-2 mt-auto flex-shrink-0 w-full">
                <button
                    class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white 
                              py-2.5 px-4 rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 
                              transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center cursor-pointer">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2-2v4.01">
                        </path>
                    </svg>
                    Keranjang
                </button>
                <button
                    class="p-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors flex-shrink-0 cursor-pointer">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-12">
        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2-2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                </path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-slate-900 mb-2">Produk Tidak Ditemukan</h3>
        <p class="text-slate-600">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
    </div>
@endforelse
