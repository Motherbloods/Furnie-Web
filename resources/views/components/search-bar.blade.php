<!-- Search Bar Component -->
<div class="max-w-2xl mx-auto mb-12">
    <form action="" method="GET" class="relative">
        <div class="relative">
            <input type="text" name="query" placeholder="Cari furniture impian Anda..." value="{{ request('query') }}"
                class="w-full px-6 py-4 pl-14 pr-20 text-lg bg-white/80 backdrop-blur-sm border border-slate-200/50 
                       rounded-2xl shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-500/20 
                       focus:border-blue-500 transition-all duration-300 placeholder-slate-400">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                    </path>
                </svg>
            </div>
            <button type="submit"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 px-6 py-2 
                       bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium 
                       rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 
                       shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                Cari
            </button>
        </div>
    </form>

    <!-- Search suggestions (optional) -->
    @if (request('query'))
        <div class="mt-4 text-center">
            <p class="text-slate-600">
                Hasil pencarian untuk: <span class="font-semibold text-slate-900">"{{ request('query') }}"</span>
            </p>
        </div>
    @endif
</div>
