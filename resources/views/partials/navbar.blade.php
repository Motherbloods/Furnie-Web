<nav class="bg-white/80 backdrop-blur-xl border-b border-gray-100/50 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div
                            class="w-11 h-11 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-6H5.41L12 5.59 18.59 12H17v6z" />
                            </svg>
                        </div>
                        <div
                            class="absolute -inset-1 bg-gradient-to-br from-slate-900 to-slate-700 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-sm">
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-600 bg-clip-text text-transparent">
                            Furnie
                        </span>
                        <span class="text-xs text-slate-500 font-medium -mt-1">Furniture Store</span>
                    </div>
                </a>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative">
                <!-- Profile Button -->
                <button id="profileButton"
                    class="flex items-center space-x-3 bg-slate-50/50 hover:bg-slate-100/70 border border-slate-200/60 px-4 py-3 rounded-2xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-slate-500/20 group backdrop-blur-sm hover:shadow-md cursor-pointer">
                    <div class="relative">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-slate-700 via-slate-600 to-slate-500 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>

                    </div>
                    @auth
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}!</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->role }}</p>
                        </div>
                    @endauth
                    <svg id="dropdownArrow"
                        class="w-4 h-4 text-slate-400 transition-all duration-300 group-hover:text-slate-600"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdown"
                    class="absolute right-0 mt-3 w-72 bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-200/50 hidden z-50 overflow-hidden">
                    <!-- Profile Header -->
                    <div class="p-6 bg-gradient-to-br from-slate-50/50 to-slate-100/30 border-b border-slate-200/50">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-slate-700 via-slate-600 to-slate-500 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white">
                                </div>
                            </div>
                            @auth
                                <div class="flex-1">
                                    <p class="font-bold text-slate-900 text-lg"> {{ Auth::user()->name }}</p>
                                    <p class="text-sm text-slate-600"> {{ Auth::user()->email }}</p>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="py-3">
                        @auth
                            @if (Auth::user()->role === 'user')
                                <a href="/keranjang"
                                    class="flex items-center px-6 py-4 text-slate-700 hover:bg-emerald-50/50 hover:text-emerald-700 transition-all duration-200 group">
                                    <div
                                        class="w-12 h-12 bg-emerald-100/70 rounded-2xl flex items-center justify-center mr-4 group-hover:bg-emerald-200/70 transition-all duration-200 group-hover:scale-105">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold">Keranjang Belanja</p>
                                        <p class="text-xs text-slate-500">Lihat Keranjang Anda</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600 transition-colors"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endif
                        @endauth

                        <a href="/transaksi"
                            class="flex items-center px-6 py-4 text-slate-700 hover:bg-blue-50/50 hover:text-blue-700 transition-all duration-200 group">
                            <div
                                class="w-12 h-12 bg-blue-100/70 rounded-2xl flex items-center justify-center mr-4 group-hover:bg-blue-200/70 transition-all duration-200 group-hover:scale-105">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold">Pesanan Saya</p>
                                <p class="text-xs text-slate-500">Lihat status pesanan Anda</p>
                            </div>

                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        <!-- Divider -->
                        <div class="my-3 mx-6 border-t border-slate-200/60"></div>

                        <a href="/profile"
                            class="flex items-center px-6 py-4 text-slate-700 hover:bg-slate-50/50 hover:text-slate-900 transition-all duration-200 group">
                            <div
                                class="w-12 h-12 bg-slate-100/70 rounded-2xl flex items-center justify-center mr-4 group-hover:bg-slate-200/70 transition-all duration-200 group-hover:scale-105">
                                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold">Pengaturan Profile</p>
                                <p class="text-xs text-slate-500">Kelola informasi akun</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-colors"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        <!-- Divider -->
                        <div class="my-3 mx-6 border-t border-slate-200/60"></div>

                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left flex items-center px-6 py-4 text-red-600 hover:bg-red-50/50 transition-all duration-200 group cursor-pointer">
                                <div
                                    class="w-12 h-12 bg-red-100/70 rounded-2xl flex items-center justify-center mr-4 group-hover:bg-red-200/70 transition-all duration-200 group-hover:scale-105">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold">Keluar</p>
                                    <p class="text-xs text-slate-500">Logout dari akun</p>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-red-600 transition-colors"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Profile dropdown functionality with enhanced animations
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');
        const dropdownArrow = document.getElementById('dropdownArrow');

        profileButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const isHidden = profileDropdown.classList.contains('hidden');

            if (isHidden) {
                // Show dropdown
                profileDropdown.classList.remove('hidden');
                profileDropdown.style.opacity = '0';
                profileDropdown.style.transform = 'translateY(-20px) scale(0.95)';

                requestAnimationFrame(() => {
                    profileDropdown.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    profileDropdown.style.opacity = '1';
                    profileDropdown.style.transform = 'translateY(0) scale(1)';
                });

                dropdownArrow.style.transform = 'rotate(180deg)';
            } else {
                // Hide dropdown
                profileDropdown.style.transition = 'all 0.2s cubic-bezier(0.4, 0, 1, 1)';
                profileDropdown.style.opacity = '0';
                profileDropdown.style.transform = 'translateY(-20px) scale(0.95)';

                setTimeout(() => {
                    profileDropdown.classList.add('hidden');
                }, 200);

                dropdownArrow.style.transform = 'rotate(0deg)';
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                if (!profileDropdown.classList.contains('hidden')) {
                    profileDropdown.style.transition = 'all 0.2s cubic-bezier(0.4, 0, 1, 1)';
                    profileDropdown.style.opacity = '0';
                    profileDropdown.style.transform = 'translateY(-20px) scale(0.95)';

                    setTimeout(() => {
                        profileDropdown.classList.add('hidden');
                    }, 200);

                    dropdownArrow.style.transform = 'rotate(0deg)';
                }
            }
        });

        // Enhanced scroll effect
        let lastScrollY = window.scrollY;
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            const currentScrollY = window.scrollY;

            if (currentScrollY > 20) {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                navbar.classList.add('shadow-lg');
                navbar.classList.remove('shadow-sm');
            } else {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
                navbar.classList.add('shadow-sm');
                navbar.classList.remove('shadow-lg');
            }

            lastScrollY = currentScrollY;
        });

        // Add smooth hover effects for menu items
        const menuItems = document.querySelectorAll('#profileDropdown a');
        menuItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    });
</script>

<style>
    /* Custom scrollbar for better aesthetics */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.5);
    }

    /* Enhanced transitions */
    * {
        transition-property: transform, background-color, border-color, opacity, box-shadow;
    }

    /* Backdrop blur fallback */
    @supports not (backdrop-filter: blur(12px)) {
        nav {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        #profileDropdown {
            background-color: rgba(255, 255, 255, 0.98) !important;
        }
    }
</style>
