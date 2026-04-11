<?php
// Admin — User Management
ob_start();
$users = $users ?? [];
?>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Users</h1>
        <p class="text-sm text-slate-400 mt-1">Total <?= count($users) ?> users terdaftar</p>
    </div>
    <div class="flex gap-3">
        <div class="relative">
            <input type="text" id="search-users" placeholder="Cari user..."
                class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all w-64">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" style="animation: fadeUp 0.5s ease-out both;">
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="users-table">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wider text-slate-400 bg-slate-50/80">
                    <th class="px-6 py-4 font-semibold">ID</th>
                    <th class="px-6 py-4 font-semibold">User</th>
                    <th class="px-6 py-4 font-semibold">Email</th>
                    <th class="px-6 py-4 font-semibold">Phone</th>
                    <th class="px-6 py-4 font-semibold">Role</th>
                    <th class="px-6 py-4 font-semibold">Terdaftar</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="users-tbody">
                <?php foreach ($users as $u): ?>
                    <tr class="table-row-hover transition-colors user-row" data-user-id="<?= $u['id'] ?>">
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono text-slate-400">#<?= $u['id'] ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand/20 to-blue-100 flex items-center justify-center text-lg shrink-0">
                                    <?= $u['avatar'] ?? '👤' ?>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-700 truncate"><?= htmlspecialchars($u['name']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($u['email']) ?></td>
                        <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($u['phone'] ?? '-') ?></td>
                        <td class="px-6 py-4">
                            <select
                                onchange="updateUserRole(<?= $u['id'] ?>, this.value)"
                                class="px-3 py-1.5 text-xs font-semibold rounded-lg border cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand/20 transition-all <?= $u['role'] === 'admin' ? 'bg-purple-50 text-purple-600 border-purple-200' : 'bg-slate-50 text-slate-600 border-slate-200' ?>">
                                <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400"><?= htmlspecialchars($u['created_at'] ?? '-') ?></td>
                        <td class="px-6 py-4 text-center">
                            <?php if ($u['id'] !== ($user['id'] ?? 0)): ?>
                                <button
                                    onclick="deleteUser(<?= $u['id'] ?>, '<?= htmlspecialchars(addslashes($u['name'])) ?>')"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all"
                                    title="Hapus user">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            <?php else: ?>
                                <span class="text-xs text-slate-300 italic">You</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($users)): ?>
        <div class="px-6 py-16 text-center text-slate-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <p class="text-lg font-semibold mb-1">Belum ada user terdaftar</p>
            <p class="text-sm">Users akan muncul di sini setelah registrasi.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Toast notification -->
<div id="toast" class="fixed bottom-6 right-6 z-50 hidden transform translate-y-4 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 px-5 py-4 bg-white rounded-2xl shadow-xl border border-slate-100">
        <div id="toast-icon" class="w-8 h-8 rounded-full flex items-center justify-center"></div>
        <p id="toast-message" class="text-sm font-medium text-gray-700"></p>
    </div>
</div>

<script>
// Search
document.getElementById('search-users')?.addEventListener('input', function() {
    const query = this.value.toLowerCase();
    document.querySelectorAll('.user-row').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
});

// Update user role
async function updateUserRole(userId, newRole) {
    try {
        const res = await fetch('/api/admin/users/role', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId, role: newRole })
        });
        const data = await res.json();
        showToast(data.message, data.success);
        if (data.success) {
            setTimeout(() => window.location.reload(), 800);
        }
    } catch (err) {
        showToast('Gagal mengupdate role.', false);
    }
}

// Delete user
async function deleteUser(userId, userName) {
    if (!confirm(`Yakin hapus user "${userName}"?`)) return;
    try {
        const res = await fetch('/api/admin/users/delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId })
        });
        const data = await res.json();
        showToast(data.message, data.success);
        if (data.success) {
            const row = document.querySelector(`[data-user-id="${userId}"]`);
            if (row) {
                row.style.animation = 'fadeOut 0.3s ease forwards';
                setTimeout(() => row.remove(), 300);
            }
        }
    } catch (err) {
        showToast('Gagal menghapus user.', false);
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
    setTimeout(() => {
        toast.classList.remove('translate-y-4', 'opacity-0');
    }, 10);

    setTimeout(() => {
        toast.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => toast.classList.add('hidden'), 300);
    }, 3000);
}
</script>

<style>
@keyframes fadeOut {
    to { opacity: 0; transform: translateX(-20px); height: 0; padding: 0; overflow: hidden; }
}
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
