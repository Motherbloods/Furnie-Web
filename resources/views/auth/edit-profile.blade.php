@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100/50 py-12">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-slate-700 to-slate-600 rounded-3xl shadow-xl mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-slate-900 mb-2">Edit Profile</h1>
                <p class="text-slate-600 text-lg">Kelola informasi akun Anda</p>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div
                    class="mb-8 p-6 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200/50 rounded-2xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-emerald-800 font-semibold">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-8 p-6 bg-gradient-to-r from-red-50 to-red-100/50 border border-red-200/50 rounded-2xl shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-red-800 font-semibold mb-2">Terjadi kesalahan:</h3>
                            <ul class="list-disc list-inside text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- User Information Card -->
                <div class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl border border-slate-200/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-50 to-slate-100/50 px-8 py-6 border-b border-slate-200/50">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                            <div class="w-8 h-8 bg-slate-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            Informasi Pengguna
                        </h2>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-semibold text-slate-700">Nama
                                    Lengkap</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', Auth::user()->name) }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border rounded-xl focus:ring-2  focus:border-slate-400 transition-all duration-200 @error('name') border-red-300 focus:ring-red-500/20 @enderror"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200/60 rounded-xl focus:ring-2 focus:ring-slate-500/20 focus:border-slate-400 transition-all duration-200 @error('email') border-red-300 focus:ring-red-500/20 focus:border-red-400 @enderror"
                                    placeholder="Masukkan email" required>
                                @error('email')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-semibold text-slate-700">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone"
                                value="{{ old('phone', Auth::user()->phone) }}"
                                class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200/60 rounded-xl focus:ring-2 focus:ring-slate-500/20 focus:border-slate-400 transition-all duration-200 @error('phone') border-red-300 focus:ring-red-500/20 focus:border-red-400 @enderror"
                                placeholder="Masukkan nomor telepon">
                            @error('phone')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Seller Information Card (Only for sellers) -->
                @if (Auth::user()->isSeller())
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl border border-slate-200/50 overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-emerald-50 to-emerald-100/50 px-8 py-6 border-b border-emerald-200/50">
                            <h2 class="text-2xl font-bold text-emerald-800 flex items-center">
                                <div class="w-8 h-8 bg-emerald-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1">
                                        </path>
                                    </svg>
                                </div>
                                Informasi Toko
                            </h2>
                            @if (Auth::user()->seller && Auth::user()->seller->isVerified())
                                <div class="flex items-center mt-2">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-emerald-700 font-medium">Toko Terverifikasi</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-8 space-y-6">
                            <!-- Store Name -->
                            <div class="space-y-2">
                                <label for="store_name" class="block text-sm font-semibold text-slate-700">Nama
                                    Toko</label>
                                <input type="text" id="store_name" name="store_name"
                                    value="{{ old('store_name', Auth::user()->seller->store_name ?? '') }}"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200/60 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400 transition-all duration-200 @error('store_name') border-red-300 focus:ring-red-500/20 focus:border-red-400 @enderror"
                                    placeholder="Masukkan nama toko">
                                @error('store_name')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Store Address -->
                            <div class="space-y-2">
                                <label for="store_address" class="block text-sm font-semibold text-slate-700">Alamat
                                    Toko</label>
                                <textarea id="store_address" name="store_address" rows="3"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200/60 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400 transition-all duration-200 resize-none @error('store_address') border-red-300 focus:ring-red-500/20 focus:border-red-400 @enderror"
                                    placeholder="Masukkan alamat lengkap toko">{{ old('store_address', Auth::user()->seller->store_address ?? '') }}</textarea>
                                @error('store_address')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Store Description -->
                            <div class="space-y-2">
                                <label for="store_description"
                                    class="block text-sm font-semibold text-slate-700">Deskripsi Toko</label>
                                <textarea id="store_description" name="store_description" rows="4"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200/60 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400 transition-all duration-200 resize-none @error('store_description') border-red-300 focus:ring-red-500/20 focus:border-red-400 @enderror"
                                    placeholder="Ceritakan tentang toko Anda">{{ old('store_description', Auth::user()->seller->store_description ?? '') }}</textarea>
                                @error('store_description')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Password Change Card -->
                <div class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl border border-slate-200/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-50 to-amber-100/50 px-8 py-6 border-b border-amber-200/50">
                        <h2 class="text-2xl font-bold text-amber-800 flex items-center">
                            <div class="w-8 h-8 bg-amber-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            Ubah Password
                        </h2>
                        <p class="text-amber-700 text-sm mt-1">Kosongkan jika tidak ingin mengubah password</p>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Current Password -->
                            <div class="space-y-2">
                                <label for="current_password" class="block text-sm font-semibold text-slate-700">Password
                                    Saat Ini</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200/60 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all duration-200 @error('current_password') border-red-300 focus:ring-red-500/20 focus:border-red-400 @enderror"
                                    placeholder="Masukkan password saat ini">
                                @error('current_password')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-semibold text-slate-700">Password
                                    Baru</label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200/60 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all duration-200 @error('password') border-red-300 focus:ring-red-500/20 focus:border-red-400 @enderror"
                                    placeholder="Masukkan password baru">
                                @error('password')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation"
                                class="block text-sm font-semibold text-slate-700">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200/60 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all duration-200"
                                placeholder="Konfirmasi password baru">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center pt-8">
                    <button type="submit"
                        class="group relative px-12 py-4 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-slate-500/20">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-slate-600 to-slate-500 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div class="relative flex items-center space-x-3 cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-lg">Simpan Perubahan</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
