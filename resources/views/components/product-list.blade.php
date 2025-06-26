<!-- Product List Component -->
<div class="mb-12">
    <div class="flex items-center justify-between mb-8 px-4 lg:px-8">
        <h2 class="text-2xl font-bold text-slate-900">
            @if (request('query'))
                Hasil Pencarian
            @elseif(request()->route('category'))
                {{ ucfirst(request()->route('category')) }}
            @else
                Produk Terbaru
            @endif
        </h2>

        <!-- Sort & Filter -->
        <div class="flex items-center space-x-4">
            <select
                class="px-4 py-2 bg-white/80 backdrop-blur-sm border border-slate-200/50 rounded-xl 
                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm cursor-pointer">
                <option value="">Urutkan</option>
                <option value="price_asc">Harga Terendah</option>
                <option value="price_desc">Harga Tertinggi</option>
                <option value="name_asc">Nama A-Z</option>
                <option value="newest">Terbaru</option>
            </select>

            <button
                class="p-2 bg-white/80 backdrop-blur-sm border border-slate-200/50 rounded-xl 
                          hover:bg-white/90 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Product Grid - Full Width -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 px-4 lg:px-8">
        @forelse($products as $product)
            <div
                class="group bg-white/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 shadow-lg 
                    hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden flex flex-col h-full">

                <!-- Product Image Section -->
                <div class="relative flex-shrink-0">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                        class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">

                    <!-- Discount Badge -->
                    @if ($product['discount'])
                        <div
                            class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-pink-500 text-white 
                           px-2 py-1 rounded-lg text-xs font-bold shadow-lg">
                            -{{ $product['discount'] }}%
                        </div>
                    @endif
                </div>

                <!-- Product Info Section - Growing flex container -->
                <div class="p-5 flex flex-col flex-grow items-center">
                    <!-- Category Badge -->
                    <div class="mb-2 flex-shrink-0">
                        <span
                            class="inline-block px-2 py-1 bg-slate-100 text-slate-600 text-xs 
                                font-medium rounded-lg capitalize">
                            {{ $product['category'] }}
                        </span>
                    </div>

                    <!-- Product Name - Fixed height with line clamp -->
                    <h3
                        class="font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors 
                             line-clamp-2 min-h-[3rem] flex items-start flex-shrink-0 text-center">
                        {{ $product['name'] }}
                    </h3>

                    <!-- Rating - Fixed height -->
                    <div class="flex items-center mb-3 flex-shrink-0 h-5">
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= floor($product['rating']) ? 'text-yellow-400' : 'text-slate-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-slate-600 ml-2">
                            {{ $product['rating'] }} ({{ $product['reviews'] }})
                        </span>
                    </div>

                    <!-- Price Section - Fixed height -->
                    <div class="flex items-center justify-between mb-4 flex-shrink-0 min-h-[2rem]">
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-slate-900">
                                Rp {{ number_format($product['price'], 0, ',', '.') }}
                            </span>
                            @if ($product['original_price'])
                                <span class="text-sm text-slate-500 line-through">
                                    Rp {{ number_format($product['original_price'], 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons - Always at bottom -->
                    <div class="flex space-x-2 mt-auto flex-shrink-0 w-full">
                        <button
                            class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white 
                                  py-2.5 px-4 rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 
                                  transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center cursor-pointer">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01">
                                </path>
                            </svg>
                            Keranjang
                        </button>
                        <button
                            class="p-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors flex-shrink-0 cursor-pointer">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
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
    </div>

    <!-- Load More Button -->
    @if (count($products) > 0)
        <div class="text-center mt-12">
            <button
                class="px-8 py-3 bg-white/80 backdrop-blur-sm border border-slate-200/50 
                      rounded-xl text-slate-700 font-medium hover:bg-white hover:shadow-lg 
                      transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-500/20 cursor-pointer">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
                Muat Lebih Banyak
            </button>
        </div>
    @endif
</div>
