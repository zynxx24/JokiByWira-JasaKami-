/**
 * JasaKami — Admin Panel JavaScript
 * Minimal admin-specific functionality
 */

document.addEventListener('DOMContentLoaded', () => {
    initAdminNavHighlight();
});

function initAdminNavHighlight() {
    // Auto-close mobile sidebar on link click
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                const sidebar = document.getElementById('admin-sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                if (sidebar) sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
            }
        });
    });
}
