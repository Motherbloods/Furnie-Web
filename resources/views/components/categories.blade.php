<!-- Categories Component -->
<div class="mb-12">
    <h2 class="text-2xl font-bold text-slate-900 mb-8">Kategori Produk</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        @php
            $categories = [
                [
                    'name' => 'Meja',
                    'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                    'color' => 'bg-red-100 text-red-600',
                    'slug' => 'meja',
                ],
                [
                    'name' => 'Kursi',
                    'icon' => 'M7 13l3 3 7-7',
                    'color' => 'bg-blue-100 text-blue-600',
                    'slug' => 'kursi',
                ],
                [
                    'name' => 'Lemari',
                    'icon' =>
                        'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                    'color' => 'bg-green-100 text-green-600',
                    'slug' => 'lemari',
                ],
                [
                    'name' => 'Kasur',
                    'icon' =>
                        'M3 6a3 3 0 013-3h12a3 3 0 013 3v6a3 3 0 01-3 3H6a3 3 0 01-3-3V6zM3 16h18v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z',
                    'color' => 'bg-purple-100 text-purple-600',
                    'slug' => 'kasur',
                ],
                [
                    'name' => 'Sofa',
                    'icon' => 'M3 10h11M9 21V3a2 2 0 112 0v18M3 21h18',
                    'color' => 'bg-yellow-100 text-yellow-600',
                    'slug' => 'sofa',
                ],
                [
                    'name' => 'Rak',
                    'icon' => 'M7 16V4m0 0L3 8l4-4 4 4m-4-4v12',
                    'color' => 'bg-indigo-100 text-indigo-600',
                    'slug' => 'rak',
                ],
                [
                    'name' => 'Dekorasi',
                    'icon' =>
                        'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.98 9.101c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z',
                    'color' => 'bg-pink-100 text-pink-600',
                    'slug' => 'dekorasi',
                ],
            ];
        @endphp

        @foreach ($categories as $category)
            <a href=""
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
