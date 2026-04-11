<?php
// Admin Layout — Sidebar + Content
$adminPage = $adminPage ?? 'dashboard';
$user = $user ?? null;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin — JasaKami') ?></title>
    <meta name="description" content="Admin Panel — JasaKami Platform">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#3b82f6',
                        'brand-dark': '#1e40af',
                        mint: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                        },
                        sidebar: {
                            DEFAULT: '#0f172a',
                            hover: '#1e293b',
                            active: '#1e3a5f',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { opacity: '0', transform: 'translateX(-20px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        pulse_glow: {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(59, 130, 246, 0.4)' },
                            '50%': { boxShadow: '0 0 0 8px rgba(59, 130, 246, 0)' },
                        }
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.6s ease-out forwards',
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'slide-in': 'slideIn 0.5s ease-out forwards',
                        'pulse-glow': 'pulse_glow 2s infinite',
                    }
                }
            }
        }
    </script>
    <link rel="icon" type="image/png" href="/assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.05));
            border-left-color: #3b82f6;
            color: #60a5fa;
        }
        .sidebar-link.active svg {
            color: #60a5fa;
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
        }
        .table-row-hover:hover {
            background-color: rgba(59, 130, 246, 0.03);
        }
        @keyframes countUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-count {
            animation: countUp 0.5s ease-out forwards;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="font-sans bg-slate-50 text-gray-800 min-h-screen">
    <div class="flex min-h-screen">
        <!-- ========== SIDEBAR ========== -->
        <aside id="admin-sidebar" class="w-72 bg-sidebar fixed inset-y-0 left-0 z-40 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full">
            <!-- Logo -->
            <div class="px-6 py-6 flex items-center gap-3 border-b border-white/5">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand to-blue-600 flex items-center justify-center shadow-lg shadow-brand/30">
                    <img src="/assets/images/logo.png" alt="Logo" class="w-9 h-9 object-contain">
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg tracking-wide">JasaKami</h1>
                    <span class="text-xs text-slate-400 font-medium">Admin Panel</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold px-3 mb-3">Menu Utama</p>

                <a href="/admin" class="sidebar-link flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium text-slate-300 hover:text-white hover:bg-sidebar-hover border-l-[3px] border-transparent transition-all <?= $adminPage === 'dashboard' ? 'active' : '' ?>">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="/admin/users" class="sidebar-link flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium text-slate-300 hover:text-white hover:bg-sidebar-hover border-l-[3px] border-transparent transition-all <?= $adminPage === 'users' ? 'active' : '' ?>">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Kelola Users
                </a>

                <a href="/admin/bookings" class="sidebar-link flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium text-slate-300 hover:text-white hover:bg-sidebar-hover border-l-[3px] border-transparent transition-all <?= $adminPage === 'bookings' ? 'active' : '' ?>">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Bookings
                </a>

                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold px-3 mb-3 mt-8">Lainnya</p>

                <a href="/" class="sidebar-link flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium text-slate-300 hover:text-white hover:bg-sidebar-hover border-l-[3px] border-transparent transition-all">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    Lihat Website
                </a>
            </nav>

            <!-- User Card -->
            <div class="px-4 py-4 border-t border-white/5">
                <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-white/5">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand to-blue-600 flex items-center justify-center text-lg text-white shadow-md">
                        <?= $user['avatar'] ?? '👤' ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-semibold truncate"><?= htmlspecialchars($user['name'] ?? 'Admin') ?></p>
                        <p class="text-slate-400 text-xs truncate"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                    </div>
                    <a href="/logout" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all" title="Logout">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Mobile overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- ========== MAIN CONTENT ========== -->
        <main class="flex-1 lg:ml-72 min-h-screen">
            <!-- Top Bar -->
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-xl border-b border-slate-100">
                <div class="px-6 lg:px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Mobile toggle -->
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></h2>
                            <p class="text-sm text-slate-400 hidden sm:block"><?= date('l, d F Y') ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Notification -->
                        <button class="relative p-2.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <!-- User -->
                        <div class="flex items-center gap-3 pl-3 border-l border-slate-100">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand to-blue-600 flex items-center justify-center text-white text-sm shadow-md">
                                <?= $user['avatar'] ?? '👤' ?>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-semibold text-gray-700"><?= htmlspecialchars($user['name'] ?? 'Admin') ?></p>
                                <p class="text-xs text-slate-400"><?= ucfirst($user['role'] ?? 'admin') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="px-6 lg:px-8 py-8">
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    <script src="/assets/js/admin.js"></script>
</body>

</html>
