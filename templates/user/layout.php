<?php
// User Layout — Simple sidebar
$user = $user ?? null;
$activePage = $currentPage ?? 'user-dashboard';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Dashboard — JasaKami') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#3b82f6',
                        'brand-dark': '#1e40af',
                        mint: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6' },
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    keyframes: {
                        fadeUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                    },
                    animation: { 'fade-up': 'fadeUp 0.6s ease-out forwards' }
                }
            }
        }
    </script>
    <link rel="icon" type="image/png" href="/assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
</head>

<body class="font-sans bg-slate-50 text-gray-800 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="user-sidebar" class="w-64 bg-white border-r border-slate-100 fixed inset-y-0 left-0 z-40 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full shadow-xl lg:shadow-none">
            <div class="px-6 py-5 flex items-center gap-3 border-b border-slate-100">
                <img src="/assets/images/logo.png" alt="Logo" class="w-14 h-14 object-contain">
                <div>
                    <h1 class="text-brand-dark font-bold text-xl">JasaKami</h1>
                    <span class="text-xs text-slate-400">My Dashboard</span>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all <?= $activePage === 'user-dashboard' ? 'bg-brand/10 text-brand-dark' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' ?>">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="/booking" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Pesan Layanan
                </a>
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    Lihat Website
                </a>
            </nav>

            <!-- User card -->
            <div class="px-4 py-4 border-t border-slate-100">
                <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-slate-50">
                    <?php $uAvatar = $user['avatar'] ?? ''; $uIsUrl = str_starts_with($uAvatar, 'http'); ?>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand to-blue-600 flex items-center justify-center text-lg text-white overflow-hidden">
                        <?php if ($uIsUrl): ?>
                            <img src="<?= htmlspecialchars($uAvatar) ?>" alt="" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span><?= $uAvatar ?: '👤' ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-700 truncate"><?= htmlspecialchars($user['name'] ?? 'User') ?></p>
                        <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                    </div>
                    <a href="/logout" class="p-2 text-slate-400 hover:text-red-500 rounded-lg transition-all" title="Logout">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Mobile overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleUserSidebar()"></div>

        <!-- Main -->
        <main class="flex-1 lg:ml-64 min-h-screen">
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-xl border-b border-slate-100">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleUserSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h2 class="text-lg font-bold text-gray-800">Selamat datang, <?= htmlspecialchars(explode(' ', $user['name'] ?? 'User')[0]) ?>! 👋</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <?php $topAvatar = $user['avatar'] ?? ''; $topIsUrl = str_starts_with($topAvatar, 'http'); ?>
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand to-blue-600 flex items-center justify-center text-white text-sm overflow-hidden">
                            <?php if ($topIsUrl): ?>
                                <img src="<?= htmlspecialchars($topAvatar) ?>" alt="" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span><?= $topAvatar ?: '👤' ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </header>

            <div class="px-6 lg:px-8 py-8">
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>

    <script>
        function toggleUserSidebar() {
            document.getElementById('user-sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }
    </script>
</body>

</html>
