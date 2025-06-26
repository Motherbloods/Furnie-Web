<!-- Categories Component -->
<div class="mb-12">
    <h2 class="text-2xl font-bold text-slate-900 mb-8">Kategori Produk</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">

        @foreach ($categories as $category)
            <a href="{{ route('dashboard', ['category' => $category['slug']]) }}"
                class="group flex flex-col items-center p-4 bg-white/60 backdrop-blur-sm rounded-2xl 
                  border border-slate-200/50 shadow-lg hover:shadow-xl transition-all duration-300 
                  hover:scale-105 hover:bg-white/80">
                <div
                    class="w-14 h-14 {{ $category['color'] }} rounded-xl flex items-center justify-center mb-3 
                        group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $category['icon'] }}"></path>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-900 group-hover:text-slate-700 transition-colors">
                    {{ $category['name'] }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Active Category Indicator -->
    @if (request()->route('category'))
        <div class="mt-6 text-center">
            <span
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 
                     text-white font-medium rounded-full text-sm shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
                Kategori: {{ ucfirst(request()->route('category')) }}
            </span>
        </div>
    @endif
</div>
