@extends('layouts.app')

@section('title', 'Pesanan Saya - Furnie')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100/50">
        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl border-b border-gray-100/50 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="flex items-center justify-between">
                    <div>
                        <h1
                            class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-600 bg-clip-text text-transparent">
                            Pesanan Saya
                        </h1>
                        <p class="text-slate-600 mt-2">Pantau status dan riwayat pesanan furniture Anda</p>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-500">Total Pesanan</p>
                            <p class="text-xl font-bold text-slate-900">{{ $orders->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl border border-slate-200/50 shadow-lg p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-3">
                        <button data-filter="all"
                            class="filter-btn px-6 py-3 bg-blue-500 text-white rounded-2xl font-semibold shadow-md hover:bg-blue-600 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Semua Pesanan
                        </button>
                        <button data-filter="menunggu_konfirmasi"
                            class="filter-btn px-6 py-3 bg-white/80 text-slate-700 rounded-2xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Menunggu Konfirmasi
                        </button>
                        <button data-filter="diproses"
                            class="filter-btn px-6 py-3 bg-white/80 text-slate-700 rounded-2xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Diproses
                        </button>
                        <button data-filter="dikirim"
                            class="filter-btn px-6 py-3 bg-white/80 text-slate-700 rounded-2xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Dikirim
                        </button>
                        <button data-filter="selesai"
                            class="filter-btn px-6 py-3 bg-white/80 text-slate-700 rounded-2xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Selesai
                        </button>
                        <button data-filter="dibatalkan"
                            class="filter-btn px-6 py-3 bg-white/80 text-slate-700 rounded-2xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            Dibatalkan
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" id="searchOrders" placeholder="Cari pesanan..."
                                class="pl-12 pr-4 py-3 bg-white/80 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 w-64">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 transform -translate-y-1/2"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <select id="sortOrders"
                            class="px-4 py-3 bg-white/80 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="highest">Nilai Tertinggi</option>
                            <option value="lowest">Nilai Terendah</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="max-w-7xl mx-auto px-6 pb-12">
            <div id="ordersContainer" class="space-y-6">
                @forelse ($orders as $order)
                    <div class="order-card bg-white/70 backdrop-blur-xl rounded-3xl border border-slate-200/50 shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300"
                        data-status="{{ strtolower($order->order_status) }}" data-order-id="{{ $order->order_id }}"
                        data-amount="{{ $order->total_amount }}">
                        <div class="p-6">
                            <!-- Order Header -->
                            <div
                                class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b border-slate-200/50">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-xl font-bold text-slate-900">#{{ $order->order_id }}</h3>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                'diproses' => 'bg-blue-100 text-blue-800',
                                                'dikirim' => 'bg-purple-100 text-purple-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'dibatalkan' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusClass =
                                                $statusColors[strtolower($order->order_status)] ??
                                                'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-4 py-2 {{ $statusClass }} rounded-full text-sm font-semibold">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                        @if ($order->payment_type)
                                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs">
                                                {{ strtoupper($order->payment_type) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-sm text-slate-600">
                                        <span>📅 Dipesan:
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</span>
                                        @if ($order->paid_at)
                                            <span class="hidden sm:inline">•</span>
                                            <span>💳 Dibayar:
                                                {{ \Carbon\Carbon::parse($order->paid_at)->format('d M Y, H:i') }}</span>
                                        @endif
                                        @if ($order->completed_at)
                                            <span class="hidden sm:inline">•</span>
                                            <span>✅ Selesai:
                                                {{ \Carbon\Carbon::parse($order->completed_at)->format('d M Y, H:i') }}</span>
                                        @endif
                                    </div>
                                    @if ($order->shipping_method)
                                        <div class="mt-2 text-sm text-slate-600">
                                            🚚 {{ $order->shipping_method }}
                                            @if ($order->shipping_cost > 0)
                                                • Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right mt-3 md:mt-0">
                                    <p class="text-sm text-slate-500">Total Pesanan</p>
                                    <p class="text-2xl font-bold text-slate-900">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    @if ($order->items->count() > 0)
                                        <p class="text-xs text-slate-500 mt-1">{{ $order->items->count() }} item</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            @if (!in_array(strtolower($order->order_status), ['selesai', 'dibatalkan']))
                                <div class="mb-6">
                                    @php
                                        $progress = match (strtolower($order->order_status)) {
                                            'pending', 'menunggu' => 25,
                                            'diproses' => 50,
                                            'dikirim' => 75,
                                            default => 25,
                                        };
                                        $steps = [
                                            ['label' => 'Menunggu Konfirmasi', 'status' => 'pending'],
                                            ['label' => 'Diproses', 'status' => 'diproses'],
                                            ['label' => 'Dikirim', 'status' => 'dikirim'],
                                            ['label' => 'Selesai', 'status' => 'selesai'],
                                        ];
                                    @endphp

                                    <div class="flex items-center justify-between mb-4">
                                        @foreach ($steps as $index => $step)
                                            @php
                                                $isActive = $index < $progress / 25;
                                                $isCurrent = $index == floor($progress / 25) - 1;
                                            @endphp
                                            <div class="flex items-center space-x-2">
                                                <div
                                                    class="w-8 h-8 rounded-full flex items-center justify-center
                                                    {{ $isActive ? 'bg-green-500' : ($isCurrent ? 'bg-blue-500 animate-pulse' : 'bg-slate-300') }}">
                                                    @if ($isActive)
                                                        <svg class="w-4 h-4 text-white" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-sm font-semibold {{ $isActive ? 'text-green-700' : ($isCurrent ? 'text-blue-700' : 'text-slate-500') }}">
                                                    {{ $step['label'] }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-green-500 to-blue-500 h-2 rounded-full transition-all duration-1000"
                                            style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Order Items -->
                            @if ($order->items && $order->items->count() > 0)
                                <div class="space-y-3 mb-6">
                                    @foreach ($order->items->take(3) as $item)
                                        <div class="flex items-center space-x-4 p-4 bg-slate-50/50 rounded-2xl">
                                            <div
                                                class="w-16 h-16 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center overflow-hidden">
                                                @if ($item->product && $item->product->image)
                                                    <img src="{{ $item->product->image }}"
                                                        alt="{{ $item->product->name }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-8 h-8 text-slate-500" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-slate-900">{{ $item->product->name ?? 'Produk' }}
                                                </h4>
                                                <p class="text-slate-600 text-sm">
                                                    {{ Str::limit($item->product->description ?? 'Deskripsi produk', 50) }}
                                                </p>
                                                <div class="flex items-center justify-between mt-1">
                                                    <p class="text-sm text-slate-500">Qty: {{ $item->quantity ?? 1 }}</p>
                                                    <p class="font-semibold text-slate-900">Rp
                                                        {{ number_format($item->price ?? 0, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($order->items->count() > 3)
                                        dd('More than 3 items');
                                        <div class="text-center py-2">
                                            <button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                                +{{ $order->items->count() - 3 }} produk lainnya
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Fallback jika tidak ada items -->
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center space-x-4 p-4 bg-slate-50/50 rounded-2xl">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-slate-900">Produk Furniture</h4>
                                            <p class="text-slate-600 text-sm">Detail produk</p>
                                            <p class="text-sm text-slate-500">Qty: 1 • Rp
                                                {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Shipping Address -->
                            @if ($order->shipping_address)
                                <div class="mb-6 p-4 bg-blue-50/50 rounded-2xl">
                                    <h5 class="font-semibold text-slate-900 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Alamat Pengiriman
                                    </h5>
                                    <p class="text-sm text-slate-600">{{ $order->shipping_address }}</p>
                                </div>
                            @endif

                            <!-- Notes -->
                            @if ($order->notes)
                                <div class="mb-6 p-4 bg-amber-50/50 rounded-2xl">
                                    <h5 class="font-semibold text-slate-900 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                            </path>
                                        </svg>
                                        Catatan
                                    </h5>
                                    <p class="text-sm text-slate-600">{{ $order->notes }}</p>
                                </div>
                            @endif

                            <!-- Cancel Reason -->
                            @if ($order->order_status === 'dibatalkan' && $order->cancel_reason)
                                <div class="mb-6 p-4 bg-red-50 rounded-2xl border border-red-200">
                                    <h5 class="font-semibold text-red-800 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Alasan Pembatalan
                                    </h5>
                                    <p class="text-sm text-red-700">{{ $order->cancel_reason }}</p>
                                </div>
                            @endif

                            <!-- Rating Section (jika order selesai) -->
                            @if ($order->order_status === 'selesai')
                                <div class="bg-emerald-50/50 rounded-2xl p-4 mb-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-emerald-800 mb-1">Bagaimana pengalaman
                                                Anda?</p>
                                            <p class="text-xs text-emerald-600">Berikan rating untuk produk ini</p>
                                        </div>
                                        <div class="flex space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 text-gray-300 hover:text-yellow-400 cursor-pointer rating-star"
                                                    data-rating="{{ $i }}" data-order="{{ $order->id }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            @include('components.order-actions', [
                                'order' => $order,
                                'orderItems' => $order->items,
                            ])
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto bg-slate-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">Belum Ada Pesanan</h3>
                        <p class="text-slate-600 mb-6">Anda belum memiliki pesanan apapun. Mari mulai berbelanja furniture
                            impian Anda!</p>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl font-semibold shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Mulai Belanja
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
        <div id="noOrdersMessage" class="text-center text-slate-500 py-6 hidden">
            Tidak ada pesanan yang ditemukan.
        </div>
    </div>

    <!-- Modal for Order Details -->
    <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="p-6 border-b border-slate-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-slate-900">Detail Pesanan</h3>
                        <button id="closeModal" class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="modalContent" class="p-6">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Cancel Order -->
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-xl font-bold text-slate-900">Batalkan Pesanan</h3>
                </div>
                <div class="p-6">
                    <p class="text-slate-600 mb-4">Apakah Anda yakin ingin membatalkan pesanan ini?</p>
                    <textarea id="cancelReason"
                        class="w-full p-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 resize-none"
                        rows="3" placeholder="Alasan pembatalan (opsional)"></textarea>
                    <div class="flex gap-3 mt-6">
                        <button id="confirmCancel"
                            class="flex-1 px-4 py-3 bg-red-500 text-white rounded-2xl font-semibold hover:bg-red-600 transition-colors">
                            Ya, Batalkan
                        </button>
                        <button id="closeCancelModal"
                            class="flex-1 px-4 py-3 bg-slate-200 text-slate-700 rounded-2xl font-semibold hover:bg-slate-300 transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Toast -->
    <div id="toast"
        class="fixed top-4 right-4 bg-white border border-slate-200 rounded-2xl shadow-lg p-4 transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex items-center space-x-3">
            <div id="toastIcon" class="w-8 h-8 rounded-full flex items-center justify-center">
                <!-- Icon will be set dynamically -->
            </div>
            <div>
                <p id="toastTitle" class="font-semibold text-slate-900"></p>
                <p id="toastMessage" class="text-sm text-slate-600"></p>
            </div>
        </div>
    </div>
    <script>
        window.orderData = @json($orders->keyBy('order_id'));
        console.log(orderData);
    </script>
    <script src="{{ asset('js/order-modal.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderData = @json($orders->keyBy('order_id'));
            console.log(orderData);
            // Filter buttons functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const orderCards = document.querySelectorAll('.order-card');

            document.querySelectorAll('.btn-received').forEach(button => {
                button.addEventListener('click', async function() {
                    const orderId = this.getAttribute('data-order');

                    const confirmed = confirm('Yakin pesanan sudah diterima?');
                    if (!confirmed) return;

                    try {
                        const response = await fetch(`/checkout/update-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                order_id: orderId,
                                is_received: true
                            })
                        });

                        const data = await response.json();
                        if (response.ok) {
                            alert('Pesanan dikonfirmasi sebagai diterima.');
                            location.reload(); // Reload page to reflect status change
                        } else {
                            alert(data.message || 'Terjadi kesalahan.');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Gagal mengirim permintaan.');
                    }
                });
            });

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('bg-blue-500', 'text-white');
                        btn.classList.add('bg-white/80', 'text-slate-700', 'border',
                            'border-slate-200');
                    });

                    // Add active class to clicked button
                    this.classList.remove('bg-white/80', 'text-slate-700', 'border',
                        'border-slate-200');
                    this.classList.add('bg-blue-500', 'text-white');

                    // Filter orders
                    const filter = this.dataset.filter;
                    filterOrders(filter);
                });
            });

            // Search functionality
            const searchInput = document.getElementById('searchOrders');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterOrders(getActiveFilter(), searchTerm);
            });

            // Sort functionality
            const sortSelect = document.getElementById('sortOrders');
            sortSelect.addEventListener('change', function() {
                sortOrders(this.value);
            });

            // Filter orders function
            function filterOrders(filter, searchTerm = '') {
                let hasVisibleCard = false;

                orderCards.forEach(card => {
                    const status = card.dataset.status;
                    const orderId = card.dataset.orderId.toLowerCase();

                    const matchesFilter = filter === 'all' || status === filter;
                    const matchesSearch = searchTerm === '' ||
                        orderId.includes(searchTerm) ||
                        card.textContent.toLowerCase().includes(searchTerm);

                    if (matchesFilter && matchesSearch) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.3s ease-in';
                        hasVisibleCard = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Tampilkan/hilangkan pesan "tidak ada data"
                const noOrdersMessage = document.getElementById('noOrdersMessage');
                if (noOrdersMessage) {
                    noOrdersMessage.classList.toggle('hidden', hasVisibleCard);
                }
            }


            // Sort orders function
            function sortOrders(sortType) {
                const container = document.getElementById('ordersContainer');
                const cards = Array.from(orderCards);

                cards.sort((a, b) => {
                    const amountA = parseInt(a.dataset.amount);
                    const amountB = parseInt(b.dataset.amount);

                    switch (sortType) {
                        case 'newest':
                            return new Date(b.querySelector('[data-order-id]')?.textContent) -
                                new Date(a.querySelector('[data-order-id]')?.textContent);
                        case 'oldest':
                            return new Date(a.querySelector('[data-order-id]')?.textContent) -
                                new Date(b.querySelector('[data-order-id]')?.textContent);
                        case 'highest':
                            return amountB - amountA;
                        case 'lowest':
                            return amountA - amountB;
                        default:
                            return 0;
                    }
                });

                cards.forEach(card => container.appendChild(card));
            }

            // Get active filter
            function getActiveFilter() {
                const activeButton = document.querySelector('.filter-btn.bg-blue-500');
                return activeButton ? activeButton.dataset.filter : 'all';
            }

            // Rating stars functionality
            const ratingStars = document.querySelectorAll('.rating-star');
            ratingStars.forEach((star, index) => {
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    const orderId = this.dataset.order;
                    highlightStars(orderId, rating);
                });

                star.addEventListener('mouseleave', function() {
                    const orderId = this.dataset.order;
                    resetStars(orderId);
                });

                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    const orderId = this.dataset.order;
                    submitRating(orderId, rating);
                });
            });


            // Format date function
            function formatDate(dateString) {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            // Format currency
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(amount);
            }

            // Get status badge class
            function getStatusClass(status) {
                const statusColors = {
                    'pending': 'bg-yellow-100 text-yellow-800',
                    'menunggu': 'bg-yellow-100 text-yellow-800',
                    'menunggu_konfirmasi': 'bg-yellow-100 text-yellow-800',
                    'diproses': 'bg-blue-100 text-blue-800',
                    'dikirim': 'bg-purple-100 text-purple-800',
                    'selesai': 'bg-green-100 text-green-800',
                    'dibatalkan': 'bg-red-100 text-red-800'
                };
                return statusColors[status.toLowerCase()] || 'bg-gray-100 text-gray-800';
            }

            function highlightStars(orderId, rating) {
                const stars = document.querySelectorAll(`[data-order="${orderId}"]`);
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            }

            function resetStars(orderId) {
                const stars = document.querySelectorAll(`[data-order="${orderId}"]`);
                stars.forEach(star => {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                });
            }

            function submitRating(orderId, rating) {
                // Show confirmation
                showToast('success', 'Rating Berhasil!', `Terima kasih atas rating ${rating} bintang`);

                // Here you would typically send an AJAX request to save the rating
                // fetch('/orders/' + orderId + '/rate', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                //     },
                //     body: JSON.stringify({ rating: rating })
                // });
            }

            // Modal functionality
            const orderModal = document.getElementById('orderModal');
            const closeModal = document.getElementById('closeModal');
            const modalContent = document.getElementById('modalContent');

            // Detail buttons
            const detailButtons = document.querySelectorAll('.btn-detail');
            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.dataset.order;
                    window.showOrderDetail(orderId);
                });
            });

            // Track buttons
            const trackButtons = document.querySelectorAll('.btn-track');
            trackButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const orderNumber = this.dataset.order;
                    console.log('Tracking order:', orderNumber);
                    showTrackingModal(orderNumber);
                });
            });

            function showTrackingModal(orderNumber) {
                const order = orderData[orderNumber];
                console.log('Tracking order:', order.order_status);
                if (!order) {
                    modalContent.innerHTML = `
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Pesanan Tidak Ditemukan</h3>
                    <p class="text-slate-600">Data pelacakan tidak dapat dimuat</p>
                </div>
            `;
                    orderModal.classList.remove('hidden');
                    return;
                }

                // Define tracking steps based on order status
                const trackingSteps = [{
                        title: 'Pesanan Dikonfirmasi',
                        status: 'menunggu_konfirmasi',
                        icon: 'confirmed',
                        date: order.confirmed_at,
                        description: 'Pesanan Anda telah dikonfirmasi dan akan segera diproses'
                    },
                    {
                        title: 'Sedang Diproses',
                        status: 'diproses',
                        icon: 'processing',
                        date: order.processed_at, // You might want to add a processing_at field
                        description: 'Produk sedang disiapkan oleh tim kami'
                    },
                    {
                        title: 'Dalam Pengiriman',
                        status: 'dikirim',
                        icon: 'shipping',
                        date: order.dikirim_at,
                        description: order.shipping_method ? `Dikirim via ${order.shipping_method}` :
                            'Produk sedang dalam perjalanan'
                    },
                    {
                        title: 'Pesanan Selesai',
                        status: 'selesai',
                        icon: 'completed',
                        date: order.completed_at,
                        description: 'Produk telah sampai di tujuan'
                    }
                ];

                // Special handling for cancelled orders
                if (order.order_status.toLowerCase() === 'dibatalkan') {
                    trackingSteps.push({
                        title: 'Pesanan Dibatalkan',
                        status: 'dibatalkan',
                        icon: 'cancelled',
                        date: order.canceled_at,
                        description: order.cancel_reason || 'Pesanan telah dibatalkan'
                    });
                }

                // Get current step index
                const currentStatus = order.order_status.toLowerCase();
                const statusOrder = ['menunggu_konfirmasi', 'diproses', 'dikirim', 'selesai'];
                const currentStepIndex = statusOrder.indexOf(currentStatus);

                // Generate tracking HTML
                const trackingHtml = trackingSteps.map((step, index) => {
                    let stepStatus = 'pending';
                    let iconClass = 'bg-slate-300';
                    let textClass = 'opacity-50';

                    if (currentStatus === 'dibatalkan' && step.status === 'dibatalkan') {
                        stepStatus = 'cancelled';
                        iconClass = 'bg-red-500';
                        textClass = '';
                    } else if (currentStatus === 'dibatalkan') {
                        stepStatus = 'cancelled';
                        iconClass = 'bg-slate-300';
                        textClass = 'opacity-50';
                    } else if (index <= currentStepIndex) {
                        stepStatus = index === currentStepIndex ? 'current' : 'completed';
                        iconClass = index === currentStepIndex ? 'bg-blue-500 animate-pulse' :
                            'bg-green-500';
                        textClass = '';
                    }

                    const stepDate = formatDate(step.date);
                    const displayDate = stepDate || (stepStatus === 'pending' ? 'Menunggu...' : '');

                    let iconContent = '';
                    if (stepStatus === 'completed') {
                        iconContent = `
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                `;
                    } else if (stepStatus === 'cancelled') {
                        iconContent = `
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                `;
                    } else {
                        iconContent = '<div class="w-3 h-3 bg-white rounded-full"></div>';
                    }

                    return `
                <div class="flex items-start space-x-4 ${textClass}">
                    <div class="w-8 h-8 ${iconClass} rounded-full flex items-center justify-center flex-shrink-0">
                        ${iconContent}
                    </div>
                    <div class="flex-1">
                        <h5 class="font-semibold text-slate-900">${step.title}</h5>
                        <p class="text-sm text-slate-600">${displayDate}</p>
                        <p class="text-sm text-slate-500">${step.description}</p>
                    </div>
                </div>
            `;
                }).join('');

                modalContent.innerHTML = `
            <div class="space-y-6">
                <div class="text-center">
                    <h4 class="font-semibold text-slate-900 mb-2">Lacak Pesanan #${orderNumber}</h4>
                    <p class="text-slate-600">Status pengiriman pesanan Anda</p>
                    <div class="mt-4 inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold ${getStatusClass(order.order_status)}">
                        ${order.order_status.charAt(0).toUpperCase() + order.order_status.slice(1)}
                    </div>
                </div>
                
                <div class="space-y-6">
                    ${trackingHtml}
                </div>
                
                ${order.shipping_address ? `
                                                                                                                                                                                                                                                                                            <div class="bg-blue-50 rounded-2xl p-4">
                                                                                                                                                                                                                                                                                                <h5 class="font-semibold text-slate-900 mb-2 flex items-center">
                                                                                                                                                                                                                                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                                                                                                                                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                                                                                                                                                                                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                                                                                                                                                                                                                                                    </svg>
                                                                                                                                                                                                                                                                                                    Alamat Tujuan
                                                                                                                                                                                                                                                                                                </h5>
                                                                                                                                                                                                                                                                                                <p class="text-sm text-slate-700">${order.shipping_address}</p>
                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                            ` : ''}
                
                <div class="bg-slate-50 rounded-2xl p-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-slate-500">Total Pesanan:</span>
                            <span class="font-semibold ml-2">${formatCurrency(order.total_amount)}</span>
                        </div>
                        <div>
                            <span class="text-slate-500">Metode Bayar:</span>
                            <span class="font-semibold ml-2">${order.payment_type ? order.payment_type.toUpperCase() : '-'}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
                orderModal.classList.remove('hidden');
            }

            closeModal.addEventListener('click', function() {
                orderModal.classList.add('hidden');
            });

            orderModal.addEventListener('click', function(e) {
                if (e.target === orderModal) {
                    orderModal.classList.add('hidden');
                }
            });

            // Cancel order functionality
            const cancelModal = document.getElementById('cancelModal');
            const closeCancelModal = document.getElementById('closeCancelModal');
            const confirmCancel = document.getElementById('confirmCancel');
            const cancelButtons = document.querySelectorAll('.btn-cancel');

            let currentCancelOrderId = null;

            cancelButtons.forEach(button => {
                button.addEventListener('click', function() {
                    currentCancelOrderId = this.dataset.order;
                    cancelModal.classList.remove('hidden');
                });
            });

            closeCancelModal.addEventListener('click', function() {
                cancelModal.classList.add('hidden');
                currentCancelOrderId = null;
            });

            confirmCancel.addEventListener('click', function() {
                const reason = document.getElementById('cancelReason').value;

                if (currentCancelOrderId) {
                    // Here you would send the cancellation request
                    showToast('success', 'Pesanan Dibatalkan', 'Pesanan berhasil dibatalkan');
                    cancelModal.classList.add('hidden');

                    // Update the order card status
                    const orderCard = document.querySelector(`[data-order="${currentCancelOrderId}"]`);
                    if (orderCard) {
                        const statusBadge = orderCard.querySelector('.px-4.py-2');
                        statusBadge.className =
                            'px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-semibold';
                        statusBadge.textContent = 'Dibatalkan';
                        orderCard.dataset.status = 'dibatalkan';
                    }
                }

                currentCancelOrderId = null;
            });

            // Reorder functionality
            const reorderButtons = document.querySelectorAll('.btn-reorder');
            reorderButtons.forEach(button => {
                button.addEventListener('click', async function() {
                    try {
                        // Ambil data items dari atribut data-items (hanya untuk status dibatalkan)
                        if (this.hasAttribute('data-items')) {
                            const items = JSON.parse(this.getAttribute('data-items'));
                            console.log('Reordering items:', items);

                            // Loop untuk setiap item dan tambahkan ke keranjang
                            for (const item of items) {
                                await addToCart(item.product_id, item.quantity);
                            }

                            showToast('success', 'Berhasil',
                                'Semua produk berhasil ditambahkan ke keranjang');
                        } else {
                            // Untuk status selesai, kita perlu mengambil data dari server
                            // atau menyimpan data di atribut lain
                            showToast('info', 'Info', 'Fitur pesan ulang belum tersedia');
                        }
                    } catch (error) {
                        console.error('Error reordering:', error);
                        showToast('error', 'Gagal',
                            'Terjadi kesalahan saat menambahkan ke keranjang');
                    }
                });
            });
            async function addToCart(productId, quantity) {
                const response = await fetch('/cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: parseInt(quantity)
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || 'Failed to add to cart');
                }

                return await response.json();
            }


            // Toast notification function
            function showToast(type, title, message) {
                const toast = document.getElementById('toast');
                const toastIcon = document.getElementById('toastIcon');
                const toastTitle = document.getElementById('toastTitle');
                const toastMessage = document.getElementById('toastMessage');

                // Set icon and colors based on type
                const types = {
                    success: {
                        icon: `<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                               </svg>`,
                        bgColor: 'bg-green-500'
                    },
                    error: {
                        icon: `<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                               </svg>`,
                        bgColor: 'bg-red-500'
                    },
                    info: {
                        icon: `<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                               </svg>`,
                        bgColor: 'bg-blue-500'
                    }
                };

                const config = types[type] || types.info;

                toastIcon.className = `w-8 h-8 rounded-full flex items-center justify-center ${config.bgColor}`;
                toastIcon.innerHTML = config.icon;
                toastTitle.textContent = title;
                toastMessage.textContent = message;

                // Show toast
                toast.classList.remove('translate-x-full');
                toast.classList.add('translate-x-0');

                // Hide toast after 4 seconds
                setTimeout(() => {
                    toast.classList.remove('translate-x-0');
                    toast.classList.add('translate-x-full');
                }, 4000);
            }

            // Enhanced hover effects for order cards
            orderCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.02) translateY(-4px)';
                    this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Progress animation for processing orders
            const progressBars = document.querySelectorAll('.bg-gradient-to-r.from-green-500');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                bar.style.transition = 'width 2s ease-in-out';

                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });

            // Auto-refresh untuk status pesanan (opsional)
            setInterval(() => {
                // Check for order status updates
                console.log('Checking order status updates...');
                // You can implement WebSocket or periodic AJAX calls here
            }, 60000); // Check every minute

            // Add CSS animations
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                
                @keyframes slideIn {
                    from { transform: translateX(100%); }
                    to { transform: translateX(0); }
                }
                
                .order-card {
                    animation: fadeIn 0.3s ease-out;
                }
            `;
            document.head.appendChild(style);
        });
    </script>
@endsection
