<!-- Search Bar Component -->
<div class="max-w-2xl mx-auto mb-12">
    <!-- CSRF Token Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <form action="/search" method="GET" class="relative" id="search-form">
        <div class="relative">
            <input type="text" name="query" placeholder="Cari furniture impian Anda..."
                value="{{ request('query') }}"
                class="w-full px-6 py-4 pl-14 pr-20 text-lg bg-white/80 backdrop-blur-sm border border-slate-200/50 
                       rounded-2xl shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-500/20 
                       focus:border-blue-500 transition-all duration-300 placeholder-slate-400"
                autocomplete="off">
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
                       shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 cursor-pointer">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Cari
            </button>
        </div>

        <!-- Search Suggestions/Hints -->
        <div class="absolute top-full left-0 right-0 mt-2 bg-white/95 backdrop-blur-sm border border-slate-200/50 
                    rounded-xl shadow-lg z-50 hidden"
            id="search-suggestions">
            <div class="p-4">
                <p class="text-sm text-slate-600 mb-2">Pencarian populer:</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button"
                        class="suggestion-btn px-3 py-1 bg-slate-100 hover:bg-slate-200 
                                               rounded-full text-sm text-slate-700 transition-colors duration-200"
                        data-query="sofa">
                        Sofa
                    </button>
                    <button type="button"
                        class="suggestion-btn px-3 py-1 bg-slate-100 hover:bg-slate-200 
                                               rounded-full text-sm text-slate-700 transition-colors duration-200"
                        data-query="meja">
                        Meja
                    </button>
                    <button type="button"
                        class="suggestion-btn px-3 py-1 bg-slate-100 hover:bg-slate-200 
                                               rounded-full text-sm text-slate-700 transition-colors duration-200"
                        data-query="kursi">
                        Kursi
                    </button>
                    <button type="button"
                        class="suggestion-btn px-3 py-1 bg-slate-100 hover:bg-slate-200 
                                               rounded-full text-sm text-slate-700 transition-colors duration-200"
                        data-query="lemari">
                        Lemari
                    </button>
                    <button type="button"
                        class="suggestion-btn px-3 py-1 bg-slate-100 hover:bg-slate-200 
                                               rounded-full text-sm text-slate-700 transition-colors duration-200"
                        data-query="tempat tidur">
                        Tempat Tidur
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

<script>
    // Search suggestions functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="query"]');
        const searchSuggestions = document.getElementById('search-suggestions');
        const suggestionBtns = document.querySelectorAll('.suggestion-btn');

        // Show suggestions on focus
        if (searchInput && searchSuggestions) {
            searchInput.addEventListener('focus', function() {
                if (this.value.trim() === '') {
                    searchSuggestions.classList.remove('hidden');
                }
            });

            // Hide suggestions on blur (with delay for clicking)
            searchInput.addEventListener('blur', function() {
                setTimeout(() => {
                    searchSuggestions.classList.add('hidden');
                }, 200);
            });

            // Hide suggestions when typing
            searchInput.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    searchSuggestions.classList.add('hidden');
                }
            });
        }

        // Handle suggestion clicks
        suggestionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const query = this.getAttribute('data-query');
                searchInput.value = query;
                searchSuggestions.classList.add('hidden');

                // Trigger search via AJAX
                if (window.performSearch) {
                    window.performSearch(query, 1, true);
                }
            });
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                searchSuggestions.classList.add('hidden');
            }
        });
    });
</script>
