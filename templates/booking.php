<?php
// Booking wizard — rendered inside layout.php
ob_start();
$workers = $workers ?? [];
$services = $services ?? [];
$departments = $services['departments'] ?? [];
?>

<style>
    .step-indicator {
        transition: all 0.3s;
    }

    .step-indicator.active {
        background: linear-gradient(135deg, #4dd9a0, #2ecc71);
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 20px rgba(77, 217, 160, 0.3);
    }

    .step-indicator.done {
        background: #22c55e;
        color: white;
    }

    .dept-card {
        transition: all 0.4s cubic-bezier(.4, 0, .2, 1);
    }

    .dept-card:hover {
        transform: translateY(-8px);
    }

    .section-card {
        transition: all 0.3s;
    }

    .section-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
    }

    /* ---- Payment Gateway Styles ---- */
    .payment-method-card {
        cursor: pointer;
        transition: all 0.25s cubic-bezier(.4,0,.2,1);
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        background: #fff;
    }
    .payment-method-card:hover {
        border-color: #4dd9a0;
        box-shadow: 0 8px 24px rgba(77,217,160,0.15);
        transform: translateY(-2px);
    }
    .payment-method-card.selected {
        border-color: #22c55e;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        box-shadow: 0 8px 30px rgba(34,197,94,0.2);
    }
    .payment-method-card.selected .pm-radio {
        background: #22c55e;
        border-color: #22c55e;
    }
    .payment-method-card.selected .pm-radio::after {
        opacity: 1;
    }
    .pm-radio {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #d1d5db;
        position: relative;
        flex-shrink: 0;
        transition: all 0.2s;
    }
    .pm-radio::after {
        content: '';
        position: absolute;
        inset: 3px;
        background: white;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .bank-detail-panel {
        display: none;
        animation: fadeSlideIn 0.3s ease;
    }
    .bank-detail-panel.active {
        display: block;
    }
    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .copy-btn {
        transition: all 0.2s;
    }
    .copy-btn:hover {
        background: #22c55e;
        color: white;
    }
    .copy-btn.copied {
        background: #22c55e;
        color: white;
    }

    /* QRIS scan box */
    .qris-frame {
        background: linear-gradient(135deg, #1e3a5f, #0f172a);
        border-radius: 1.5rem;
        padding: 2px;
    }
    .qris-inner {
        background: #ffffff;
        border-radius: calc(1.5rem - 2px);
        padding: 1.5rem;
    }
    .qris-corners {
        position: relative;
        display: inline-block;
    }
    .qris-corners::before,
    .qris-corners::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        border-color: #22c55e;
        border-style: solid;
    }
    .qris-corners::before {
        top: -4px; left: -4px;
        border-width: 3px 0 0 3px;
        border-radius: 4px 0 0 0;
    }
    .qris-corners::after {
        bottom: -4px; right: -4px;
        border-width: 0 3px 3px 0;
        border-radius: 0 0 4px 0;
    }

    /* Timer */
    .payment-timer {
        font-variant-numeric: tabular-nums;
        font-feature-settings: 'tnum';
    }
    .timer-ring {
        transform-origin: center;
        transform: rotate(-90deg);
        stroke-dasharray: 113;
        stroke-dashoffset: 0;
        transition: stroke-dashoffset 1s linear;
    }

    /* Upload proof */
    .upload-zone {
        border: 2px dashed #d1d5db;
        border-radius: 1rem;
        transition: all 0.3s;
    }
    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: #4dd9a0;
        background: #f0fdf4;
    }

    /* Bank logo icons (SVG shapes) */
    .bank-logo {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0;
        flex-shrink: 0;
    }
</style>

