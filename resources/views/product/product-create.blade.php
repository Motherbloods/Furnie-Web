@extends('layouts.app')
@section('title', 'Tambah Produk - Furnie')
@section('content')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-4 mb-4">
                    <a href="{{ route('seller.dashboard') }}"
                        class="bg-white hover:bg-gray-50 border border-gray-200 p-3 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                        <i class="fas fa-arrow-left text-gray-600"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Tambah Produk Baru</h1>
                        <p class="text-gray-600 mt-1">Lengkapi informasi produk yang akan Anda jual</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan pada form:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <form action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data"
                    id="productForm">
                    @csrf

                    <!-- Progress Bar -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                        <div class="flex items-center justify-between text-white">
                            <div class="flex items-center space-x-4">
                                <div class="bg-white/20 backdrop-blur-lg p-3 rounded-xl">
                                    <i class="fas fa-plus text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold">Form Tambah Produk</h2>
                                    <p class="text-white/80">Isi semua informasi dengan lengkap</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        <!-- Informasi Dasar -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Nama Produk -->
                            <div class="lg:col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-tag mr-2 text-indigo-600"></i>Nama Produk *
                                </label>
                                <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama produk yang menarik...">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga -->
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-dollar-sign mr-2 text-green-600"></i>Harga Jual *
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                    <input type="number" id="price" name="price" required min="0"
                                        value="{{ old('price') }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 @error('price') border-red-500 @enderror"
                                        placeholder="0">
                                </div>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Asli -->
                            <div>
                                <label for="original_price" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-tags mr-2 text-orange-600"></i>Harga Asli (Opsional)
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                    <input type="number" id="original_price" name="original_price" min="0"
                                        value="{{ old('original_price') }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 @error('original_price') border-red-500 @enderror"
                                        placeholder="0">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Harga sebelum diskon (jika ada)</p>
                                @error('original_price')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div>
                                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-boxes mr-2 text-blue-600"></i>Stok *
                                </label>
                                <input type="number" id="stock" name="stock" required min="0"
                                    value="{{ old('stock') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 @error('stock') border-red-500 @enderror"
                                    placeholder="Jumlah stok tersedia">
                                @error('stock')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-list mr-2 text-purple-600"></i>Kategori *
                                </label>
                                <select id="kategori" name="kategori" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 @error('kategori') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="sofa" {{ old('kategori') == 'sofa' ? 'selected' : '' }}>Sofa</option>
                                    <option value="kursi" {{ old('kategori') == 'kursi' ? 'selected' : '' }}>Kursi
                                    </option>
                                    <option value="meja" {{ old('kategori') == 'meja' ? 'selected' : '' }}>Meja</option>
                                    <option value="lemari" {{ old('kategori') == 'lemari' ? 'selected' : '' }}>Lemari
                                    </option>
                                    <option value="tempat_tidur" {{ old('kategori') == 'tempat_tidur' ? 'selected' : '' }}>
                                        Tempat Tidur</option>
                                    <option value="dekorasi" {{ old('kategori') == 'dekorasi' ? 'selected' : '' }}>Dekorasi
                                    </option>
                                    <option value="pencahayaan" {{ old('kategori') == 'pencahayaan' ? 'selected' : '' }}>
                                        Pencahayaan</option>
                                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>

                                @error('kategori')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-align-left mr-2 text-teal-600"></i>Deskripsi Produk *
                            </label>
                            <textarea id="description" name="description" required rows="5"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 resize-none @error('description') border-red-500 @enderror"
                                placeholder="Deskripsikan produk Anda dengan detail. Jelaskan material, ukuran, keunggulan, dan hal menarik lainnya...">{{ old('description') }}</textarea>

                            @error('description')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Gambar -->
                        <div class="space-y-6">
                            <!-- Gambar Utama -->
                            <div>
                                <label for="image" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-image mr-2 text-pink-600"></i>Gambar Utama *
                                </label>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors duration-300 @error('image') border-red-500 @enderror">
                                    <input type="file" id="image" name="image" accept="image/*" required
                                        class="hidden" onchange="previewMainImage(this)">
                                    <div id="main-image-preview" class="hidden mb-4">
                                        <img id="main-preview-img" class="mx-auto max-h-48 rounded-lg shadow-md">
                                    </div>
                                    <label for="image" class="cursor-pointer">
                                        <div
                                            class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-camera text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-600 font-medium">Klik untuk upload gambar utama</p>
                                        <p class="text-gray-400 text-sm mt-1">PNG, JPG hingga 5MB</p>
                                    </label>
                                </div>
                                @error('image')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gambar Tambahan -->
                            <div>
                                <label for="images" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-images mr-2 text-cyan-600"></i>Gambar Tambahan (Opsional)
                                </label>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors duration-300 @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror">
                                    <input type="file" id="images" name="images[]" accept="image/*" multiple
                                        class="hidden" onchange="previewMultipleImages(this)">
                                    <div id="multiple-images-preview" class="hidden mb-4">
                                        <div id="preview-container" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                                    </div>
                                    <label for="images" class="cursor-pointer">
                                        <div
                                            class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-images text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-600 font-medium">Klik untuk upload gambar tambahan</p>
                                        <p class="text-gray-400 text-sm mt-1">Maksimal 5 gambar, PNG/JPG hingga 5MB</p>
                                    </label>
                                </div>
                                @error('images')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                                @error('images.*')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Spesifikasi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-cog mr-2 text-gray-600"></i>Spesifikasi Produk (Opsional)
                            </label>
                            <div id="specifications-container" class="space-y-3">
                                @if (old('specifications'))
                                    @foreach (old('specifications') as $index => $spec)
                                        <div class="flex gap-3 specification-row">
                                            <input type="text" name="specifications[{{ $index }}][key]"
                                                value="{{ $spec['key'] ?? '' }}"
                                                placeholder="Nama spesifikasi (contoh: Material)"
                                                class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                                            <input type="text" name="specifications[{{ $index }}][value]"
                                                value="{{ $spec['value'] ?? '' }}"
                                                placeholder="Nilai spesifikasi (contoh: Kayu Jati)"
                                                class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                                            <button type="button" onclick="removeSpecification(this)"
                                                class="px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors duration-300">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex gap-3 specification-row">
                                        <input type="text" name="specifications[0][key]"
                                            placeholder="Nama spesifikasi (contoh: Material)"
                                            class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                                        <input type="text" name="specifications[0][value]"
                                            placeholder="Nilai spesifikasi (contoh: Kayu Jati)"
                                            class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                                        <button type="button" onclick="removeSpecification(this)"
                                            class="px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors duration-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addSpecification()"
                                class="mt-3 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors duration-300 text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah Spesifikasi
                            </button>
                        </div>

                        <!-- Features -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-star mr-2 text-yellow-600"></i>Fitur & Keunggulan (Opsional)
                            </label>
                            <div id="features-container" class="space-y-3">
                                @if (old('features'))
                                    @foreach (old('features') as $index => $feature)
                                        <div class="flex gap-3 feature-row">
                                            <input type="text" name="features[]" value="{{ $feature }}"
                                                placeholder="Masukkan fitur atau keunggulan produk..."
                                                class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                                            <button type="button" onclick="removeFeature(this)"
                                                class="px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors duration-300">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex gap-3 feature-row">
                                        <input type="text" name="features[]"
                                            placeholder="Masukkan fitur atau keunggulan produk..."
                                            class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                                        <button type="button" onclick="removeFeature(this)"
                                            class="px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors duration-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addFeature()"
                                class="mt-3 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors duration-300 text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah Fitur
                            </button>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-toggle-on mr-2 text-green-600"></i>Status Produk
                            </label>
                            <select id="status" name="status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                                <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('seller.dashboard') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition-all duration-300">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-save mr-2"></i>Simpan Produk
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Set specification index based on existing data
        let specificationIndex = {{ old('specifications') ? count(old('specifications')) : 1 }};

        // Preview gambar utama
        function previewMainImage(input) {
            const preview = document.getElementById('main-image-preview');
            const previewImg = document.getElementById('main-preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview multiple images
        function previewMultipleImages(input) {
            const preview = document.getElementById('multiple-images-preview');
            const container = document.getElementById('preview-container');

            if (input.files && input.files.length > 0) {
                container.innerHTML = '';

                for (let i = 0; i < Math.min(input.files.length, 5); i++) {
                    const file = input.files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'relative';
                        imgDiv.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg shadow-md">
                `;
                        container.appendChild(imgDiv);
                    };

                    reader.readAsDataURL(file);
                }

                preview.classList.remove('hidden');
            }
        }

        // Spesifikasi functions
        function addSpecification() {
            const container = document.getElementById('specifications-container');
            const newSpec = document.createElement('div');
            newSpec.className = 'flex gap-3 specification-row';
            newSpec.innerHTML = `
        <input type="text" 
               name="specifications[${specificationIndex}][key]" 
               placeholder="Nama spesifikasi (contoh: Dimensi)"
               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
        <input type="text" 
               name="specifications[${specificationIndex}][value]" 
               placeholder="Nilai spesifikasi (contoh: 200x100x75 cm)"
               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
        <button type="button" 
                onclick="removeSpecification(this)"
                class="px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors duration-300">
            <i class="fas fa-trash"></i>
        </button>
    `;
            container.appendChild(newSpec);
            specificationIndex++;
        }

        function removeSpecification(button) {
            const container = document.getElementById('specifications-container');
            if (container.children.length > 1) {
                button.parentElement.remove();
            }
        }

        // Features functions
        function addFeature() {
            const container = document.getElementById('features-container');
            const newFeature = document.createElement('div');
            newFeature.className = 'flex gap-3 feature-row';
            newFeature.innerHTML = `
        <input type="text" 
               name="features[]" 
               placeholder="Masukkan fitur atau keunggulan produk..."
               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
        <button type="button" 
                onclick="removeFeature(this)"
                class="px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors duration-300">
            <i class="fas fa-trash"></i>
        </button>
    `;
            container.appendChild(newFeature);
        }

        function removeFeature(button) {
            const container = document.getElementById('features-container');
            if (container.children.length > 1) {
                button.parentElement.remove();
            }
        }

        // Form validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            // Auto-calculate discount if original_price is set
            const price = parseFloat(document.getElementById('price').value) || 0;
            const originalPrice = parseFloat(document.getElementById('original_price').value) || 0;

            if (originalPrice > 0 && price < originalPrice) {
                const discount = Math.round(((originalPrice - price) / originalPrice) * 100);

                // Add hidden input for discount
                const discountInput = document.createElement('input');
                discountInput.type = 'hidden';
                discountInput.name = 'discount';
                discountInput.value = discount;
                this.appendChild(discountInput);
            }

            // Add seller_id
            const sellerIdInput = document.createElement('input');
            sellerIdInput.type = 'hidden';
            sellerIdInput.name = 'seller_id';
            sellerIdInput.value = '{{ auth()->user()->seller->id ?? '' }}';
            this.appendChild(sellerIdInput);
        });

        // Auto scroll to first error on page load
        document.addEventListener('DOMContentLoaded', function() {
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                firstError.focus();
            }
        });
    </script>

@endsection
