<?php
ob_start();
$redirectTo = $_GET['redirect'] ?? '';
// Whitelist allowed redirect paths
$allowedRedirects = ['/booking', '/dashboard', '/admin'];
$safeRedirect = in_array($redirectTo, $allowedRedirects, true) ? $redirectTo : '';
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
            <p class="text-center text-gray-400 text-sm mb-6">Masukkan email dan password Anda</p>

            <?php if ($safeRedirect): ?>
            <div class="flex items-center gap-3 px-4 py-3 bg-amber-50 border border-amber-200 rounded-2xl mb-6">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p class="text-sm text-amber-700">Login terlebih dahulu untuk melanjutkan pemesanan.</p>
            </div>
            <?php endif; ?>

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

                <div id="success-message"
                    class="hidden px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm rounded-2xl text-center transition-all">
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

            <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="/register" class="text-brand-dark font-semibold hover:underline transition-colors">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>

<script>
function fillDemo(email, pass) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = pass;
    document.getElementById('email').focus();
}

// Toggle password
const toggleBtn = document.getElementById('toggle-password');
const passwordInput = document.getElementById('password');
const eyeOpen = document.getElementById('eye-open');
const eyeClosed = document.getElementById('eye-closed');

if (toggleBtn && passwordInput) {
    toggleBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        eyeOpen.classList.toggle('hidden');
        eyeClosed.classList.toggle('hidden');
    });
}

// Login form
document.getElementById('login-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('login-btn');
    const errorDiv = document.getElementById('error-message');
    const successDiv = document.getElementById('success-message');
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!email || !password) {
        showLoginError(errorDiv, 'Harap isi semua field!');
        return;
    }

    btn.textContent = 'Logging in...';
    btn.disabled = true;
    btn.classList.add('opacity-70');
    errorDiv.classList.add('hidden');
    successDiv.classList.add('hidden');

    try {
        const res = await fetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });
        const data = await res.json();

        if (data.success) {
            successDiv.textContent = data.message + ' Mengalihkan...';
            successDiv.classList.remove('hidden');
            // Honor the ?redirect param; fall back to API-provided redirect
            const urlRedirect = new URLSearchParams(window.location.search).get('redirect');
            const allowed = ['/booking', '/dashboard', '/admin'];
            const finalRedirect = (urlRedirect && allowed.includes(urlRedirect))
                ? urlRedirect
                : (data.redirect || '/');
            setTimeout(() => {
                window.location.href = finalRedirect;
            }, 800);
        } else {
            showLoginError(errorDiv, data.message);
            btn.textContent = 'LOGIN';
            btn.disabled = false;
            btn.classList.remove('opacity-70');
        }
    } catch (err) {
        showLoginError(errorDiv, 'Terjadi kesalahan. Coba lagi.');
        btn.textContent = 'LOGIN';
        btn.disabled = false;
        btn.classList.remove('opacity-70');
    }
});

function showLoginError(el, msg) {
    if (!el) return;
    el.textContent = msg;
    el.classList.remove('hidden');
    el.style.animation = 'none';
    el.offsetHeight;
    el.style.animation = 'fadeUp 0.3s ease-out';
    setTimeout(() => el.classList.add('hidden'), 5000);
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>