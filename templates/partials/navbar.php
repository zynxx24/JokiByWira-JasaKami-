<?php
$current = $currentPage ?? '';
$user = $user ?? null;
?>
<nav id="navbar"
    class="fixed top-0 w-full z-50 transition-all duration-500 <?= $current === 'home' ? 'bg-transparent' : 'bg-gradient-to-r from-brand via-mint-400 to-brand-dark shadow-lg shadow-brand/10' ?>">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="/" class="flex items-center gap-3 group">
            <div class="rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <img src="/assets/images/logo.png" alt="Logo JasaKami" class="w-16 h-16 object-contain drop-shadow-lg">
            </div>
            <span class="text-xl font-bold text-white group-hover:text-mint-200 transition-colors hidden sm:block tracking-wide">JasaKami</span>
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

            <?php if ($user): ?>
                <!-- Logged in state -->
                <div class="flex items-center gap-3 pl-4 border-l border-white/20">
                    <?php
                        $navAvatar = $user['avatar'] ?? '';
                        $isUrl = str_starts_with($navAvatar, 'http');
                    ?>
                    <div class="w-9 h-9 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center overflow-hidden">
                        <?php if ($isUrl): ?>
                            <img src="<?= htmlspecialchars($navAvatar) ?>" alt="<?= htmlspecialchars($user['name']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="text-lg"><?= $navAvatar ?: '👤' ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="hidden lg:block">
                        <p class="text-white text-sm font-semibold leading-tight"><?= htmlspecialchars(explode(' ', $user['name'])[0]) ?></p>
                        <p class="text-white/60 text-xs"><?= ucfirst($user['role']) ?></p>
                    </div>
                </div>
                <?php if ($user['role'] === 'admin'): ?>
                    <a href="/admin"
                        class="px-5 py-2 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-full hover:bg-white/30 transition-all text-sm border border-white/20">
                        Admin Panel
                    </a>
                <?php else: ?>
                    <a href="/dashboard"
                        class="px-5 py-2 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-full hover:bg-white/30 transition-all text-sm border border-white/20">
                        Dashboard
                    </a>
                <?php endif; ?>
                <a href="/logout"
                    class="px-5 py-2.5 bg-white text-red-500 font-semibold rounded-full hover:bg-red-50 hover:shadow-lg transition-all text-sm">
                    Logout
                </a>
            <?php else: ?>
                <!-- Not logged in -->
                <a href="/register" class="text-white/90 hover:text-white font-medium transition-colors text-sm">Sign up</a>
                <a href="/login"
                    class="px-6 py-2.5 bg-white text-brand-dark font-semibold rounded-full hover:bg-mint-50 hover:shadow-lg hover:shadow-white/20 transition-all transform hover:-translate-y-0.5 text-sm">Login</a>
            <?php endif; ?>
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

            <?php if ($user): ?>
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <?php $mobAvatar = $user['avatar'] ?? ''; $mobIsUrl = str_starts_with($mobAvatar, 'http'); ?>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center overflow-hidden text-white">
                        <?php if ($mobIsUrl): ?>
                            <img src="<?= htmlspecialchars($mobAvatar) ?>" alt="" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="text-lg"><?= $mobAvatar ?: '👤' ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($user['name']) ?></p>
                        <p class="text-xs text-gray-400"><?= ucfirst($user['role']) ?></p>
                    </div>
                </div>
                <?php if ($user['role'] === 'admin'): ?>
                    <a href="/admin"
                        class="text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Admin Panel</a>
                <?php else: ?>
                    <a href="/dashboard"
                        class="text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Dashboard</a>
                <?php endif; ?>
                <a href="/logout"
                    class="mt-2 px-6 py-3 bg-red-500 text-white font-semibold rounded-full text-center hover:bg-red-600 transition-all">Logout</a>
            <?php else: ?>
                <a href="/register"
                    class="text-gray-700 hover:text-brand-dark font-medium py-2 border-b border-gray-100 transition-colors">Daftar</a>
                <a href="/login"
                    class="mt-2 px-6 py-3 bg-gradient-to-r from-brand to-brand-dark text-white font-semibold rounded-full text-center hover:shadow-lg transition-all">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>