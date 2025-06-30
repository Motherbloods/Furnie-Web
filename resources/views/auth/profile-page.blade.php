@extends('layouts.app')
@section('title', 'Profile')
@section('content')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100/50 py-12">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Profile Header -->
            <div class="text-center mb-12">
                <div class="relative inline-block mb-6">
                    @if (Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture"
                            class="w-24 h-24 rounded-3xl shadow-xl object-cover border-4 border-white">
                    @else
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-slate-700 to-slate-600 rounded-3xl shadow-xl flex items-center justify-center border-4 border-white">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                    <div
                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-slate-900 mb-2">{{ Auth::user()->name }}</h1>
                <div class="flex items-center justify-center space-x-4 text-slate-600">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                            </path>
                        </svg>
                        <span>{{ Auth::user()->email }}</span>
                    </span>
                    @if (Auth::user()->phone)
                        <span class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span>{{ Auth::user()->phone }}</span>
                        </span>
                    @endif
                </div>
                <div class="mt-4 flex items-center justify-between flex-col space-y-4">
                    <span
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700 text-sm font-semibold rounded-full border border-slate-300">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ ucfirst(Auth::user()->role) }}
                    </span>

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white hover:bg-slate-700 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        <span class="font-medium">Edit Profile</span>
                    </a>
                </div>

            </div>

            <!-- User Information Card -->
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl border border-slate-200/50 overflow-hidden mb-8">
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
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-500 mb-2">Nama Lengkap</label>
                                <p class="text-lg text-slate-800 font-medium">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-500 mb-2">Email</label>
                                <p class="text-lg text-slate-800 font-medium">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-500 mb-2">Role</label>
                                <p class="text-lg text-slate-800 font-medium">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-500 mb-2">Nomor Telepon</label>
                                <p class="text-lg text-slate-800 font-medium">{{ Auth::user()->phone ?: 'Belum diisi' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seller Information Card (Only for sellers) -->
            @if (Auth::user()->isSeller())
                <div
                    class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl border border-slate-200/50 overflow-hidden mb-8">
                    <div
                        class="bg-gradient-to-r from-emerald-50 to-emerald-100/50 px-8 py-6 border-b border-emerald-200/50">
                        <div class="flex items-center justify-between">
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
                            @if (Auth::user()->seller)
                                <div class="flex items-center bg-emerald-100 px-3 py-1 rounded-full">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-emerald-700 font-medium">Terverifikasi</span>
                                </div>
                            @else
                                <div class="flex items-center bg-amber-100 px-3 py-1 rounded-full">
                                    <div class="w-2 h-2 bg-amber-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-amber-700 font-medium">Belum Verifikasi</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-8">
                        @if (Auth::user()->seller)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-500 mb-2">Nama Toko</label>
                                        <p class="text-lg text-slate-800 font-medium">
                                            {{ Auth::user()->seller->store_name ?: 'Belum diisi' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-500 mb-2">Status</label>
                                        <div class="flex items-center space-x-4">
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-800 text-sm font-medium rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Terverifikasi
                                            </span>
                                            @if (Auth::user()->seller->isSuspended())
                                                <span
                                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Suspended
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-500 mb-2">Jumlah
                                            Produk</label>
                                        <p class="text-lg text-slate-800 font-medium">
                                            {{ Auth::user()->seller->product_count }} produk</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-500 mb-2">Produk Aktif</label>
                                        <p class="text-lg text-slate-800 font-medium">
                                            {{ Auth::user()->seller->active_product_count }} produk</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-500 mb-2">Alamat Toko</label>
                                    <p class="text-lg text-slate-800">
                                        {{ Auth::user()->seller->store_address ?: 'Belum diisi' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-500 mb-2">Deskripsi Toko</label>
                                    <p class="text-lg text-slate-800">
                                        {{ Auth::user()->seller->store_description ?: 'Belum diisi' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1">
                                    </path>
                                </svg>
                                <p class="text-slate-600 text-lg">Informasi toko belum diatur</p>
                                <p class="text-slate-500">Lengkapi informasi toko Anda di halaman edit profile</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Account Statistics -->
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl border border-slate-200/50 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100/50 px-8 py-6 border-b border-blue-200/50">
                    <h2 class="text-2xl font-bold text-blue-800 flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        Statistik Akun
                    </h2>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div
                            class="text-center p-6 bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-2xl border border-slate-200/50">
                            <div class="w-12 h-12 bg-slate-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4M8 7h8M8 7v8a1 1 0 001 1h6a1 1 0 001-1V7">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800">{{ Auth::user()->created_at->format('M Y') }}
                            </h3>
                            <p class="text-slate-600">Bergabung Sejak</p>
                        </div>

                        @if (Auth::user()->isSeller() && Auth::user()->seller)
                            <div
                                class="text-center p-6 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-2xl border border-emerald-200/50">
                                <div
                                    class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-emerald-800">{{ Auth::user()->seller->product_count }}
                                </h3>
                                <p class="text-emerald-600">Total Produk</p>
                            </div>

                            <div
                                class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl border border-blue-200/50">
                                <div
                                    class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-blue-800">
                                    {{ Auth::user()->seller->active_product_count }}</h3>
                                <p class="text-blue-600">Produk Aktif</p>
                            </div>
                        @else
                            <div
                                class="col-span-2 text-center p-6 bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-2xl border border-amber-200/50">
                                <div
                                    class="w-12 h-12 bg-amber-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-amber-800">Pengguna Aktif</h3>
                                <p class="text-amber-600">Status akun Anda saat ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
