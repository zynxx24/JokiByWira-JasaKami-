/**
 * JasaKami — Pencari Daily Worker
 * Main application JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initMobileMenu();
    initSmoothScroll();
    initScrollReveal();
    initCounterAnimation();
    initLoginForm();
    initBookingWizard();
    initTimeSlots();
});

// ==========================================
// NAVBAR SCROLL EFFECT
// ==========================================
function initNavbar() {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;

    // Only apply scroll effect on home page (transparent → solid)
    const isHome = document.body.querySelector('#hero');
    if (!isHome) return;

    const handleScroll = () => {
        if (window.scrollY > 60) {
            navbar.classList.add('bg-white/95', 'backdrop-blur-xl', 'shadow-lg', 'shadow-black/5');
            navbar.classList.remove('bg-transparent');

            // Update text colors for visibility on white background
            navbar.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('text-white/90', 'hover:text-white');
                link.classList.add('text-gray-600', 'hover:text-brand-dark');
                // Update underline color
                link.classList.remove('after:bg-white');
                link.classList.add('after:bg-brand-dark');
            });

            const logo = navbar.querySelector('span');
            if (logo) {
                logo.classList.remove('text-white');
                logo.classList.add('text-gray-800');
            }

            const loginBtn = navbar.querySelector('a[href="/login"].bg-white');
            if (loginBtn) {
                loginBtn.classList.remove('bg-white', 'text-brand-dark', 'hover:bg-mint-50');
                loginBtn.classList.add('bg-gradient-to-r', 'from-brand', 'to-brand-dark', 'text-white');
            }
        } else {
            navbar.classList.remove('bg-white/95', 'backdrop-blur-xl', 'shadow-lg', 'shadow-black/5');
            navbar.classList.add('bg-transparent');

            navbar.querySelectorAll('.nav-link').forEach(link => {
                link.classList.add('text-white/90', 'hover:text-white');
                link.classList.remove('text-gray-600', 'hover:text-brand-dark');
                link.classList.remove('after:bg-brand-dark');
                link.classList.add('after:bg-white');
            });

            const logo = navbar.querySelector('span');
            if (logo) {
                logo.classList.add('text-white');
                logo.classList.remove('text-gray-800');
            }

            const loginBtn = navbar.querySelector('a[href="/login"].bg-gradient-to-r');
            if (loginBtn) {
                loginBtn.classList.add('bg-white', 'text-brand-dark', 'hover:bg-mint-50');
                loginBtn.classList.remove('bg-gradient-to-r', 'from-brand', 'to-brand-dark', 'text-white');
            }
        }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
}

// ==========================================
// MOBILE MENU
// ==========================================
function initMobileMenu() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        // Animate hamburger
        const spans = btn.querySelectorAll('span');
        if (!menu.classList.contains('hidden')) {
            spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
            spans[1].style.opacity = '0';
            spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
        } else {
            spans[0].style.transform = '';
            spans[1].style.opacity = '1';
            spans[2].style.transform = '';
        }
    });

    // Close on mobile link click
    menu.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.add('hidden');
            const spans = btn.querySelectorAll('span');
            spans[0].style.transform = '';
            spans[1].style.opacity = '1';
            spans[2].style.transform = '';
        });
    });
}

// ==========================================
// SMOOTH SCROLL
// ==========================================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (targetId === '#') return;
            const el = document.querySelector(targetId);
            if (el) {
                e.preventDefault();
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
}

// ==========================================
// SCROLL REVEAL (Intersection Observer)
// ==========================================
function initScrollReveal() {
    const items = document.querySelectorAll('.reveal-item');
    if (!items.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-8');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    items.forEach((item, i) => {
        item.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-700');
        item.style.transitionDelay = `${i * 80}ms`;
        observer.observe(item);
    });
}

// ==========================================
// COUNTER ANIMATION
// ==========================================
function initCounterAnimation() {
    const counters = document.querySelectorAll('.counter');
    if (!counters.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(c => observer.observe(c));
}

function animateCounter(el) {
    const target = parseFloat(el.dataset.target);
    const isDecimal = target % 1 !== 0;
    const duration = 2000;
    const start = performance.now();

    function update(currentTime) {
        const elapsed = currentTime - start;
        const progress = Math.min(elapsed / duration, 1);
        // Ease-out cubic
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = target * eased;

        if (isDecimal) {
            el.textContent = current.toFixed(1);
        } else {
            el.textContent = Math.floor(current).toLocaleString();
        }

        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            if (isDecimal) {
                el.textContent = target.toFixed(1);
            } else {
                el.textContent = target.toLocaleString() + '+';
            }
        }
    }
    requestAnimationFrame(update);
}

// ==========================================
// LOGIN FORM
// ==========================================
function initLoginForm() {
    const form = document.getElementById('login-form');
    if (!form) return;

    // Toggle password visibility
    const toggleBtn = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });
    }

    // Form submit
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = form.querySelector('#email').value;
        const password = form.querySelector('#password').value;
        const errorDiv = document.getElementById('error-message');

        if (!email || !password) {
            showError(errorDiv, 'Harap isi semua field!');
            return;
        }

        // Demo credentials
        if (email === 'admin@jasakami.com' && password === 'admin123') {
            const btn = form.querySelector('#login-btn');
            btn.textContent = 'Logging in...';
            btn.disabled = true;
            setTimeout(() => {
                window.location.href = '/booking';
            }, 1000);
        } else {
            showError(errorDiv, 'Email atau password salah. Coba: admin@jasakami.com / admin123');
        }
    });
}

function showError(el, msg) {
    if (!el) return;
    el.textContent = msg;
    el.classList.remove('hidden');
    setTimeout(() => el.classList.add('hidden'), 5000);
}

// ==========================================
// BOOKING WIZARD
// ==========================================
let bookingHistory = ['step-jasa'];
let selectedWorker = null;

const STEP_LABELS = {
    'step-jasa': 'Pilih Jasa',
    'step-perhotelan': 'Perhotelan',
    'step-kuliner': 'Kuliner',
    'step-pplg': 'PPLG',
    'step-gender': 'Gender',
    'step-workers': 'Pekerja',
    'step-interview': 'Interview',
    'step-confirm': 'Konfirmasi',
    'step-success': 'Selesai',
};

function initBookingWizard() {
    const steps = document.querySelectorAll('.booking-step');
    if (!steps.length) return;

    updateBreadcrumb();
}

function goStep(stepId) {
    // Hide all steps
    document.querySelectorAll('.booking-step').forEach(s => s.classList.add('hidden'));

    // Show target step
    const target = document.getElementById(stepId);
    if (target) {
        target.classList.remove('hidden');

        // Animate entrance
        target.style.animation = 'fadeUp 0.5s ease-out';
        setTimeout(() => target.style.animation = '', 500);
    }

    // Track history
    const idx = bookingHistory.indexOf(stepId);
    if (idx >= 0) {
        bookingHistory = bookingHistory.slice(0, idx + 1);
    } else {
        bookingHistory.push(stepId);
    }

    updateBreadcrumb();

    // Generate order ID on success
    if (stepId === 'step-success') {
        const oid = document.getElementById('order-id');
        if (oid) oid.textContent = 'JK-' + new Date().getFullYear() + '-' + String(Math.floor(Math.random() * 999) + 1).padStart(3, '0');

        // Set WhatsApp link
        if (selectedWorker) {
            const waLink = document.getElementById('wa-link');
            if (waLink) {
                waLink.href = `https://wa.me/${selectedWorker.phone}?text=${encodeURIComponent('Halo, saya ingin memesan layanan JasaKami. Saya tertarik dengan pekerja: ' + selectedWorker.name)}`;
            }
        }
    }

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateBreadcrumb() {
    const trail = document.getElementById('breadcrumb-trail');
    if (!trail) return;

    trail.innerHTML = bookingHistory.map((step, idx) => {
        const label = STEP_LABELS[step] || step;
        const isLast = idx === bookingHistory.length - 1;
        const isCurrent = isLast;

        if (isCurrent) {
            return `<span class="text-brand-dark font-semibold">${label}</span>`;
        }
        return `<span class="breadcrumb-item cursor-pointer hover:text-brand-dark transition-colors" onclick="goStep('${step}')">${label}</span>`;
    }).join('<span class="text-gray-300 mx-1">›</span>');
}

// ==========================================
// SHOW WORKERS (filtered by gender)
// ==========================================
function showWorkers(gender) {
    const workers = window.WORKERS_DATA || [];
    const filtered = workers.filter(w => w.gender === gender);

    const grid = document.getElementById('workers-grid');
    if (!grid) return;

    const badge = document.getElementById('worker-badge');
    const title = document.getElementById('worker-title');

    const genderColors = {
        female: { bg: 'bg-pink-100', text: 'text-pink-600', label: 'Female Workers' },
        male: { bg: 'bg-blue-100', text: 'text-blue-600', label: 'Male Workers' },
    };
    const gc = genderColors[gender] || genderColors.female;

    if (badge) {
        badge.className = `inline-block px-4 py-1.5 ${gc.bg} ${gc.text} text-sm font-semibold rounded-full mb-4`;
        badge.textContent = gc.label;
    }

    grid.innerHTML = filtered.map(w => `
        <div onclick="selectWorker(${w.id})" class="glass-card group cursor-pointer rounded-3xl overflow-hidden border border-mint-100 hover:border-brand/30 hover:shadow-2xl hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-3">
            <div class="relative h-52 overflow-hidden bg-gradient-to-br from-mint-50 to-white flex items-center justify-center">
                <img src="/${w.photo}" alt="${w.name}" class="w-36 h-36 object-cover rounded-full border-4 border-white shadow-xl group-hover:scale-110 transition-transform duration-500">
                <div class="absolute top-3 right-3 flex items-center gap-1 px-2.5 py-1 bg-yellow-400/90 rounded-full text-xs font-bold text-yellow-900 backdrop-blur-sm">
                    ⭐ ${w.rating}
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 group-hover:text-brand-dark transition-colors mb-1">${w.name}</h3>
                <p class="text-sm text-brand-dark font-semibold mb-3">${w.role}</p>
                <div class="flex items-center gap-2 flex-wrap mb-3">
                    ${w.languages.map(l => `<span class="text-lg" title="${l.name}">${l.flag}</span>`).join('')}
                    <span class="text-xs text-gray-400 ml-1">${w.languages.map(l => l.name).join(', ')}</span>
                </div>
                <div class="grid grid-cols-2 gap-3 text-center mb-4">
                    <div class="bg-mint-50 rounded-lg py-2">
                        <div class="text-xs text-gray-400">Usia</div>
                        <div class="text-sm font-bold text-gray-800">${w.age} th</div>
                    </div>
                    <div class="bg-mint-50 rounded-lg py-2">
                        <div class="text-xs text-gray-400">Fee/hari</div>
                        <div class="text-sm font-bold text-brand-dark">${w.fee_formatted}</div>
                    </div>
                </div>
                <div class="text-xs text-gray-400 mb-4">
                    <span class="font-medium text-gray-600">Pengalaman:</span> ${w.experience}
                </div>
                <button class="w-full py-3 bg-gradient-to-r from-brand to-brand-dark text-white font-bold rounded-xl shadow-md shadow-brand/20 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all text-sm">
                    Pilih Pekerja
                </button>
            </div>
        </div>
    `).join('');

    if (filtered.length === 0) {
        grid.innerHTML = `
            <div class="col-span-full text-center py-12 text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-lg font-semibold">Belum ada pekerja tersedia</p>
                <p class="text-sm">Silakan coba filter lain</p>
            </div>
        `;
    }

    goStep('step-workers');
}

// ==========================================
// SELECT WORKER
// ==========================================
function selectWorker(id) {
    const workers = window.WORKERS_DATA || [];
    selectedWorker = workers.find(w => w.id === id);
    if (!selectedWorker) return;

    // Fill interview panel
    const set = (sel, val) => {
        const el = document.getElementById(sel);
        if (el) {
            if (el.src !== undefined && sel.includes('img')) {
                el.src = '/' + selectedWorker.photo;
            } else {
                el.textContent = val;
            }
        }
    };

    set('selected-worker-img', '');
    document.getElementById('selected-worker-img').src = '/' + selectedWorker.photo;
    set('selected-worker-name', selectedWorker.name);
    set('selected-worker-role', selectedWorker.role);
    set('selected-worker-fee', selectedWorker.fee_formatted);

    // Fill confirm panel
    const confirmImg = document.getElementById('confirm-worker-img');
    if (confirmImg) confirmImg.src = '/' + selectedWorker.photo;
    set('confirm-worker-name', selectedWorker.name);
    set('confirm-worker-role', selectedWorker.role);
    set('confirm-fee', selectedWorker.fee_formatted);

    const total = selectedWorker.fee + 5000;
    const totalFmt = 'Rp' + total.toLocaleString('id-ID');
    set('confirm-total', totalFmt);

    goStep('step-interview');
}

// ==========================================
// TIME SLOTS
// ==========================================
function initTimeSlots() {
    document.querySelectorAll('.time-slot').forEach(slot => {
        slot.addEventListener('click', () => {
            document.querySelectorAll('.time-slot').forEach(s => {
                s.classList.remove('border-brand', 'text-brand', 'bg-mint-50', 'font-semibold');
            });
            slot.classList.add('border-brand', 'text-brand', 'bg-mint-50', 'font-semibold');
        });
    });
}
