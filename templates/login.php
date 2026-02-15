<?php
ob_start();
?>

<div class="flex-1 flex items-stretch pt-16 min-h-screen">
    <!-- Left Side: Decorative Panel -->
    <div
        class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-brand via-mint-400 to-brand-dark items-center justify-center overflow-hidden">
        <div
            class="absolute -top-16 -left-16 w-80 h-72 bg-gradient-to-br from-mint-300/50 to-brand/30 rounded-[2rem] shadow-2xl shadow-brand/20 animate-float">
        </div>
        <div class="absolute top-8 left-48 w-56 h-56 bg-white/10 rounded-[3rem] rotate-6 animate-float"
            style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-10 -left-10 w-52 h-64 bg-gradient-to-tr from-brand-dark/40 to-brand/30 rounded-[2rem] shadow-xl animate-float"
            style="animation-delay: 2s;"></div>
        <div class="absolute bottom-32 left-64 w-20 h-20 bg-white/15 rounded-full"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white/20 rounded-2xl rotate-45 backdrop-blur-sm"></div>

        <div class="relative z-10 text-center px-8">
            <div class="relative w-80 h-80 mx-auto mb-8">
                <div
                    class="absolute top-0 left-4 w-36 h-36 rounded-2xl overflow-hidden shadow-2xl transform -rotate-6 hover:rotate-0 transition-transform duration-500">
                    <img src="/assets/images/hotel.jpeg" alt="Hotel" class="w-full h-full object-cover">
                </div>
                <div
                    class="absolute top-4 right-0 w-36 h-36 rounded-2xl overflow-hidden shadow-2xl transform rotate-6 hover:rotate-0 transition-transform duration-500">
                    <img src="/assets/images/kuliner.jpeg" alt="Kuliner" class="w-full h-full object-cover">
                </div>
                <div
                    class="absolute bottom-4 left-1/2 -translate-x-1/2 w-40 h-40 rounded-2xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500">
                    <img src="/assets/images/pplg.jpeg" alt="PPLG" class="w-full h-full object-cover">
                </div>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">Selamat Datang!</h2>
            <p class="text-white/80 text-sm max-w-xs mx-auto">Login untuk mengakses semua layanan profesional JasaKami
            </p>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 relative">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(77,217,160,0.05),transparent_50%)]">
        </div>
        <div class="relative w-full max-w-md" style="animation: fadeUp 0.8s ease-out;">
            <a href="/"
                class="inline-flex items-center gap-2 text-gray-400 hover:text-brand-dark text-sm mb-8 transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Beranda
            </a>

            <div class="flex justify-center mb-8">
                <div
                    class="w-24 h-24 rounded-2xl flex items-center justify-center hover:scale-110 transition-transform duration-300 cursor-pointer">
                    <img src="/assets/images/logo.png" alt="Logo" class="w-24 h-24 object-contain drop-shadow-lg">
                </div>
            </div>

            <h1 class="text-center text-2xl font-extrabold text-gray-800 tracking-wide mb-2">USER LOGIN</h1>
            <p class="text-center text-gray-400 text-sm mb-10">Masukkan email dan password Anda</p>

            <form id="login-form" class="space-y-5" novalidate>
                <div class="relative group">
                    <input type="email" id="email" name="email" placeholder="Email" required
                        class="w-full px-6 py-4 bg-mint-50/60 border-2 border-transparent rounded-2xl text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:border-brand focus:bg-white focus:shadow-lg focus:shadow-brand/10 transition-all duration-300">
                    <div
                        class="absolute inset-y-0 right-4 flex items-center pointer-events-none opacity-0 group-focus-within:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="relative group">
                    <input type="password" id="password" name="password" placeholder="Password" required
                        class="w-full px-6 py-4 bg-mint-50/60 border-2 border-transparent rounded-2xl text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:border-brand focus:bg-white focus:shadow-lg focus:shadow-brand/10 transition-all duration-300">
                    <button type="button" id="toggle-password"
                        class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-brand transition-colors"
                        aria-label="Toggle password visibility">
                        <svg id="eye-open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" id="remember" class="sr-only peer">
                            <div
                                class="w-5 h-5 border-2 border-gray-300 rounded-md peer-checked:bg-brand-dark peer-checked:border-brand-dark transition-all flex items-center justify-center">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 group-hover:text-gray-700 transition-colors">Remember
                            me</span>
                    </label>
                    <a href="#"
                        class="text-sm text-brand-dark hover:text-brand font-medium hover:underline transition-colors">Forgot
                        password?</a>
                </div>

                <div id="error-message"
                    class="hidden px-4 py-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-2xl text-center transition-all">
                </div>

                <div class="pt-2">
                    <button type="submit" id="login-btn"
                        class="block w-full text-center py-4 bg-gradient-to-r from-brand to-brand-dark text-white font-bold rounded-2xl shadow-lg shadow-brand/30 hover:shadow-xl hover:shadow-brand/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 text-sm uppercase tracking-wider">
                        Login
                    </button>
                </div>
            </form>

            <div class="flex items-center gap-4 my-8">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-gray-400 text-xs uppercase tracking-wider">atau</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <div class="flex gap-3 mb-6">
                <button
                    class="flex-1 flex items-center justify-center gap-2 py-3 border-2 border-gray-100 rounded-2xl hover:border-brand/30 hover:bg-mint-50/50 transition-all text-sm font-medium text-gray-600">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Google
                </button>
                <button
                    class="flex-1 flex items-center justify-center gap-2 py-3 border-2 border-gray-100 rounded-2xl hover:border-brand/30 hover:bg-mint-50/50 transition-all text-sm font-medium text-gray-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.604-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.138 20.161 22 16.418 22 12c0-5.523-4.477-10-10-10z" />
                    </svg>
                    GitHub
                </button>
            </div>

            <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="#" class="text-brand-dark font-semibold hover:underline transition-colors">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>