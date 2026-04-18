<?php
ob_start();
$redirectTo = $_GET['redirect'] ?? '';
$allowedRedirects = ['/booking', '/dashboard', '/admin'];
$safeRedirect = in_array($redirectTo, $allowedRedirects, true) ? $redirectTo : '';
?>

<div class="flex-1 flex items-stretch pt-16 min-h-screen">
    <!-- Left Side: Decorative Panel -->
    <div
        class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-emerald-500 via-teal-500 to-blue-600 items-center justify-center overflow-hidden">
        <div class="absolute -top-16 -left-16 w-80 h-72 bg-white/10 rounded-[2rem] shadow-2xl animate-float"></div>
        <div class="absolute top-8 left-48 w-56 h-56 bg-white/10 rounded-[3rem] rotate-6 animate-float"
            style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-10 -left-10 w-52 h-64 bg-white/10 rounded-[2rem] shadow-xl animate-float"
            style="animation-delay: 2s;"></div>
        <div class="absolute bottom-32 left-64 w-20 h-20 bg-white/15 rounded-full"></div>

        <div class="relative z-10 text-center px-8">
            <div class="w-28 h-28 mx-auto mb-8 rounded-3xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-2xl">
                <svg class="w-14 h-14 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h2 class="text-3xl font-bold text-white mb-3">Bergabung dengan Kami!</h2>
            <p class="text-white/80 text-sm max-w-xs mx-auto leading-relaxed">
                Daftar sekarang dan nikmati layanan profesional dari JasaKami. Hanya butuh beberapa detik.
            </p>
            <div class="flex justify-center gap-4 mt-8">
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-sm flex items-center justify-center mb-2">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-white/70 text-xs">Perhotelan</span>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-sm flex items-center justify-center mb-2">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a6 6 0 0112 0H6z"/></svg>
                    </div>
                    <span class="text-white/70 text-xs">Kuliner</span>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-sm flex items-center justify-center mb-2">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    </div>
                    <span class="text-white/70 text-xs">PPLG</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 relative">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(16,185,129,0.05),transparent_50%)]"></div>
        <div class="relative w-full max-w-md" style="animation: fadeUp 0.8s ease-out;">
            <a href="/"
                class="inline-flex items-center gap-2 text-gray-400 hover:text-brand-dark text-sm mb-8 transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Beranda
            </a>

            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center hover:scale-110 transition-transform duration-300">
                    <img src="/assets/images/logo.png" alt="Logo" class="w-20 h-20 object-contain drop-shadow-lg">
                </div>
            </div>

            <h1 class="text-center text-2xl font-extrabold text-gray-800 tracking-wide mb-2">DAFTAR AKUN</h1>
            <p class="text-center text-gray-400 text-sm mb-8">Buat akun baru untuk mulai memesan</p>

            <form id="register-form" class="space-y-4" novalidate>
                <div class="relative group">
                    <input type="text" id="reg-name" name="name" placeholder="Nama Lengkap" required
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:border-brand focus:bg-white focus:shadow-lg focus:shadow-brand/10 transition-all duration-300">
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none opacity-0 group-focus-within:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>

                <div class="relative group">
                    <input type="email" id="reg-email" name="email" placeholder="Email" required
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:border-brand focus:bg-white focus:shadow-lg focus:shadow-brand/10 transition-all duration-300">
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none opacity-0 group-focus-within:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="relative group">
                    <input type="tel" id="reg-phone" name="phone" placeholder="No. Telepon (opsional)"
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:border-brand focus:bg-white focus:shadow-lg focus:shadow-brand/10 transition-all duration-300">
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none opacity-0 group-focus-within:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                </div>

                <div class="relative group">
                    <input type="password" id="reg-password" name="password" placeholder="Password (min 6 karakter)" required
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:border-brand focus:bg-white focus:shadow-lg focus:shadow-brand/10 transition-all duration-300">
                </div>

                <div class="relative group">
                    <input type="password" id="reg-password-confirm" name="password_confirm" placeholder="Konfirmasi Password" required
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:border-brand focus:bg-white focus:shadow-lg focus:shadow-brand/10 transition-all duration-300">
                </div>

                <div id="reg-error"
                    class="hidden px-4 py-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-2xl text-center transition-all">
                </div>

                <div id="reg-success"
                    class="hidden px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm rounded-2xl text-center transition-all">
                </div>

                <div class="pt-2">
                    <button type="submit" id="register-btn"
                        class="block w-full text-center py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 text-sm uppercase tracking-wider">
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Sudah punya akun?
                <a href="/login" class="text-brand-dark font-semibold hover:underline transition-colors">Login di sini</a>
            </p>
        </div>
    </div>
</div>

<script>
document.getElementById('register-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('register-btn');
    const errorDiv = document.getElementById('reg-error');
    const successDiv = document.getElementById('reg-success');

    const name = document.getElementById('reg-name').value.trim();
    const email = document.getElementById('reg-email').value.trim();
    const phone = document.getElementById('reg-phone').value.trim();
    const password = document.getElementById('reg-password').value;
    const passwordConfirm = document.getElementById('reg-password-confirm').value;

    // Client-side validation
    if (!name || !email || !password || !passwordConfirm) {
        showRegError(errorDiv, 'Harap isi semua field yang wajib!');
        return;
    }

    if (password.length < 6) {
        showRegError(errorDiv, 'Password minimal 6 karakter.');
        return;
    }

    if (password !== passwordConfirm) {
        showRegError(errorDiv, 'Konfirmasi password tidak cocok.');
        return;
    }

    btn.textContent = 'Mendaftar...';
    btn.disabled = true;
    btn.classList.add('opacity-70');
    errorDiv.classList.add('hidden');
    successDiv.classList.add('hidden');

    try {
        const res = await fetch('/api/register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, phone, password, password_confirm: passwordConfirm })
        });
        const data = await res.json();

        if (data.success) {
            successDiv.textContent = data.message + ' Mengalihkan...';
            successDiv.classList.remove('hidden');
            const urlRedirect = new URLSearchParams(window.location.search).get('redirect');
            const allowed = ['/booking', '/dashboard', '/admin'];
            const finalRedirect = (urlRedirect && allowed.includes(urlRedirect))
                ? urlRedirect
                : (data.redirect || '/dashboard');
            setTimeout(() => {
                window.location.href = finalRedirect;
            }, 1000);
        } else {
            showRegError(errorDiv, data.message);
            btn.textContent = 'DAFTAR SEKARANG';
            btn.disabled = false;
            btn.classList.remove('opacity-70');
        }
    } catch (err) {
        showRegError(errorDiv, 'Terjadi kesalahan. Coba lagi.');
        btn.textContent = 'DAFTAR SEKARANG';
        btn.disabled = false;
        btn.classList.remove('opacity-70');
    }
});

function showRegError(el, msg) {
    if (!el) return;
    el.textContent = msg;
    el.classList.remove('hidden');
    el.style.animation = 'none';
    el.offsetHeight;
    el.style.animation = 'fadeUp 0.3s ease-out';
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
