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
                🏨 Perhotelan</div>
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
                🍳 Kuliner</div>
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
                💻 PPLG</div>
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
                    <p class="text-gray-500 text-sm mb-4">Fullstack & mobile developer.</p>
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
                    <p class="text-gray-500 text-sm mb-4">UI/UX & graphic design.</p>
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
                    <p class="text-gray-500 text-sm mb-4">Game development & design.</p>
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
                📅 Opsional</div>
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
                    <h4 class="font-bold text-gray-800 mb-6">Pilih Tanggal & Waktu</h4>
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
                        class="w-full py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-purple-200 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        📅 Jadwalkan Interview
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
                🧾 Konfirmasi</div>
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
            <button onclick="goStep('step-success')"
                class="w-full py-4 bg-gradient-to-r from-brand to-brand-dark text-white font-bold rounded-xl shadow-lg shadow-brand/30 hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm uppercase tracking-wider">
                💳 Bayar Sekarang
            </button>
            <button onclick="goStep('step-interview')"
                class="w-full mt-3 py-3 text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors">←
                Kembali</button>
        </div>
    </div>

    <!-- ===== STEP: Success ===== -->
    <div id="step-success" class="booking-step hidden max-w-lg mx-auto px-6 text-center">
        <div class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
            <div
                class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center text-white text-5xl mb-8 shadow-xl shadow-brand/30">
                ✓
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Pesanan Berhasil! 🎉</h2>
            <p class="text-gray-500 mb-2">Terima kasih telah menggunakan <strong>JasaKami</strong></p>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-full text-sm mb-8">
                <span class="text-gray-400">Order ID:</span>
                <span id="order-id" class="font-bold text-gray-900">JK-2026-001</span>
            </div>
            <div class="space-y-3">
                <a id="wa-link" href="#" target="_blank"
                    class="block w-full py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-200 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    📱 Hubungi via WhatsApp
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
            perhotelan: { bg: 'background:#d1fae5', text: 'color:#065f46', label: '🏨 Perhotelan' },
            kuliner:    { bg: 'background:#ffedd5', text: 'color:#9a3412', label: '🍳 Kuliner' },
            pplg:       { bg: 'background:#ede9fe', text: 'color:#5b21b6', label: '💻 PPLG' },
        };
        const genderStyle = {
            female: { bg: 'background:#fce7f3', text: 'color:#9d174d', icon: '♀' },
            male:   { bg: 'background:#dbeafe', text: 'color:#1e3a8a', icon: '♂' },
        };

        grid.innerHTML = filtered.map(w => {
            const dc  = deptColors[w.department]  || { bg: 'background:#f1f5f9', text: 'color:#475569', label: w.department };
            const gc  = genderStyle[w.gender]     || genderStyle.male;
            const skills = (w.skills || []).slice(0, 3);
            const photoSrc = w.photo && w.photo.startsWith('http') ? w.photo : '/' + w.photo;

            return `
            <div onclick="selectWorker(${w.id})" class="glass-card group cursor-pointer rounded-3xl overflow-hidden border border-mint-100 hover:border-brand/30 hover:shadow-2xl hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-3">
                <div class="relative h-52 overflow-hidden bg-gradient-to-br from-mint-50 to-white flex items-center justify-center">
                    <img src="${photoSrc}" alt="${w.name}" class="w-36 h-36 object-cover rounded-full border-4 border-white shadow-xl group-hover:scale-110 transition-transform duration-500"
                        onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(w.name)}&background=random&size=144'">
                    <div class="absolute top-3 right-3 flex items-center gap-1 px-2.5 py-1 bg-yellow-400/90 rounded-full text-xs font-bold text-yellow-900 backdrop-blur-sm">
                        ⭐ ${w.rating}
                    </div>
                    <div class="absolute top-3 left-3 flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold backdrop-blur-sm" style="${gc.bg};${gc.text}">
                        ${gc.icon} ${w.gender === 'female' ? 'Perempuan' : 'Laki-laki'}
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
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>