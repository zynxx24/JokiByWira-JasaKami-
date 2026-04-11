<?php
// Admin Dashboard
ob_start();
$stats = $stats ?? [];
$users = $users ?? [];
$bookings = $bookings ?? [];
$workers = $workers ?? [];
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="stat-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm" style="animation: fadeUp 0.5s ease-out both;">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">+12%</span>
        </div>
        <p class="text-3xl font-bold text-gray-800 mb-1"><?= $stats['total_users'] ?? 0 ?></p>
        <p class="text-sm text-slate-400 font-medium">Total Users</p>
    </div>

    <!-- Total Bookings -->
    <div class="stat-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm" style="animation: fadeUp 0.5s ease-out 0.1s both;">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg shadow-violet-500/20">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">+8%</span>
        </div>
        <p class="text-3xl font-bold text-gray-800 mb-1"><?= $stats['total_bookings'] ?? 0 ?></p>
        <p class="text-sm text-slate-400 font-medium">Total Bookings</p>
    </div>

    <!-- Pending -->
    <div class="stat-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm" style="animation: fadeUp 0.5s ease-out 0.2s both;">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Pending</span>
        </div>
        <p class="text-3xl font-bold text-gray-800 mb-1"><?= $stats['pending_bookings'] ?? 0 ?></p>
        <p class="text-sm text-slate-400 font-medium">Menunggu Konfirmasi</p>
    </div>

    <!-- Workers -->
    <div class="stat-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm" style="animation: fadeUp 0.5s ease-out 0.3s both;">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Aktif</span>
        </div>
        <p class="text-3xl font-bold text-gray-800 mb-1"><?= $stats['total_workers'] ?? 0 ?></p>
        <p class="text-sm text-slate-400 font-medium">Total Workers</p>
    </div>
</div>

<!-- Revenue Card -->
<div class="bg-gradient-to-r from-brand via-blue-600 to-brand-dark rounded-2xl p-8 mb-8 text-white relative overflow-hidden shadow-xl" style="animation: fadeUp 0.5s ease-out 0.4s both;">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
    <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <p class="text-blue-100 text-sm font-medium mb-1">Total Pendapatan</p>
            <p class="text-4xl font-extrabold tracking-tight">Rp<?= number_format($stats['revenue'] ?? 0, 0, ',', '.') ?></p>
            <p class="text-blue-200 text-sm mt-2">Dari <?= $stats['completed_bookings'] ?? 0 ?> booking selesai</p>
        </div>
        <div class="flex gap-3">
            <a href="/admin/bookings" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold rounded-xl transition-all text-sm">
                Lihat Detail
            </a>
        </div>
    </div>
</div>

<div class="grid xl:grid-cols-3 gap-8">
    <!-- Recent Bookings -->
    <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" style="animation: fadeUp 0.5s ease-out 0.5s both;">
        <div class="px-6 py-5 flex items-center justify-between border-b border-slate-50">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Booking Terbaru</h3>
                <p class="text-sm text-slate-400">Daftar pesanan terakhir</p>
            </div>
            <a href="/admin/bookings" class="text-sm font-semibold text-brand hover:text-brand-dark transition-colors">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider text-slate-400 bg-slate-50/80">
                        <th class="px-6 py-3 font-semibold">Customer</th>
                        <th class="px-6 py-3 font-semibold">Worker</th>
                        <th class="px-6 py-3 font-semibold">Layanan</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach (array_slice($bookings, 0, 5) as $b): ?>
                        <?php
                        $statusColors = [
                            'pending' => 'text-amber-700 bg-amber-50 border-amber-200',
                            'confirmed' => 'text-blue-700 bg-blue-50 border-blue-200',
                            'completed' => 'text-emerald-700 bg-emerald-50 border-emerald-200',
                            'cancelled' => 'text-red-700 bg-red-50 border-red-200',
                        ];
                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'confirmed' => 'Dikonfirmasi',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                        $sc = $statusColors[$b['status']] ?? 'text-gray-700 bg-gray-50 border-gray-200';
                        $sl = $statusLabels[$b['status']] ?? $b['status'];
                        ?>
                        <tr class="table-row-hover transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">
                                        <?= strtoupper(substr($b['user_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-700"><?= htmlspecialchars($b['user_name']) ?></p>
                                        <p class="text-xs text-slate-400"><?= htmlspecialchars($b['user_email'] ?? '') ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-600"><?= htmlspecialchars($b['worker_name']) ?></td>
                            <td class="px-6 py-4">
                                <span class="text-gray-600"><?= htmlspecialchars($b['service']) ?></span>
                                <p class="text-xs text-slate-400"><?= htmlspecialchars($b['section']) ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full border <?= $sc ?>"><?= $sl ?></span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-700"><?= htmlspecialchars($b['total_formatted']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Belum ada booking
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Users & Quick Actions -->
    <div class="space-y-6">
        <!-- Users List -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" style="animation: fadeUp 0.5s ease-out 0.6s both;">
            <div class="px-6 py-5 flex items-center justify-between border-b border-slate-50">
                <h3 class="text-lg font-bold text-gray-800">Users Terdaftar</h3>
                <a href="/admin/users" class="text-sm font-semibold text-brand hover:text-brand-dark transition-colors">Semua →</a>
            </div>
            <div class="p-4 space-y-2">
                <?php foreach (array_slice($users, 0, 5) as $u): ?>
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand/20 to-blue-100 flex items-center justify-center text-lg">
                            <?= $u['avatar'] ?? '👤' ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-700 truncate"><?= htmlspecialchars($u['name']) ?></p>
                            <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($u['email']) ?></p>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full <?= $u['role'] === 'admin' ? 'bg-purple-50 text-purple-600' : 'bg-slate-100 text-slate-500' ?>">
                            <?= ucfirst($u['role']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6" style="animation: fadeUp 0.5s ease-out 0.7s both;">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="/admin/users" class="flex items-center gap-3 p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 group-hover:text-blue-700 transition-colors">Kelola Users</p>
                        <p class="text-xs text-slate-400">Lihat & edit semua users</p>
                    </div>
                </a>
                <a href="/admin/bookings" class="flex items-center gap-3 p-3 rounded-xl bg-violet-50 hover:bg-violet-100 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-violet-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 group-hover:text-violet-700 transition-colors">Kelola Bookings</p>
                        <p class="text-xs text-slate-400">Konfirmasi & update pesanan</p>
                    </div>
                </a>
                <a href="/" class="flex items-center gap-3 p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700 transition-colors">Lihat Website</p>
                        <p class="text-xs text-slate-400">Buka halaman utama</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Login Info Card -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 text-white shadow-lg" style="animation: fadeUp 0.5s ease-out 0.8s both;">
            <h4 class="font-bold mb-3 text-sm uppercase tracking-wider text-slate-300">Demo Credentials</h4>
            <div class="space-y-3 text-sm">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-blue-300 font-semibold text-xs mb-1">Admin Login</p>
                    <p class="text-slate-300">admin@jasakami.com</p>
                    <p class="text-slate-400 text-xs">Pass: admin123</p>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-emerald-300 font-semibold text-xs mb-1">User Login</p>
                    <p class="text-slate-300">user@jasakami.com</p>
                    <p class="text-slate-400 text-xs">Pass: user123</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
