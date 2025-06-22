<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Furnie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar */
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
            .backdrop-blur-xl {
                background-color: rgba(255, 255, 255, 0.95) !important;
            }
        }

        /* Background pattern */
        .bg-pattern {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(148, 163, 184, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(148, 163, 184, 0.1) 0%, transparent 50%);
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100/50 to-slate-200/30 bg-pattern">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <div class="relative group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 rounded-3xl flex items-center justify-center shadow-2xl group-hover:shadow-3xl transition-all duration-300 group-hover:scale-105">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-6H5.41L12 5.59 18.59 12H17v6z" />
                            </svg>
                        </div>
                        <div
                            class="absolute -inset-2 bg-gradient-to-br from-slate-900 to-slate-700 rounded-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-lg">
                        </div>
                    </div>
                </div>

                <h2
                    class="text-3xl font-bold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-600 bg-clip-text text-transparent">
                    Bergabung dengan Furnie
                </h2>
                <p class="mt-2 text-sm text-slate-600">
                    Buat akun baru untuk mulai berbelanja furniture berkualitas
                </p>
            </div>

            <!-- Register Form -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-200/50 p-8">
                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Name Field -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-slate-700">
                            Nama Lengkap
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" required
                                class="w-full pl-12 pr-4 py-4 bg-slate-50/50 border border-slate-200/60 rounded-2xl focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-400 transition-all duration-300 text-slate-900 placeholder-slate-500"
                                placeholder="John Doe" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-slate-700">
                            Email Address
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" required
                                class="w-full pl-12 pr-4 py-4 bg-slate-50/50 border border-slate-200/60 rounded-2xl focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-400 transition-all duration-300 text-slate-900 placeholder-slate-500"
                                placeholder="john@example.com" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-semibold text-slate-700">
                            Nomor Telepon
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <input id="phone" name="phone" type="text" required
                                class="w-full pl-12 pr-4 py-4 bg-slate-50/50 border border-slate-200/60 rounded-2xl focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-400 transition-all duration-300 text-slate-900 placeholder-slate-500"
                                placeholder="08123456789" value="{{ old('phone') }}">
                        </div>
                        @error('phone')
                            <p class="text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">
                            Password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="w-full pl-12 pr-12 py-4 bg-slate-50/50 border border-slate-200/60 rounded-2xl focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-400 transition-all duration-300 text-slate-900 placeholder-slate-500"
                                placeholder="••••••••">
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <svg id="eyeIcon"
                                    class="h-5 w-5 text-slate-400 hover:text-slate-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">
                            Konfirmasi Password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="w-full pl-12 pr-12 py-4 bg-slate-50/50 border border-slate-200/60 rounded-2xl focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-400 transition-all duration-300 text-slate-900 placeholder-slate-500"
                                placeholder="••••••••">
                            <button type="button" id="togglePasswordConfirm"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <svg id="eyeIconConfirm"
                                    class="h-5 w-5 text-slate-400 hover:text-slate-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start space-x-3">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 text-slate-600 focus:ring-slate-500 border-slate-300 rounded mt-1">
                        <label for="terms" class="text-sm text-slate-700 leading-relaxed">
                            Saya setuju dengan
                            <a href="#"
                                class="font-semibold text-slate-900 hover:text-slate-700 transition-colors">Syarat &
                                Ketentuan</a>
                            dan
                            <a href="#"
                                class="font-semibold text-slate-900 hover:text-slate-700 transition-colors">Kebijakan
                                Privasi</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-semibold rounded-2xl text-white bg-gradient-to-r from-slate-900 via-slate-800 to-slate-700 hover:from-slate-800 hover:via-slate-700 hover:to-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-300 group-hover:text-slate-200 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                            </span>
                            Buat Akun Baru
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200/60"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white/80 text-slate-500 font-medium">atau</span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-slate-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="font-semibold text-slate-900 hover:text-slate-700 transition-colors">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                password.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        });

        // Toggle Password Confirmation Visibility
        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const passwordConfirm = document.getElementById('password_confirmation');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');

            if (passwordConfirm.type === 'password') {
                passwordConfirm.type = 'text';
                eyeIconConfirm.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                passwordConfirm.type = 'password';
                eyeIconConfirm.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        });

        // Enhanced form interactions
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll(
                'input[type="text"], input[type="email"], input[type="tel"], input[type="password"]');

            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('scale-105');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('scale-105');
                });
            });

            // Password strength indicator
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');

            password.addEventListener('input', function() {
                const value = this.value;
                let strength = 0;

                if (value.length >= 8) strength++;
                if (/[A-Z]/.test(value)) strength++;
                if (/[a-z]/.test(value)) strength++;
                if (/\d/.test(value)) strength++;
                if (/[^A-Za-z0-9]/.test(value)) strength++;

                // You can add visual feedback here based on strength
            });

            // Real-time password confirmation validation
            passwordConfirm.addEventListener('input', function() {
                const password = document.getElementById('password').value;
                const confirm = this.value;

                if (confirm && password !== confirm) {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '';
                }
            });
        });
    </script>
</body>

</html>
