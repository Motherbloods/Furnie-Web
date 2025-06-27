@if (count($products) > 0)
    @foreach ($products as $product)
        <div
            class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-200/50 
                    hover:shadow-xl hover:bg-white/90 transition-all duration-300 overflow-hidden
                    hover:-translate-y-1 cursor-pointer">

            <!-- Product Image -->
            @php
                $defaultImage =
                    'https://static.vecteezy.com/system/resources/previews/004/141/669/original/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg';
                $firstImage = !empty($product['images'][0])
                    ? (Str::startsWith($product['images'][0], ['https://'])
                        ? $product['images'][0]
                        : asset('http://localhost:8000/storage/' . $product['images'][0]))
                    : $defaultImage;
            @endphp
            <div class="relative overflow-hidden">
                <<img id="mainImage" src="{{ $firstImage }}" alt="{{ $product['name'] }}"
                    class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                    loading="lazy">

                    <!-- Badge/Tag -->
                    <div class="absolute top-3 left-3">
                        <span class="bg-blue-600 text-white text-xs font-medium px-2 py-1 rounded-full">
                            {{ ucfirst($product['kategori']) }}
                        </span>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div
                        class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex flex-col space-y-2">
                            <button
                                class="p-2 bg-white/90 rounded-full shadow-lg hover:bg-white transition-colors duration-200">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                            <button
                                class="p-2 bg-white/90 rounded-full shadow-lg hover:bg-white transition-colors duration-200">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor"
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

            <!-- Product Info -->
            <div class="p-4">
                <!-- Product Name -->
                <h3
                    class="font-semibold text-slate-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                    {{ $product['name'] }}
                </h3>

                <!-- Product Description -->
                <p class="text-sm text-slate-600 mb-3 line-clamp-2">
                    {{ $product['description'] }}
                </p>

                <!-- Rating -->
                <div class="flex items-center mb-3">
                    <div class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($product['rating']))
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @elseif($i == ceil($product['rating']) && $product['rating'] - floor($product['rating']) >= 0.5)
                                <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 20 20">
                                    <defs>
                                        <linearGradient id="half-{{ $product['id'] }}">
                                            <stop offset="50%" stop-color="currentColor" />
                                            <stop offset="50%" stop-color="transparent" />
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half-{{ $product['id'] }})"
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-slate-500 ml-2">({{ $product['rating'] }})</span>
                </div>

                <!-- Price and Action -->
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-lg font-bold text-slate-900">
                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                        </span>
                    </div>
                    <a href="{{ url('/product-detail/' . $product['id']) }}"
                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white 
          rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 
          shadow-md hover:shadow-lg text-sm font-medium
          transform hover:scale-105 active:scale-95 inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6">
                            </path>
                        </svg>
                        Beli
                    </a>

                </div>
            </div>
        </div>
    @endforeach
@else
    <!-- Empty State -->
    <div class="col-span-full text-center py-12">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">Produk Tidak Ditemukan</h3>
            <p class="text-slate-600 mb-6">
                Maaf, kami tidak dapat menemukan produk yang sesuai dengan pencarian Anda.
                Coba gunakan kata kunci lain atau jelajahi kategori produk kami.
            </p>
            <button
                onclick="document.querySelector('input[name=query]').value=''; document.querySelector('form').submit();"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white 
                           rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 
                           shadow-lg hover:shadow-xl font-medium">
                Lihat Semua Produk
            </button>
        </div>
    </div>
@endif
