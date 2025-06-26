@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <!-- Demo Content -->
    <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 to-slate-100">
        <!-- Hero Section with Container -->
        <div class="max-w-4xl mx-auto py-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-slate-900 mb-4">Welcome to Furnie</h1>
                <p class="text-lg text-slate-600 mb-8">Your premium furniture destination</p>

                <!-- Search Component -->
                @include('components.search-bar')

                <!-- Categories Component -->
                @include('components.categories')

                <!-- Features Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-slate-200/50">
                        <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 00-2-2H5a2 2 00-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Premium Quality</h3>
                        <p class="text-slate-600">High-quality furniture crafted with attention to detail</p>
                    </div>
                    <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-slate-200/50">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Best Prices</h3>
                        <p class="text-slate-600">Competitive pricing with flexible payment options</p>
                    </div>
                    <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-slate-200/50">
                        <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Fast Delivery</h3>
                        <p class="text-slate-600">Quick and secure delivery to your doorstep</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product List Component - Full Width -->
        @include('components.product-list')
    </div>
    <script src="{{ asset('js/searchCategory.js') }}"></script>


@endsection
