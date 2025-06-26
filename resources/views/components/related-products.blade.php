    <!-- Related Products Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-slate-900 mb-8">Produk Serupa</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
                        <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form w-full">
                            @csrf
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white 
               py-2.5 px-4 rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 
               transition-all duration-300 shadow-lg hover:shadow-xl cursor-pointer">
                                Tambah ke Keranjang
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
