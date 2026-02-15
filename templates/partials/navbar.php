<?php $current = $currentPage ?? ''; ?>
<nav id="navbar"
    class="fixed top-0 w-full z-50 transition-all duration-500 <?= $current === 'home' ? 'bg-transparent' : 'bg-gradient-to-r from-brand via-mint-400 to-brand-dark shadow-lg shadow-brand/10' ?>">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="/" class="flex items-center gap-3 group">
            <div
                class="w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <img src="/assets/images/logo.png" alt="Logo JasaKami" class="w-14 h-14 object-contain drop-shadow-lg">
            </div>
            <span
                class="text-lg font-bold <?= $current === 'home' ? 'text-white' : 'text-white' ?> group-hover:text-mint-200 transition-colors hidden sm:block tracking-wide">JasaKami</span>
        </a>
        <div class="hidden md:flex items-center gap-8">
            <?php if ($current === 'home'): ?>
                <a href="#tentang"
                    class="nav-link text-white/90 hover:text-white font-medium transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-white hover:after:w-full after:transition-all text-sm">Tentang
                    Kami</a>
                <a href="#layanan"
                    class="nav-link text-white/90 hover:text-white font-medium transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-white hover:after:w-full after:transition-all text-sm">Layanan</a>
                <a href="#tim"
                    class="nav-link text-white/90 hover:text-white font-medium transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-white hover:after:w-full after:transition-all text-sm">Tim
                    Kami</a>
            <?php else: ?>
                <a href="/" class="text-white/90 hover:text-white font-medium transition-colors text-sm">Beranda</a>
                <a href="/#layanan" class="text-white/90 hover:text-white font-medium transition-colors text-sm">Layanan</a>
                <a href="/#tentang" class="text-white/90 hover:text-white font-medium transition-colors text-sm">Tentang</a>
            <?php endif; ?>
            <a href="/login" class="text-white/90 hover:text-white font-medium transition-colors text-sm">Sign up</a>
            <a href="/login"
                class="px-6 py-2.5 bg-white text-brand-dark font-semibold rounded-full hover:bg-mint-50 hover:shadow-lg hover:shadow-white/20 transition-all transform hover:-translate-y-0.5 text-sm">Login</a>
        </div>
        <button id="mobile-menu-btn" class="md:hidden flex flex-col gap-1.5 p-2 group" aria-label="Toggle menu">
            <span class="w-6 h-0.5 bg-white transition-all duration-300 origin-center group-hover:w-5"></span>
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
            <span class="w-6 h-0.5 bg-white transition-all duration-300 origin-center group-hover:w-4"></span>
        </button>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-white/95 backdrop-blur-xl border-t border-mint-100 shadow-2xl">
        <div class="px-6 py-6 flex flex-col gap-4">
            <a href="/"
                class="mobile-link text-gray-700 hover:text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Beranda</a>
            <?php if ($current === 'home'): ?>
                <a href="#tentang"
                    class="mobile-link text-gray-700 hover:text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Tentang
                    Kami</a>
                <a href="#layanan"
                    class="mobile-link text-gray-700 hover:text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Layanan</a>
                <a href="#tim"
                    class="mobile-link text-gray-700 hover:text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Tim
                    Kami</a>
            <?php else: ?>
                <a href="/#layanan"
                    class="mobile-link text-gray-700 hover:text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Layanan</a>
                <a href="/#tentang"
                    class="mobile-link text-gray-700 hover:text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Tentang</a>
            <?php endif; ?>
            <a href="/login"
                class="mt-2 px-6 py-3 bg-gradient-to-r from-brand to-brand-dark text-white font-semibold rounded-full text-center hover:shadow-lg transition-all">Login</a>
        </div>
    </div>
</nav>