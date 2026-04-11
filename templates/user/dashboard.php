<?php
// User Dashboard
ob_start();
$bookings = $bookings ?? [];
$user = $user ?? [];

$totalBookings = count($bookings);
$pendingBookings = count(array_filter($bookings, fn($b) => $b['status'] === 'pending'));
$completedBookings = count(array_filter($bookings, fn($b) => $b['status'] === 'completed'));
$totalSpent = array_sum(array_column($bookings, 'total'));
?>

<!-- Profile Card -->
<div class="bg-gradient-to-r from-brand via-blue-500 to-brand-dark rounded-2xl p-8 text-white mb-8 relative overflow-hidden shadow-xl" style="animation: fadeUp 0.5s ease-out both;">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
    <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-white/5 rounded-full blur-xl"></div>
    <div class="relative flex flex-col sm:flex-row items-start sm:items-center gap-6">
        <div class="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-4xl shadow-lg">
            <?= $user['avatar'] ?? '👤' ?>
        </div>
        <div>
            <h1 class="text-2xl font-bold"><?= htmlspecialchars($user['name'] ?? 'User') ?></h1>
            <p class="text-blue-100 text-sm mt-1"><?= htmlspecialchars($user['email'] ?? '') ?></p>
            <div class="flex items-center gap-3 mt-3">
                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                    <?= ucfirst($user['role'] ?? 'user') ?>
                </span>
                <span class="text-blue-200 text-xs">Bergabung: <?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow" style="animation: fadeUp 0.5s ease-out 0.1s both;">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?= $totalBookings ?></p>
        <p class="text-xs text-slate-400 font-medium mt-1">Total Booking</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow" style="animation: fadeUp 0.5s ease-out 0.15s both;">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?= $pendingBookings ?></p>
        <p class="text-xs text-slate-400 font-medium mt-1">Menunggu</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow" style="animation: fadeUp 0.5s ease-out 0.2s both;">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?= $completedBookings ?></p>
        <p class="text-xs text-slate-400 font-medium mt-1">Selesai</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow" style="animation: fadeUp 0.5s ease-out 0.25s both;">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-lg bg-violet-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800">Rp<?= number_format($totalSpent, 0, ',', '.') ?></p>
        <p class="text-xs text-slate-400 font-medium mt-1">Total Pengeluaran</p>
    </div>
</div>

<!-- Quick Action -->
<div class="flex gap-3 mb-8" style="animation: fadeUp 0.5s ease-out 0.3s both;">
    <a href="/booking" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-brand to-brand-dark text-white font-semibold rounded-xl shadow-lg shadow-brand/20 hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Pesan Layanan Baru
    </a>
</div>

<!-- My Bookings -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" style="animation: fadeUp 0.5s ease-out 0.4s both;">
    <div class="px-6 py-5 border-b border-slate-50">
        <h3 class="text-lg font-bold text-gray-800">Riwayat Booking Saya</h3>
        <p class="text-sm text-slate-400 mt-1">Semua pesanan yang pernah Anda buat</p>
    </div>

    <?php if (!empty($bookings)): ?>
        <div class="divide-y divide-slate-50">
            <?php foreach ($bookings as $b):
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
                $sc = $statusColors[$b['status']] ?? '';
                $sl = $statusLabels[$b['status']] ?? $b['status'];
                ?>
                <div class="px-6 py-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 hover:bg-slate-50/50 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand/10 to-blue-50 flex items-center justify-center text-xl shrink-0">
                        <?php
                        $icons = ['Perhotelan' => '🏨', 'Kuliner' => '🍳', 'PPLG' => '💻'];
                        echo $icons[$b['service']] ?? '📋';
                        ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-700"><?= htmlspecialchars($b['worker_name']) ?></p>
                        <p class="text-sm text-slate-400"><?= htmlspecialchars($b['service']) ?> — <?= htmlspecialchars($b['section']) ?></p>
                        <p class="text-xs text-slate-300 mt-1">📅 <?= htmlspecialchars($b['date']) ?> | ⏰ <?= htmlspecialchars($b['time']) ?></p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full border <?= $sc ?>"><?= $sl ?></span>
                        <p class="font-bold text-gray-700 text-sm"><?= htmlspecialchars($b['total_formatted']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="px-6 py-16 text-center">
            <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-slate-50 flex items-center justify-center text-4xl">📋</div>
            <p class="text-lg font-semibold text-gray-600 mb-2">Belum ada booking</p>
            <p class="text-sm text-slate-400 mb-6">Anda belum pernah memesan layanan. Mulai sekarang!</p>
            <a href="/booking" class="inline-flex items-center gap-2 px-6 py-3 bg-brand text-white font-semibold rounded-xl hover:bg-brand-dark transition-colors text-sm">
                Pesan Layanan
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
