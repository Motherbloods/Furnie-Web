@extends('layouts.app')

@section('title', 'Edit Produk - Furnie')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-700 rounded-2xl p-6 mb-8 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 backdrop-blur-lg p-3 rounded-xl border border-white/30">
                        <i class="fas fa-edit text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Edit Produk</h1>
                        <p class="text-white/80">Perbarui informasi produk Anda</p>
                    </div>
                </div>
                <a href="{{ route('seller.dashboard') }}"
                    class="bg-white/20 backdrop-blur-lg border border-white/30 hover:bg-white/30 px-4 py-2 rounded-xl text-sm font-medium text-white transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('seller.product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle mr-3 text-indigo-600"></i>
                    Informasi Dasar
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Product Name -->
                    <div class="lg:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                            placeholder="Masukkan nama produk" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori" name="kategori"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                            required>
                            <option value="">Pilih Kategori</option>
                            <option value="sofa" {{ old('kategori', $product->kategori) == 'sofa' ? 'selected' : '' }}>
                                Sofa</option>
                            <option value="kursi" {{ old('kategori', $product->kategori) == 'kursi' ? 'selected' : '' }}>
                                Kursi</option>
                            <option value="meja" {{ old('kategori', $product->kategori) == 'meja' ? 'selected' : '' }}>
                                Meja</option>
                            <option value="lemari" {{ old('kategori', $product->kategori) == 'lemari' ? 'selected' : '' }}>
                                Lemari</option>
                            <option value="tempat_tidur"
                                {{ old('kategori', $product->kategori) == 'tempat_tidur' ? 'selected' : '' }}>Tempat Tidur
                            </option>
                            <option value="dekorasi"
                                {{ old('kategori', $product->kategori) == 'dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                        </select>
                        @error('kategori')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                            required>
                            <option value="aktif" {{ old('status', $product->status) == 'akif' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="non-aktif"
                                {{ old('status', $product->status) == 'non-aktif' ? 'selected' : '' }}>
                                Tidak Aktif</option>
                            <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi Produk <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                            placeholder="Tuliskan deskripsi produk secara detail..." required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-dollar-sign mr-3 text-green-600"></i>
                    Harga & Stok
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Original Price -->
                    <div>
                        <label for="original_price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga Asli
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                            <input type="number" id="original_price" name="original_price"
                                value="{{ old('original_price', $product->original_price) }}"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                                placeholder="0" min="0">
                        </div>
                        @error('original_price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selling Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga Jual <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                                placeholder="0" min="0" required>
                        </div>
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                            placeholder="0" min="0" required>
                        @error('stock')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Discount -->
                    <div>
                        <label for="discount" class="block text-sm font-semibold text-gray-700 mb-2">
                            Diskon (%)
                        </label>
                        <input type="number" id="discount" name="discount"
                            value="{{ old('discount', $product->discount) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                            placeholder="0" min="0" max="100">
                        @error('discount')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-images mr-3 text-purple-600"></i>
                    Gambar Produk
                </h2>

                <!-- Main Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                        Gambar Utama
                    </label>
                    @if ($product->image)
                        <div class="mb-4">
                            <img src="{{ $product->image }}" alt="Current main image"
                                class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                            <p class="text-sm text-gray-500 mt-2">Gambar saat ini</p>
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                    <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB</p>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Images -->
                <div>
                    <label for="images" class="block text-sm font-semibold text-gray-700 mb-2">
                        Gambar Tambahan
                    </label>
                    @if ($product->images && count($product->images) > 0)
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            @foreach ($product->images as $img)
                                <img src="{{ $img }}" alt="Additional image"
                                    class="w-full h-24 object-cover rounded-lg border border-gray-200">
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Gambar tambahan saat ini</p>
                    @endif
                    <input type="file" id="images" name="images[]" accept="image/*" multiple
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                    <p class="text-sm text-gray-500 mt-2">Pilih beberapa gambar (maksimal 5). Format: JPG, PNG, JPEG</p>
                    @error('images')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Specifications -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-cog mr-3 text-blue-600"></i>
                    Spesifikasi Produk
                </h2>

                <div id="specifications-container">
                    @if ($product->specifications && count($product->specifications) > 0)
                        @foreach ($product->specifications as $key => $value)
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4 specification-row">
                                <input type="text" name="specifications[{{ $loop->index }}][key]"
                                    value="{{ $key }}"
                                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                                    placeholder="Nama spesifikasi (contoh: Bahan)">
                                <div class="flex space-x-2">
                                    <input type="text" name="specifications[{{ $loop->index }}][value]"
                                        value="{{ $value }}"
                                        class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                                        placeholder="Nilai spesifikasi (contoh: Kayu Jati)">
                                    <button type="button"
                                        class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-300 remove-specification">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4 specification-row">
                            <input type="text" name="specifications[0][key]"
                                class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                                placeholder="Nama spesifikasi (contoh: Bahan)">
                            <div class="flex space-x-2">
                                <input type="text" name="specifications[0][value]"
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                                    placeholder="Nilai spesifikasi (contoh: Kayu Jati)">
                                <button type="button"
                                    class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-300 remove-specification">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <button type="button" id="add-specification"
                    class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl hover:bg-indigo-200 transition-colors duration-300 text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>Tambah Spesifikasi
                </button>
            </div>

            <!-- Features -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-star mr-3 text-yellow-600"></i>
                    Fitur Produk
                </h2>

                <div id="features-container">
                    @if ($product->features && count($product->features) > 0)
                        @foreach ($product->features as $feature)
                            <div class="flex space-x-2 mb-4 feature-row">
                                <input type="text" name="features[]" value="{{ $feature }}"
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                                    placeholder="Masukkan fitur produk">
                                <button type="button"
                                    class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-300 remove-feature">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex space-x-2 mb-4 feature-row">
                            <input type="text" name="features[]"
                                class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                                placeholder="Masukkan fitur produk">
                            <button type="button"
                                class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-300 remove-feature">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endif
                </div>

                <button type="button" id="add-feature"
                    class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl hover:bg-indigo-200 transition-colors duration-300 text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>Tambah Fitur
                </button>
            </div>

            <!-- Submit Buttons -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <div class="flex justify-between items-center">
                    <a href="{{ route('seller.dashboard') }}"
                        class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-medium hover:bg-gray-200 transition-colors duration-300">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <div class="flex space-x-4">
                        <button type="submit" name="action" value="draft"
                            class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Simpan sebagai Draft
                        </button>
                        <button type="submit" name="action" value="publish"
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-check mr-2"></i>Update & Publikasikan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let specificationIndex = {{ $product->specifications ? count($product->specifications) : 1 }};

            // Add specification
            document.getElementById('add-specification').addEventListener('click', function() {
                const container = document.getElementById('specifications-container');
                const newRow = document.createElement('div');
                newRow.className = 'grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4 specification-row';
                newRow.innerHTML = `
            <input type="text" 
                   name="specifications[${specificationIndex}][key]" 
                   class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                   placeholder="Nama spesifikasi (contoh: Bahan)">
            <div class="flex space-x-2">
                <input type="text" 
                       name="specifications[${specificationIndex}][value]" 
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                       placeholder="Nilai spesifikasi (contoh: Kayu Jati)">
                <button type="button" 
                        class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-300 remove-specification">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
                container.appendChild(newRow);
                specificationIndex++;
            });

            // Remove specification
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-specification')) {
                    const row = e.target.closest('.specification-row');
                    if (document.querySelectorAll('.specification-row').length > 1) {
                        row.remove();
                    }
                }
            });

            // Add feature
            document.getElementById('add-feature').addEventListener('click', function() {
                const container = document.getElementById('features-container');
                const newRow = document.createElement('div');
                newRow.className = 'flex space-x-2 mb-4 feature-row';
                newRow.innerHTML = `
            <input type="text" 
                   name="features[]" 
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300"
                   placeholder="Masukkan fitur produk">
            <button type="button" 
                    class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-300 remove-feature">
                <i class="fas fa-trash"></i>
            </button>
        `;
                container.appendChild(newRow);
            });

            // Remove feature
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-feature')) {
                    const row = e.target.closest('.feature-row');
                    if (document.querySelectorAll('.feature-row').length > 1) {
                        row.remove();
                    }
                }
            });
        });
    </script>
@endsection
