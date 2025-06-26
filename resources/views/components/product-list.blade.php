<!-- Product List Component -->
<div class="mb-12" id="product-list-section">
    <div class="flex items-center justify-between mb-8 px-4 lg:px-8">
        <h2 class="text-2xl font-bold text-slate-900" id="product-title">
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
            <select id="sort-select"
                class="px-4 py-2 bg-white/80 backdrop-blur-sm border border-slate-200/50 rounded-xl 
                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm cursor-pointer">
                <option value="">Urutkan</option>
                <option value="price_asc">Harga Terendah</option>
                <option value="price_desc">Harga Tertinggi</option>
                <option value="name_asc">Nama A-Z</option>
                <option value="newest">Terbaru</option>
            </select>

            <button id="filter-btn"
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

    <!-- Loading Indicator -->
    <div id="loading-indicator" class="hidden text-center py-8">
        <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-full">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Memuat produk...
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 px-4 lg:px-8"
        id="products-grid">
        @include('partials.product-items', ['products' => $products])
    </div>

    <!-- Load More Button -->
    <div class="text-center mt-12" id="load-more-section">
        <button id="load-more-btn"
            class="px-8 py-3 bg-white/80 backdrop-blur-sm border border-slate-200/50 
                  rounded-xl text-slate-700 font-medium hover:bg-white hover:shadow-lg 
                  transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-500/20 cursor-pointer">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
            Muat Lebih Banyak
        </button>
    </div>
</div>
