<?php
// Admin — Bookings Management
ob_start();
$bookings = $bookings ?? [];
?>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Bookings</h1>
        <p class="text-sm text-slate-400 mt-1">Total <?= count($bookings) ?> booking</p>
    </div>
    <div class="flex gap-3">
        <select id="filter-status" onchange="filterBookings()"
            class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
            <option value="">Semua Status</option>
            <option value="pending">Menunggu</option>
            <option value="confirmed">Dikonfirmasi</option>
            <option value="completed">Selesai</option>
            <option value="cancelled">Dibatalkan</option>
        </select>
        <div class="relative">
            <input type="text" id="search-bookings" placeholder="Cari booking..."
                class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all w-52">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <?php
    $pending = count(array_filter($bookings, fn($b) => $b['status'] === 'pending'));
    $confirmed = count(array_filter($bookings, fn($b) => $b['status'] === 'confirmed'));
    $completed = count(array_filter($bookings, fn($b) => $b['status'] === 'completed'));
    $cancelled = count(array_filter($bookings, fn($b) => $b['status'] === 'cancelled'));
    ?>
    <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-center">
        <p class="text-2xl font-bold text-amber-600"><?= $pending ?></p>
        <p class="text-xs font-medium text-amber-500 mt-1">Menunggu</p>
    </div>
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-center">
        <p class="text-2xl font-bold text-blue-600"><?= $confirmed ?></p>
        <p class="text-xs font-medium text-blue-500 mt-1">Dikonfirmasi</p>
    </div>
    <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 text-center">
        <p class="text-2xl font-bold text-emerald-600"><?= $completed ?></p>
        <p class="text-xs font-medium text-emerald-500 mt-1">Selesai</p>
    </div>
    <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center">
        <p class="text-2xl font-bold text-red-600"><?= $cancelled ?></p>
        <p class="text-xs font-medium text-red-500 mt-1">Dibatalkan</p>
    </div>
</div>

<!-- Bookings Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" style="animation: fadeUp 0.5s ease-out both;">
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="bookings-table">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wider text-slate-400 bg-slate-50/80">
                    <th class="px-6 py-4 font-semibold">ID</th>
                    <th class="px-6 py-4 font-semibold">Customer</th>
                    <th class="px-6 py-4 font-semibold">Worker</th>
                    <th class="px-6 py-4 font-semibold">Layanan</th>
                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                    <th class="px-6 py-4 font-semibold">Total</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold">Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="bookings-tbody">
                <?php foreach ($bookings as $b):
                    $statusColors = [
                        'pending' => 'text-amber-700 bg-amber-50 border-amber-200',
                        'confirmed' => 'text-blue-700 bg-blue-50 border-blue-200',
                        'completed' => 'text-emerald-700 bg-emerald-50 border-emerald-200',
                        'cancelled' => 'text-red-700 bg-red-50 border-red-200',
                    ];
                    $sc = $statusColors[$b['status']] ?? 'text-gray-700 bg-gray-50 border-gray-200';
                    ?>
                    <tr class="table-row-hover transition-colors booking-row" data-booking-id="<?= $b['id'] ?>" data-status="<?= $b['status'] ?>">
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono text-slate-400">#<?= $b['id'] ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-700"><?= htmlspecialchars($b['user_name']) ?></p>
                                <p class="text-xs text-slate-400"><?= htmlspecialchars($b['user_email'] ?? '') ?></p>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-600"><?= htmlspecialchars($b['worker_name']) ?></td>
                        <td class="px-6 py-4">
                            <span class="text-gray-600"><?= htmlspecialchars($b['service']) ?></span>
                            <p class="text-xs text-slate-400"><?= htmlspecialchars($b['section']) ?></p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-600"><?= htmlspecialchars($b['date']) ?></span>
                            <p class="text-xs text-slate-400"><?= htmlspecialchars($b['time']) ?></p>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-700"><?= htmlspecialchars($b['total_formatted']) ?></td>
                        <td class="px-6 py-4">
                            <select onchange="updateBookingStatus(<?= $b['id'] ?>, this.value)"
                                class="px-3 py-1.5 text-xs font-semibold rounded-lg border cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand/20 transition-all <?= $sc ?>">
                                <option value="pending" <?= $b['status'] === 'pending' ? 'selected' : '' ?>>Menunggu</option>
                                <option value="confirmed" <?= $b['status'] === 'confirmed' ? 'selected' : '' ?>>Dikonfirmasi</option>
                                <option value="completed" <?= $b['status'] === 'completed' ? 'selected' : '' ?>>Selesai</option>
                                <option value="cancelled" <?= $b['status'] === 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400"><?= htmlspecialchars($b['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($bookings)): ?>
        <div class="px-6 py-16 text-center text-slate-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="text-lg font-semibold mb-1">Belum ada booking</p>
            <p class="text-sm">Booking akan muncul di sini setelah pelanggan memesan.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Toast -->
<div id="toast" class="fixed bottom-6 right-6 z-50 hidden transform translate-y-4 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 px-5 py-4 bg-white rounded-2xl shadow-xl border border-slate-100">
        <div id="toast-icon" class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm"></div>
        <p id="toast-message" class="text-sm font-medium text-gray-700"></p>
    </div>
</div>

<script>
// Search
document.getElementById('search-bookings')?.addEventListener('input', function() {
    filterBookings();
});

function filterBookings() {
    const status = document.getElementById('filter-status').value;
    const query = (document.getElementById('search-bookings').value || '').toLowerCase();

    document.querySelectorAll('.booking-row').forEach(row => {
        const rowStatus = row.dataset.status;
        const text = row.textContent.toLowerCase();
        const matchStatus = !status || rowStatus === status;
        const matchQuery = !query || text.includes(query);
        row.style.display = (matchStatus && matchQuery) ? '' : 'none';
    });
}

async function updateBookingStatus(bookingId, newStatus) {
    try {
        const res = await fetch('/api/admin/bookings/status', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ booking_id: bookingId, status: newStatus })
        });
        const data = await res.json();
        showToast(data.message, data.success);
        if (data.success) {
            const row = document.querySelector(`[data-booking-id="${bookingId}"]`);
            if (row) row.dataset.status = newStatus;
            setTimeout(() => window.location.reload(), 800);
        }
    } catch (err) {
        showToast('Gagal mengupdate status.', false);
    }
}

function showToast(message, success = true) {
    const toast = document.getElementById('toast');
    const icon = document.getElementById('toast-icon');
    const msg = document.getElementById('toast-message');

    icon.className = 'w-8 h-8 rounded-full flex items-center justify-center text-white text-sm';
    icon.classList.add(success ? 'bg-emerald-500' : 'bg-red-500');
    icon.textContent = success ? '✓' : '✕';
    msg.textContent = message;

    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.remove('translate-y-4', 'opacity-0'), 10);
    setTimeout(() => {
        toast.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => toast.classList.add('hidden'), 300);
    }, 3000);
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