<section class="min-h-screen pt-24 pb-16 bg-gradient-to-b from-gray-50 to-white">
    <!-- Progress breadcrumb -->
    <div class="max-w-4xl mx-auto px-6 mb-8">
        <div class="flex items-center gap-2 text-sm text-gray-400 py-3 px-5 bg-white rounded-xl shadow-sm border border-gray-100"
            id="breadcrumb-trail">
            <span class="text-brand-dark font-semibold">Pilih Jasa</span>
        </div>
    </div>

    <!-- ===== STEP 1: Pilih Jasa / Department ===== -->
    <div id="step-jasa" class="booking-step max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand/10 text-brand-dark text-sm font-semibold rounded-full mb-4">
                Langkah 1</div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Pilih <span class="text-gradient">Bidang
                    Jasa</span></h2>
            <p class="text-gray-500 mt-3">Temukan layanan profesional terbaik untuk kebutuhan Anda.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $deptGradients = [
                'perhotelan' => ['from-emerald-500 to-teal-600', 'emerald', 'shadow-emerald-200/50'],
                'kuliner' => ['from-orange-500 to-red-500', 'orange', 'shadow-orange-200/50'],
                'pplg' => ['from-violet-500 to-purple-600', 'violet', 'shadow-purple-200/50'],
            ];
            $deptImages = [
                'perhotelan' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
                'kuliner'    => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80',
                'pplg'       => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&q=80',
            ];
            foreach ($departments as $dept):
                $dg = $deptGradients[$dept['id']] ?? ['from-gray-500 to-gray-600', 'gray', 'shadow-gray-200/50'];
                $deptImg = $deptImages[$dept['id']] ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80';
                ?>
                <div onclick="goStep('step-<?= $dept['id'] ?>')"
                    class="dept-card cursor-pointer group relative rounded-3xl overflow-hidden bg-white shadow-lg <?= $dg[2] ?> hover:shadow-2xl border border-gray-100 hover:border-transparent <?= $dept['available'] ? '' : 'opacity-60 pointer-events-none' ?>">
                    <div class="h-48 relative overflow-hidden">
                        <img src="<?= htmlspecialchars($deptImg) ?>" alt="<?= htmlspecialchars($dept['name']) ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        <h3 class="absolute bottom-4 left-6 text-2xl font-extrabold text-white drop-shadow-lg">
                            <?= htmlspecialchars($dept['name']) ?></h3>
                        <?php if (!empty($dept['badge'])): ?>
                            <span
                                class="absolute top-3 right-3 px-2.5 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full"><?= htmlspecialchars($dept['badge']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-500 text-sm mb-4"><?= htmlspecialchars($dept['description']) ?></p>
                        <?php if (!empty($dept['sections'])): ?>
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                <?php foreach ($dept['sections'] as $sec): ?>
                                    <span
                                        class="px-2 py-1 bg-<?= $dg[1] ?>-50 text-<?= $dg[1] ?>-700 text-xs rounded-lg font-medium"><?= htmlspecialchars($sec['name']) ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="flex items-center gap-2 text-sm font-semibold text-<?= $dg[1] ?>-600">
                            Pilih Bidang Ini
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ===== STEP: Perhotelan sections ===== -->
    <div id="step-perhotelan" class="booking-step hidden max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-100 text-emerald-700 text-sm font-semibold rounded-full mb-4">
                <!-- Hotel/Building icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Perhotelan</div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Pilih <span
                    class="text-gradient">Section</span></h2>
            <p class="text-gray-500 mt-3">Pilih bidang keahlian yang Anda butuhkan.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div onclick="goStep('step-gender')" data-section="housekeeping"
                class="section-card cursor-pointer bg-white rounded-3xl border-2 border-gray-100 hover:border-emerald-300 shadow-md group overflow-hidden">
                <div class="h-36 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80" alt="Housekeeping"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Housekeeping</h3>
                    <p class="text-gray-500 text-sm mb-4">Room attendant, public area, laundry service.</p>
                    <span class="text-emerald-600 text-sm font-semibold">7 workers tersedia →</span>
                </div>
            </div>
            <div onclick="goStep('step-gender')" data-section="front-office"
                class="section-card cursor-pointer bg-white rounded-3xl border-2 border-gray-100 hover:border-emerald-300 shadow-md group overflow-hidden">
                <div class="h-36 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=600&q=80" alt="Front Office"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Front Office</h3>
                    <p class="text-gray-500 text-sm mb-4">Receptionist, concierge, guest relation.</p>
                    <span class="text-blue-600 text-sm font-semibold">4 workers tersedia →</span>
                </div>
            </div>
        </div>
        <button onclick="goStep('step-jasa')"
            class="mt-8 mx-auto block text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">←
            Kembali</button>
    </div>

    <!-- ===== STEP: Kuliner sections ===== -->
    <div id="step-kuliner" class="booking-step hidden max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 text-orange-700 text-sm font-semibold rounded-full mb-4">
                <!-- Chef hat icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a6 6 0 0112 0H6z"/></svg>
                Kuliner</div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Pilih <span
                    style="background:linear-gradient(135deg,#f97316,#ef4444);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Section</span>
            </h2>
            <p class="text-gray-500 mt-3">Pilih bidang kuliner yang Anda butuhkan.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div onclick="goStep('step-gender')" data-section="kitchen"
                class="section-card cursor-pointer bg-white rounded-3xl border-2 border-gray-100 hover:border-orange-300 shadow-md group overflow-hidden">
                <div class="h-36 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80" alt="Kitchen"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Kitchen</h3>
                    <p class="text-gray-500 text-sm mb-4">Chef, sous chef, pastry chef.</p>
                    <span class="text-orange-600 text-sm font-semibold">3 workers tersedia →</span>
                </div>
            </div>
            <div onclick="goStep('step-gender')" data-section="fnb-service"
                class="section-card cursor-pointer bg-white rounded-3xl border-2 border-gray-100 hover:border-orange-300 shadow-md group overflow-hidden">
                <div class="h-36 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=600&q=80" alt="F&B Service"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        style="object-position: center 30%;">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">F&B Service</h3>
                    <p class="text-gray-500 text-sm mb-4">Barista, mixologist, waiters.</p>
                    <span class="text-amber-600 text-sm font-semibold">2 workers tersedia →</span>
                </div>
            </div>
        </div>
        <button onclick="goStep('step-jasa')"
            class="mt-8 mx-auto block text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">←
            Kembali</button>
    </div>

    <!-- ===== STEP: PPLG sections ===== -->
    <div id="step-pplg" class="booking-step hidden max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-100 text-purple-700 text-sm font-semibold rounded-full mb-4">
                <!-- Code icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                PPLG</div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Pilih <span
                    style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Section</span>
            </h2>
            <p class="text-gray-500 mt-3">Pilih bidang teknologi yang Anda butuhkan.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div onclick="goStep('step-gender')" data-section="development"
                class="section-card cursor-pointer bg-white rounded-3xl border-2 border-gray-100 hover:border-purple-300 shadow-md group overflow-hidden">
                <div class="h-36 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=600&q=80" alt="Development"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Development</h3>
                    <p class="text-gray-500 text-sm mb-4">Fullstack &amp; mobile developer.</p>
                    <span class="text-purple-600 text-sm font-semibold">2 workers →</span>
                </div>
            </div>
            <div onclick="goStep('step-gender')" data-section="design"
                class="section-card cursor-pointer bg-white rounded-3xl border-2 border-gray-100 hover:border-purple-300 shadow-md group overflow-hidden">
                <div class="h-36 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=600&q=80" alt="Design"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        style="object-position: center 70%;">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Design</h3>
                    <p class="text-gray-500 text-sm mb-4">UI/UX &amp; graphic design.</p>
                    <span class="text-pink-600 text-sm font-semibold">1 worker →</span>
                </div>
            </div>
            <div onclick="goStep('step-gender')" data-section="game-dev"
                class="section-card cursor-pointer bg-white rounded-3xl border-2 border-gray-100 hover:border-purple-300 shadow-md group overflow-hidden">
                <div class="h-36 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?w=600&q=80" alt="Game Dev"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        style="object-position: center 40%;">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Game Dev</h3>
                    <p class="text-gray-500 text-sm mb-4">Game development &amp; design.</p>
                    <span class="text-indigo-600 text-sm font-semibold">1 worker →</span>
                </div>
            </div>
        </div>
        <button onclick="goStep('step-jasa')"
            class="mt-8 mx-auto block text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">←
            Kembali</button>
    </div>

    <!-- ===== STEP: Gender ===== -->
    <div id="step-gender" class="booking-step hidden max-w-3xl mx-auto px-6">
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand/10 text-brand-dark text-sm font-semibold rounded-full mb-4">
                Preferensi</div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Pilih <span
                    class="text-gradient">Gender</span></h2>
            <p class="text-gray-500 mt-3">Pilih gender pekerja sesuai kebutuhan Anda.</p>
        </div>
        <div class="grid grid-cols-2 gap-6 max-w-lg mx-auto">
            <button onclick="showWorkers('female')"
                class="group cursor-pointer p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-pink-300 shadow-md hover:shadow-xl hover:-translate-y-2 transition-all text-center">
                <div
                    class="w-20 h-20 mx-auto rounded-full overflow-hidden mb-4 border-4 border-pink-200 group-hover:border-pink-400 transition-colors">
                    <img src="/assets/images/female-icon.jpeg" alt="Female" class="w-full h-full object-cover">
                </div>
                <h3 class="text-lg font-bold text-gray-800 group-hover:text-pink-600 transition-colors">Perempuan</h3>
                <p class="text-xs text-gray-400 mt-1">Female Workers</p>
            </button>
            <button onclick="showWorkers('male')"
                class="group cursor-pointer p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-blue-300 shadow-md hover:shadow-xl hover:-translate-y-2 transition-all text-center">
                <div
                    class="w-20 h-20 mx-auto rounded-full overflow-hidden mb-4 border-4 border-blue-200 group-hover:border-blue-400 transition-colors">
                    <img src="/assets/images/male-icon.jpeg" alt="Male" class="w-full h-full object-cover">
                </div>
                <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Laki-laki</h3>
                <p class="text-xs text-gray-400 mt-1">Male Workers</p>
            </button>
        </div>
        <button onclick="goBack()"
            class="mt-8 mx-auto block text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">←
            Kembali</button>
    </div>

    <!-- ===== STEP: Workers Grid ===== -->
    <div id="step-workers" class="booking-step hidden max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <div id="worker-badge"
                class="inline-block px-4 py-1.5 bg-pink-100 text-pink-600 text-sm font-semibold rounded-full mb-4">
                Female Workers</div>
            <h2 id="worker-title" class="text-3xl md:text-4xl font-extrabold text-gray-900">Pilih <span
                    class="text-gradient">Pekerja</span></h2>
            <p class="text-gray-500 mt-3">Temukan pekerja yang sesuai dengan kebutuhan Anda.</p>
        </div>
        <div id="workers-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Dynamically populated by JS -->
        </div>
        <button onclick="goStep('step-gender')"
            class="mt-8 mx-auto block text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">←
            Kembali</button>
    </div>

    <!-- ===== STEP: Interview ===== -->
    <div id="step-interview" class="booking-step hidden max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-100 text-purple-700 text-sm font-semibold rounded-full mb-4">
                <!-- Calendar icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Opsional</div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Jadwalkan <span
                    style="background:linear-gradient(135deg,#a855f7,#6366f1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Interview</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-5 gap-8">
            <!-- Worker preview card -->
            <div class="md:col-span-2">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 sticky top-28">
                    <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-100">
                        <img id="selected-worker-img" src="" alt=""
                            class="w-16 h-16 rounded-2xl object-cover shadow-md">
                        <div>
                            <h3 id="selected-worker-name" class="font-bold text-gray-800"></h3>
                            <p id="selected-worker-role" class="text-sm text-brand-dark"></p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">Fee per hari</span>
                        <span id="selected-worker-fee" class="text-lg font-bold text-brand-dark"></span>
                    </div>
                </div>
            </div>

            <!-- Interview form -->
            <div class="md:col-span-3 space-y-6">
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-6">Pilih Tanggal &amp; Waktu</h4>
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal</label>
                            <input type="date"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Waktu</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button type="button"
                                    class="time-slot px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-brand transition-colors">09:00</button>
                                <button type="button"
                                    class="time-slot px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-brand transition-colors">10:00</button>
                                <button type="button"
                                    class="time-slot px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-brand transition-colors">11:00</button>
                                <button type="button"
                                    class="time-slot px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-brand transition-colors">13:00</button>
                                <button type="button"
                                    class="time-slot px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-brand transition-colors">14:00</button>
                                <button type="button"
                                    class="time-slot px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-brand transition-colors">15:00</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Catatan (opsional)</label>
                        <textarea
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm"
                            rows="3" placeholder="Tulis catatan untuk interview..."></textarea>
                    </div>
                    <button onclick="goStep('step-confirm')"
                        class="w-full py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-purple-200 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <!-- Calendar check icon -->
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Jadwalkan Interview
                    </button>
                </div>
                <button onclick="goStep('step-confirm')"
                    class="w-full py-4 bg-gray-50 border border-gray-200 text-gray-500 font-semibold rounded-xl hover:bg-gray-100 transition-all text-sm">
                    Lewati, Langsung Pesan →
                </button>
            </div>
        </div>
    </div>

    <!-- ===== STEP: Confirm ===== -->
    <div id="step-confirm" class="booking-step hidden max-w-2xl mx-auto px-6">
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand/10 text-brand-dark text-sm font-semibold rounded-full mb-4">
                <!-- Receipt icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12h6M9 16h4"/></svg>
                Konfirmasi</div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Ringkasan <span
                    class="text-gradient">Pesanan</span></h2>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
            <div class="flex items-center gap-5 pb-6 mb-6 border-b border-gray-100">
                <img id="confirm-worker-img" src="" alt="" class="w-20 h-20 rounded-2xl object-cover shadow-lg">
                <div>
                    <h3 id="confirm-worker-name" class="text-xl font-bold text-gray-800"></h3>
                    <p id="confirm-worker-role" class="text-sm text-brand-dark font-medium"></p>
                </div>
            </div>
            <div class="space-y-4 mb-8">
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-500">Fee per hari</span>
                    <span id="confirm-fee" class="font-semibold text-gray-800"></span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-500">Biaya admin</span>
                    <span class="font-semibold text-gray-800">Rp5.000</span>
                </div>
                <div class="flex justify-between items-center py-3 border-t-2 border-dashed border-gray-200">
                    <span class="text-gray-900 font-bold text-lg">Total</span>
                    <span id="confirm-total" class="text-2xl font-extrabold text-brand-dark"></span>
                </div>
            </div>
            <button onclick="goStep('step-payment')"
                class="w-full py-4 bg-gradient-to-r from-brand to-brand-dark text-white font-bold rounded-xl shadow-lg shadow-brand/30 hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm uppercase tracking-wider flex items-center justify-center gap-2">
                <!-- Credit card icon -->
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Bayar Sekarang
            </button>
            <button onclick="goStep('step-interview')"
                class="w-full mt-3 py-3 text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">←
                Kembali</button>
        </div>
    </div>

    <!-- ===== STEP: Payment Gateway ===== -->
    <div id="step-payment" class="booking-step hidden max-w-3xl mx-auto px-6">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-50 text-emerald-700 text-sm font-semibold rounded-full mb-4">
                <!-- Shield check icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Pembayaran Aman
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Pilih Metode <span class="text-gradient">Pembayaran</span></h2>
            <p class="text-gray-500 mt-3">Transaksi dilindungi enkripsi SSL 256-bit</p>
        </div>

        <!-- Order Summary Strip -->
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 text-white rounded-2xl px-6 py-4 mb-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-white/50">Pembayaran untuk</p>
                    <p id="pay-worker-name" class="font-semibold text-sm"></p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-white/50">Total tagihan</p>
                <p id="pay-total-amount" class="text-xl font-extrabold text-emerald-400"></p>
            </div>
        </div>

        <!-- Payment Timer -->
        <div class="flex items-center justify-center gap-3 mb-8 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
            <svg class="w-12 h-12 -rotate-90" viewBox="0 0 40 40">
                <circle cx="20" cy="20" r="18" fill="none" stroke="#fde68a" stroke-width="3"/>
                <circle id="timer-ring" cx="20" cy="20" r="18" fill="none" stroke="#f59e0b" stroke-width="3"
                    stroke-dasharray="113" stroke-dashoffset="0" stroke-linecap="round"
                    style="transform-origin:center;transform:rotate(-90deg);transition:stroke-dashoffset 1s linear;"/>
            </svg>
            <div>
                <p class="text-xs text-amber-600 font-medium">Selesaikan pembayaran dalam</p>
                <p id="payment-timer" class="text-2xl font-extrabold text-amber-700 payment-timer">14:59</p>
            </div>
        </div>

        <!-- Tab: Bank / QRIS -->
        <div class="flex gap-2 mb-6 p-1.5 bg-gray-100 rounded-2xl">
            <button id="tab-bank" onclick="switchPayTab('bank')"
                class="pay-tab flex-1 py-3 rounded-xl text-sm font-bold transition-all bg-white shadow text-gray-800 flex items-center justify-center gap-2">
                <!-- Bank/building icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 10v11M12 10v11M16 10v11"/></svg>
                Transfer Bank
            </button>
            <button id="tab-qris" onclick="switchPayTab('qris')"
                class="pay-tab flex-1 py-3 rounded-xl text-sm font-bold transition-all text-gray-500 flex items-center justify-center gap-2">
                <!-- QR code icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path stroke-linecap="round" d="M14 14h2v2h-2zM18 14h3M14 18h2M18 18h3M14 21v-3M21 21v-3M18 17v1"/></svg>
                QRIS
            </button>
        </div>

        <!-- ===== BANK TRANSFER PANEL ===== -->
        <div id="panel-bank" class="pay-panel">
            <p class="text-sm text-gray-500 mb-4 font-medium">Pilih bank tujuan transfer:</p>
            <div class="space-y-3">

                <!-- BCA -->
                <div class="payment-method-card p-4 flex items-center gap-4" onclick="selectBank('bca')">
                    <div class="pm-radio"></div>
                    <div class="bank-logo" style="background:linear-gradient(135deg,#006cb7,#004e8a);">
                        <svg width="28" height="18" viewBox="0 0 56 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <text x="0" y="18" font-family="Arial" font-weight="900" font-size="18" fill="white">BCA</text>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800 text-sm">Bank Central Asia</p>
                        <p class="text-xs text-gray-400">Transfer online / ATM / m-BCA</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 chevron-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>

                <!-- BRI -->
                <div class="payment-method-card p-4 flex items-center gap-4" onclick="selectBank('bri')">
                    <div class="pm-radio"></div>
                    <div class="bank-logo" style="background:linear-gradient(135deg,#003087,#0044cc);">
                        <svg width="28" height="18" viewBox="0 0 56 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <text x="0" y="18" font-family="Arial" font-weight="900" font-size="18" fill="white">BRI</text>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800 text-sm">Bank Rakyat Indonesia</p>
                        <p class="text-xs text-gray-400">Transfer online / ATM / BRImo</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 chevron-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>

                <!-- Mandiri -->
                <div class="payment-method-card p-4 flex items-center gap-4" onclick="selectBank('mandiri')">
                    <div class="pm-radio"></div>
                    <div class="bank-logo" style="background:linear-gradient(135deg,#003087,#f2a900);">
                        <svg width="28" height="18" viewBox="0 0 72 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <text x="0" y="18" font-family="Arial" font-weight="900" font-size="13" fill="white">MDR</text>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800 text-sm">Bank Mandiri</p>
                        <p class="text-xs text-gray-400">Transfer online / ATM / Livin'</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 chevron-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>

                <!-- BNI -->
                <div class="payment-method-card p-4 flex items-center gap-4" onclick="selectBank('bni')">
                    <div class="pm-radio"></div>
                    <div class="bank-logo" style="background:linear-gradient(135deg,#f7941d,#e67e00);">
                        <svg width="28" height="18" viewBox="0 0 56 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <text x="0" y="18" font-family="Arial" font-weight="900" font-size="18" fill="white">BNI</text>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800 text-sm">Bank Negara Indonesia</p>
                        <p class="text-xs text-gray-400">Transfer online / ATM / mobile</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 chevron-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            <!-- Bank Detail Panel -->
            <div id="bank-detail" class="bank-detail-panel mt-6">
                <div class="bg-gradient-to-br from-slate-50 to-white border border-slate-200 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div id="detail-bank-logo" class="bank-logo w-10 h-10" style="background:linear-gradient(135deg,#006cb7,#004e8a);">
                                <svg width="24" height="14" viewBox="0 0 56 24" fill="white"><text x="0" y="18" font-family="Arial" font-weight="900" font-size="18" fill="white">BCA</text></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Transfer ke</p>
                                <p id="detail-bank-name" class="font-bold text-gray-800 text-sm">Bank Central Asia</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">Virtual Account</span>
                    </div>

                    <!-- Account Number -->
                    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-4">
                        <p class="text-xs text-gray-400 mb-1">Nomor Virtual Account</p>
                        <div class="flex items-center justify-between gap-3">
                            <p id="detail-va-number" class="text-2xl font-extrabold text-gray-900 tracking-widest">1234 5678 9012</p>
                            <button class="copy-btn flex items-center gap-1.5 px-3 py-2 border border-slate-200 rounded-lg text-xs font-semibold text-gray-600 transition-all"
                                onclick="copyVA()">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                                Salin
                            </button>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-5">
                        <p class="text-xs text-gray-400 mb-1">Jumlah Transfer (tepat)</p>
                        <div class="flex items-center justify-between gap-3">
                            <p id="detail-amount" class="text-xl font-extrabold text-brand-dark"></p>
                            <button class="copy-btn flex items-center gap-1.5 px-3 py-2 border border-slate-200 rounded-lg text-xs font-semibold text-gray-600 transition-all"
                                onclick="copyAmount()">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                                Salin
                            </button>
                        </div>
                        <p class="text-xs text-amber-600 mt-2 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Transfer tepat sesuai nominal, kode unik untuk verifikasi
                        </p>
                    </div>

                    <!-- Steps -->
                    <div class="space-y-2.5 mb-5">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Cara Transfer</p>
                        <div class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-brand text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                            <p class="text-sm text-gray-600">Login ke mobile banking / internet banking / ATM Anda</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-brand text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                            <p class="text-sm text-gray-600">Pilih menu <span id="detail-menu-name" class="font-semibold">Transfer / Virtual Account</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-brand text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                            <p class="text-sm text-gray-600">Masukkan nomor Virtual Account dan nominal transfer</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-brand text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                            <p class="text-sm text-gray-600">Konfirmasi dan simpan bukti transfer</p>
                        </div>
                    </div>

                    <!-- Upload Proof -->
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Upload Bukti Transfer</p>
                        <div class="upload-zone p-6 text-center cursor-pointer" id="upload-zone" onclick="document.getElementById('proof-file').click()">
                            <input type="file" id="proof-file" class="hidden" accept="image/*" onchange="handleFileUpload(this)">
                            <div id="upload-placeholder">
                                <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm text-gray-500 font-medium">Klik untuk upload foto bukti transfer</p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, maks. 5MB</p>
                            </div>
                            <div id="upload-preview" class="hidden">
                                <svg class="w-8 h-8 mx-auto text-emerald-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p id="upload-filename" class="text-sm text-emerald-700 font-semibold"></p>
                                <p class="text-xs text-gray-400">Klik untuk ganti file</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button id="btn-confirm-bank" onclick="confirmPayment()"
                class="w-full mt-6 py-4 bg-gradient-to-r from-brand to-brand-dark text-white font-bold rounded-xl shadow-lg shadow-brand/30 hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm uppercase tracking-wider flex items-center justify-center gap-2 opacity-50 cursor-not-allowed"
                disabled>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Konfirmasi Pembayaran
            </button>
        </div>

        <!-- ===== QRIS PANEL ===== -->
        <div id="panel-qris" class="pay-panel hidden">
            <div class="flex flex-col items-center">
                <p class="text-sm text-gray-500 mb-6 text-center">Scan kode QR dengan aplikasi apapun yang mendukung QRIS</p>

                <!-- QRIS QR Code (generated SVG placeholder) -->
                <div class="qris-frame mb-6" style="display:inline-block;">
                    <div class="qris-inner">
                        <div class="flex items-center justify-center mb-3">
                            <!-- QRIS logo text badge -->
                            <div class="flex items-center gap-2 px-4 py-1.5 bg-red-600 rounded-lg">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h2v2h-2zM18 14h3M14 18h2M18 18h3M14 21v-3M21 21v-3M18 17v1"/></svg>
                                <span class="text-white font-extrabold text-xs tracking-widest">QRIS</span>
                            </div>
                        </div>

                        <!-- QR Code SVG (visual placeholder grid) -->
                        <div class="qris-corners" style="display:inline-block;">
                            <svg width="200" height="200" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" style="display:block;">
                                <!-- Finder patterns -->
                                <rect x="10" y="10" width="56" height="56" rx="4" fill="#111"/>
                                <rect x="17" y="17" width="42" height="42" rx="2" fill="white"/>
                                <rect x="24" y="24" width="28" height="28" rx="2" fill="#111"/>

                                <rect x="134" y="10" width="56" height="56" rx="4" fill="#111"/>
                                <rect x="141" y="17" width="42" height="42" rx="2" fill="white"/>
                                <rect x="148" y="24" width="28" height="28" rx="2" fill="#111"/>

                                <rect x="10" y="134" width="56" height="56" rx="4" fill="#111"/>
                                <rect x="17" y="141" width="42" height="42" rx="2" fill="white"/>
                                <rect x="24" y="148" width="28" height="28" rx="2" fill="#111"/>

                                <!-- Data modules pattern (decorative) -->
                                <g fill="#111">
                                    <rect x="78" y="10" width="8" height="8"/>
                                    <rect x="94" y="10" width="8" height="8"/>
                                    <rect x="78" y="26" width="8" height="8"/>
                                    <rect x="110" y="18" width="8" height="8"/>
                                    <rect x="78" y="42" width="8" height="8"/>
                                    <rect x="94" y="50" width="8" height="8"/>
                                    <rect x="110" y="34" width="8" height="8"/>

                                    <rect x="10" y="78" width="8" height="8"/>
                                    <rect x="26" y="78" width="8" height="8"/>
                                    <rect x="42" y="94" width="8" height="8"/>
                                    <rect x="10" y="110" width="8" height="8"/>
                                    <rect x="58" y="78" width="8" height="8"/>
                                    <rect x="58" y="94" width="8" height="8"/>
                                    <rect x="26" y="110" width="8" height="8"/>

                                    <rect x="78" y="78" width="8" height="8"/>
                                    <rect x="94" y="78" width="8" height="8"/>
                                    <rect x="110" y="78" width="8" height="8"/>
                                    <rect x="78" y="94" width="8" height="8"/>
                                    <rect x="110" y="94" width="8" height="8"/>
                                    <rect x="78" y="110" width="8" height="8"/>
                                    <rect x="94" y="110" width="8" height="8"/>
                                    <rect x="110" y="110" width="8" height="8"/>

                                    <rect x="126" y="78" width="8" height="8"/>
                                    <rect x="142" y="86" width="8" height="8"/>
                                    <rect x="158" y="78" width="8" height="8"/>
                                    <rect x="174" y="94" width="8" height="8"/>
                                    <rect x="126" y="102" width="8" height="8"/>
                                    <rect x="158" y="110" width="8" height="8"/>
                                    <rect x="142" y="110" width="8" height="8"/>

                                    <rect x="78" y="126" width="8" height="8"/>
                                    <rect x="94" y="142" width="8" height="8"/>
                                    <rect x="110" y="126" width="8" height="8"/>
                                    <rect x="78" y="158" width="8" height="8"/>
                                    <rect x="110" y="158" width="8" height="8"/>
                                    <rect x="78" y="174" width="8" height="8"/>
                                    <rect x="94" y="174" width="8" height="8"/>

                                    <rect x="126" y="134" width="8" height="8"/>
                                    <rect x="142" y="126" width="8" height="8"/>
                                    <rect x="158" y="134" width="8" height="8"/>
                                    <rect x="174" y="126" width="8" height="8"/>
                                    <rect x="126" y="150" width="8" height="8"/>
                                    <rect x="174" y="150" width="8" height="8"/>
                                    <rect x="142" y="158" width="8" height="8"/>
                                    <rect x="158" y="174" width="8" height="8"/>
                                    <rect x="174" y="174" width="8" height="8"/>
                                </g>
                            </svg>
                        </div>

                        <div class="text-center mt-3">
                            <p class="text-xs text-gray-400">Berlaku untuk semua dompet digital</p>
                            <!-- App icons as colored dots -->
                            <div class="flex items-center justify-center gap-2 mt-2">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:#00aef0;">G</span>
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:#5433ff;">D</span>
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:#e45c2b;">S</span>
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:#1db954;">L</span>
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:#f7931e;">O</span>
                                <span class="text-xs text-gray-400">+50 lainnya</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amount for QRIS -->
                <div class="w-full bg-white border border-gray-200 rounded-2xl p-5 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400">Nominal pembayaran</p>
                            <p id="qris-amount" class="text-2xl font-extrabold text-gray-900 mt-1"></p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h2v2h-2zM18 14h3M14 18h2"/></svg>
                        </div>
                    </div>
                </div>

                <!-- QRIS Steps -->
                <div class="w-full space-y-3 mb-6">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Cara Bayar via QRIS</p>
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <div class="w-8 h-8 rounded-lg bg-brand flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-sm text-gray-600">Buka aplikasi dompet digital atau m-banking Anda</p>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <div class="w-8 h-8 rounded-lg bg-brand flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <p class="text-sm text-gray-600">Pilih fitur "Scan QR" / "Bayar via QRIS"</p>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <div class="w-8 h-8 rounded-lg bg-brand flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm text-gray-600">Scan QR di atas dan konfirmasi nominal</p>
                    </div>
                </div>

                <button onclick="confirmPayment()"
                    class="w-full py-4 bg-gradient-to-r from-brand to-brand-dark text-white font-bold rounded-xl shadow-lg shadow-brand/30 hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm uppercase tracking-wider flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Saya Sudah Bayar
                </button>
            </div>
        </div>

        <!-- Security badges -->
        <div class="flex items-center justify-center gap-6 mt-8 pt-6 border-t border-gray-100">
            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                SSL Secured
            </div>
            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Data Terenkripsi
            </div>
            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                OJK Registered
            </div>
        </div>

        <button onclick="goStep('step-confirm')"
            class="mt-4 mx-auto block text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">←
            Kembali</button>
    </div>

    <!-- ===== STEP: Processing (loading) ===== -->
    <div id="step-processing" class="booking-step hidden max-w-lg mx-auto px-6 text-center">
        <div class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
            <div class="w-20 h-20 mx-auto mb-6 relative">
                <svg class="animate-spin w-20 h-20 text-brand" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                    <path class="opacity-80" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-8 h-8 text-brand-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Memverifikasi Pembayaran</h2>
            <p class="text-gray-500 text-sm">Mohon tunggu, sistem sedang memproses transaksi Anda...</p>
            <div class="mt-6 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-brand to-brand-dark rounded-full animate-progress" style="animation: progress-bar 2.5s ease forwards;"></div>
            </div>
        </div>
        <style>
            @keyframes progress-bar {
                0%   { width: 0%; }
                60%  { width: 75%; }
                100% { width: 100%; }
            }
            .animate-progress { width: 0%; }
        </style>
    </div>

    <!-- ===== STEP: Success ===== -->
    <div id="step-success" class="booking-step hidden max-w-lg mx-auto px-6 text-center">
        <div class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
            <div
                class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center mb-8 shadow-xl shadow-brand/30">
                <!-- Check icon -->
                <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Pesanan Berhasil!</h2>
            <p class="text-gray-500 mb-2">Terima kasih telah menggunakan <strong>JasaKami</strong></p>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-full text-sm mb-8">
                <span class="text-gray-400">Order ID:</span>
                <span id="order-id" class="font-bold text-gray-900">JK-2026-001</span>
            </div>

            <!-- Payment method used -->
            <div id="success-payment-method" class="flex items-center justify-center gap-2 px-4 py-2 bg-emerald-50 rounded-xl mb-6 text-sm text-emerald-700 font-medium">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Dibayar via <span id="success-method-name" class="font-bold ml-1">Transfer Bank</span>
            </div>

            <div class="space-y-3">
                <a id="wa-link" href="#" target="_blank"
                    class="block w-full py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-200 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                    <!-- Phone icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Hubungi via WhatsApp
                </a>
                <a href="/"
                    class="block w-full py-4 bg-gray-50 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-100 transition-all">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // Pass workers data to JS
    window.WORKERS_DATA = <?= json_encode($workers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

    // Track selected section from booking cards
    let currentSection = null;
    document.querySelectorAll('[data-section]').forEach(el => {
        el.addEventListener('click', () => {
            currentSection = el.dataset.section;
        });
    });

    // Override showWorkers to filter by section too
    const _origShowWorkers = window.showWorkers;
    window.showWorkers = function (gender) {
        const workers = window.WORKERS_DATA || [];
        let filtered = workers.filter(w => w.gender === gender);
        if (currentSection) {
            filtered = filtered.filter(w => w.section === currentSection);
        }

        const grid = document.getElementById('workers-grid');
        if (!grid) return;

        const badge = document.getElementById('worker-badge');
        const genderColors = {
            female: { bg: 'bg-pink-100', text: 'text-pink-600', label: 'Female Workers' },
            male: { bg: 'bg-blue-100', text: 'text-blue-600', label: 'Male Workers' },
        };
        const gc = genderColors[gender] || genderColors.female;
        if (badge) {
            badge.className = `inline-block px-4 py-1.5 ${gc.bg} ${gc.text} text-sm font-semibold rounded-full mb-4`;
            badge.textContent = gc.label;
        }

        // Department color map
        const deptColors = {
            perhotelan: { bg: 'background:#d1fae5', text: 'color:#065f46', label: 'Perhotelan' },
            kuliner:    { bg: 'background:#ffedd5', text: 'color:#9a3412', label: 'Kuliner' },
            pplg:       { bg: 'background:#ede9fe', text: 'color:#5b21b6', label: 'PPLG' },
        };
        const genderStyle = {
            female: { bg: 'background:#fce7f3', text: 'color:#9d174d', icon: `<svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M12 14v6M9 17h6"/></svg>` },
            male:   { bg: 'background:#dbeafe', text: 'color:#1e3a8a', icon: `<svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 24 24"><circle cx="10" cy="10" r="4"/><path d="M15 5h4v4M15 5l-5 5"/></svg>` },
        };

        grid.innerHTML = filtered.map(w => {
            const dc  = deptColors[w.department]  || { bg: 'background:#f1f5f9', text: 'color:#475569', label: w.department };
            const gs  = genderStyle[w.gender]     || genderStyle.male;
            const skills = (w.skills || []).slice(0, 3);
            const photoSrc = w.photo && (w.photo.startsWith('http') || w.photo.startsWith('/')) ? w.photo : '/' + w.photo;

            return `
            <div onclick="selectWorker(${w.id})" class="glass-card group cursor-pointer rounded-3xl overflow-hidden border border-mint-100 hover:border-brand/30 hover:shadow-2xl hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-3">
                <div class="relative h-52 overflow-hidden bg-gradient-to-br from-mint-50 to-white flex items-center justify-center">
                    <img src="${photoSrc}" alt="${w.name}" class="w-36 h-36 object-cover rounded-full border-4 border-white shadow-xl group-hover:scale-110 transition-transform duration-500"
                        onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(w.name)}&background=random&size=144'">
                    <div class="absolute top-3 right-3 flex items-center gap-1 px-2.5 py-1 bg-yellow-400/90 rounded-full text-xs font-bold text-yellow-900 backdrop-blur-sm">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        ${w.rating}
                    </div>
                    <div class="absolute top-3 left-3 flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold backdrop-blur-sm" style="${gs.bg};${gs.text}">
                        ${gs.icon} ${w.gender === 'female' ? 'Perempuan' : 'Laki-laki'}
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <h3 class="text-base font-bold text-gray-800 group-hover:text-brand-dark transition-colors leading-tight">${w.name}</h3>
                        <span class="shrink-0 text-xs font-semibold px-2 py-0.5 rounded-full" style="${dc.bg};${dc.text}">${dc.label}</span>
                    </div>
                    <p class="text-sm text-brand-dark font-semibold mb-3">${w.role}</p>

                    <!-- Skill Tags -->
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        ${skills.map(s => `<span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs rounded-md font-medium">${s}</span>`).join('')}
                        ${w.skills && w.skills.length > 3 ? `<span class="px-2 py-0.5 bg-slate-50 text-slate-400 text-xs rounded-md">+${w.skills.length - 3} lagi</span>` : ''}
                    </div>

                    <div class="flex items-center gap-2 flex-wrap mb-3">
                        ${w.languages.map(l => '<span class="text-base" title="' + l.name + '">' + l.flag + '</span>').join('')}
                        <span class="text-xs text-gray-400">${w.languages.map(l => l.name).join(', ')}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-center mb-3">
                        <div class="bg-mint-50 rounded-lg py-2">
                            <div class="text-xs text-gray-400">Usia</div>
                            <div class="text-sm font-bold text-gray-800">${w.age} th</div>
                        </div>
                        <div class="bg-mint-50 rounded-lg py-2">
                            <div class="text-xs text-gray-400">Fee/hari</div>
                            <div class="text-sm font-bold text-brand-dark">${w.fee_formatted}</div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-400 mb-4 truncate">
                        <span class="font-medium text-gray-600">Exp:</span> ${w.experience}
                    </div>
                    <button class="w-full py-3 bg-gradient-to-r from-brand to-brand-dark text-white font-bold rounded-xl shadow-md shadow-brand/20 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all text-sm">
                        Pilih Pekerja
                    </button>
                </div>
            </div>
            `;
        }).join('');

        if (filtered.length === 0) {
            grid.innerHTML = `
                <div class="col-span-full text-center py-16 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-lg font-semibold">Belum ada pekerja tersedia</p>
                    <p class="text-sm">Silakan coba filter atau section lain</p>
                </div>
            `;
        }

        goStep('step-workers');
    };

    function goBack() {
        if (bookingHistory.length > 1) {
            bookingHistory.pop();
            const prevStep = bookingHistory[bookingHistory.length - 1];
            document.querySelectorAll('.booking-step').forEach(s => s.classList.add('hidden'));
            const target = document.getElementById(prevStep);
            if (target) target.classList.remove('hidden');
            updateBreadcrumb();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    // ===========================
    // PAYMENT GATEWAY LOGIC
    // ===========================

    const BANK_DATA = {
        bca: {
            name: 'Bank Central Asia',
            shortName: 'BCA',
            va: '1234 5678 9012 3456',
            menuName: 'Virtual Account BCA',
            gradient: 'linear-gradient(135deg,#006cb7,#004e8a)',
            logoSvg: `<svg width="28" height="14" viewBox="0 0 56 24" fill="white"><text x="0" y="18" font-family="Arial" font-weight="900" font-size="18" fill="white">BCA</text></svg>`
        },
        bri: {
            name: 'Bank Rakyat Indonesia',
            shortName: 'BRI',
            va: '0889 9876 5432 1010',
            menuName: 'Virtual Account BRI',
            gradient: 'linear-gradient(135deg,#003087,#0044cc)',
            logoSvg: `<svg width="28" height="14" viewBox="0 0 56 24" fill="white"><text x="0" y="18" font-family="Arial" font-weight="900" font-size="18" fill="white">BRI</text></svg>`
        },
        mandiri: {
            name: 'Bank Mandiri',
            shortName: 'Mandiri',
            va: '7007 0055 4321 8888',
            menuName: "Transfer Virtual Account Mandiri",
            gradient: 'linear-gradient(135deg,#003087,#f2a900)',
            logoSvg: `<svg width="28" height="14" viewBox="0 0 72 24" fill="white"><text x="0" y="18" font-family="Arial" font-weight="900" font-size="13" fill="white">MDR</text></svg>`
        },
        bni: {
            name: 'Bank Negara Indonesia',
            shortName: 'BNI',
            va: '8882 3456 7890 0011',
            menuName: 'Virtual Account BNI',
            gradient: 'linear-gradient(135deg,#f7941d,#e67e00)',
            logoSvg: `<svg width="28" height="14" viewBox="0 0 56 24" fill="white"><text x="0" y="18" font-family="Arial" font-weight="900" font-size="18" fill="white">BNI</text></svg>`
        }
    };

    let selectedBank = null;
    let paymentTab = 'bank';
    let paymentTotal = 0;
    let paymentTimer = null;
    let timerSeconds = 14 * 60 + 59; // 14:59

    function switchPayTab(tab) {
        paymentTab = tab;
        document.querySelectorAll('.pay-panel').forEach(p => p.classList.add('hidden'));
        document.getElementById('panel-' + tab).classList.remove('hidden');

        document.querySelectorAll('.pay-tab').forEach(t => {
            t.classList.remove('bg-white', 'shadow', 'text-gray-800');
            t.classList.add('text-gray-500');
        });
        const activeTab = document.getElementById('tab-' + tab);
        activeTab.classList.add('bg-white', 'shadow', 'text-gray-800');
        activeTab.classList.remove('text-gray-500');
    }

    function selectBank(bankKey) {
        selectedBank = bankKey;
        const bank = BANK_DATA[bankKey];

        // Update card states
        document.querySelectorAll('.payment-method-card').forEach(card => card.classList.remove('selected'));
        document.querySelectorAll('.payment-method-card').forEach(card => {
            if (card.getAttribute('onclick') === `selectBank('${bankKey}')`) {
                card.classList.add('selected');
            }
        });

        // Populate detail panel
        document.getElementById('detail-bank-name').textContent = bank.name;
        document.getElementById('detail-bank-logo').style.background = bank.gradient;
        document.getElementById('detail-bank-logo').innerHTML = bank.logoSvg;
        document.getElementById('detail-va-number').textContent = bank.va;
        document.getElementById('detail-amount').textContent = formatRupiah(paymentTotal);
        document.getElementById('detail-menu-name').textContent = bank.menuName;

        // Show detail panel
        const detailPanel = document.getElementById('bank-detail');
        detailPanel.classList.add('active');
        detailPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        // Enable confirm button
        const btn = document.getElementById('btn-confirm-bank');
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    function copyVA() {
        const bank = BANK_DATA[selectedBank];
        if (!bank) return;
        navigator.clipboard.writeText(bank.va.replace(/\s/g, '')).then(() => {
            showCopyFeedback(event.currentTarget);
        });
    }

    function copyAmount() {
        navigator.clipboard.writeText(String(paymentTotal)).then(() => {
            showCopyFeedback(event.currentTarget);
        });
    }

    function showCopyFeedback(btn) {
        const orig = btn.innerHTML;
        btn.classList.add('copied');
        btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Disalin!`;
        setTimeout(() => {
            btn.classList.remove('copied');
            btn.innerHTML = orig;
        }, 2000);
    }

    function handleFileUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('upload-preview').classList.remove('hidden');
            document.getElementById('upload-filename').textContent = file.name;
        }
    }

    function formatRupiah(amount) {
        return 'Rp' + amount.toLocaleString('id-ID');
    }

    function initPaymentStep() {
        // Sync data from confirm step
        const workerName = document.getElementById('confirm-worker-name')?.textContent || '';
        const totalText = document.getElementById('confirm-total')?.textContent || '';

        document.getElementById('pay-worker-name').textContent = workerName;
        document.getElementById('pay-total-amount').textContent = totalText;
        document.getElementById('qris-amount').textContent = totalText;

        // Parse total
        const raw = totalText.replace(/[^0-9]/g, '');
        paymentTotal = parseInt(raw) || 0;

        // Reset tab to bank
        switchPayTab('bank');

        // Reset bank selection
        selectedBank = null;
        document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('selected'));
        document.getElementById('bank-detail').classList.remove('active');
        const btn = document.getElementById('btn-confirm-bank');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');

        // Reset upload
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('upload-preview').classList.add('hidden');

        // Start countdown timer
        startPaymentTimer();
    }

    function startPaymentTimer() {
        if (paymentTimer) clearInterval(paymentTimer);
        timerSeconds = 14 * 60 + 59;
        updateTimerDisplay();

        paymentTimer = setInterval(() => {
            timerSeconds--;
            if (timerSeconds <= 0) {
                clearInterval(paymentTimer);
                timerSeconds = 0;
            }
            updateTimerDisplay();
        }, 1000);
    }

    function updateTimerDisplay() {
        const m = Math.floor(timerSeconds / 60);
        const s = timerSeconds % 60;
        const el = document.getElementById('payment-timer');
        if (el) el.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');

        // Update ring
        const ring = document.getElementById('timer-ring');
        if (ring) {
            const total = 14 * 60 + 59;
            const ratio = timerSeconds / total;
            const dashOffset = 113 * (1 - ratio);
            ring.style.strokeDashoffset = dashOffset;
        }
    }

    function confirmPayment() {
        if (paymentTimer) clearInterval(paymentTimer);

        // Show processing
        document.querySelectorAll('.booking-step').forEach(s => s.classList.add('hidden'));
        const proc = document.getElementById('step-processing');
        if (proc) proc.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });

        setTimeout(() => {
            // Generate order ID
            const orderId = 'JK-' + new Date().getFullYear() + '-' + String(Math.floor(Math.random() * 9000) + 1000);
            const el = document.getElementById('order-id');
            if (el) el.textContent = orderId;

            // Set payment method label
            const methodName = paymentTab === 'qris' ? 'QRIS' :
                (selectedBank ? (BANK_DATA[selectedBank]?.shortName || 'Transfer Bank') : 'Transfer Bank');
            const mn = document.getElementById('success-method-name');
            if (mn) mn.textContent = methodName;

            // Show success
            document.querySelectorAll('.booking-step').forEach(s => s.classList.add('hidden'));
            const succ = document.getElementById('step-success');
            if (succ) succ.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 2500);
    }

    // initPaymentStep is global — called by app.js goStep hook when entering step-payment
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>