<?php
// Home page content — rendered inside layout.php
ob_start();
$services = $services ?? [];
$testimonials = $testimonials ?? [];
$departments = $services['departments'] ?? [];
$stats = $services['stats'] ?? [];
$counters = $services['counters'] ?? [];
?>

<!-- ========== HERO ========== -->
<section id="hero"
    class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-brand via-mint-400 to-brand-dark overflow-hidden hero-pattern">
    <!-- Decorative blobs -->
    <div class="absolute -top-20 -left-20 w-80 h-80 bg-mint-300/30 blob-shape blur-3xl animate-pulse"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-brand-dark/20 blob-shape blur-3xl animate-pulse"
        style="animation-delay: 1s;"></div>
    <div class="absolute top-1/3 right-10 w-48 h-48 bg-white/10 rounded-3xl rotate-45 hidden lg:block animate-float">
    </div>
    <div class="absolute bottom-20 left-20 w-28 h-28 bg-white/10 rounded-2xl -rotate-12 hidden lg:block animate-float"
        style="animation-delay: 2s;"></div>
    <div class="absolute top-20 right-1/4 w-16 h-16 bg-white/15 rounded-xl rotate-12 hidden lg:block animate-float"
        style="animation-delay: 1.5s;"></div>

    <div class="relative text-center px-6 max-w-4xl mx-auto">
        <!-- Logo -->
        <div class="mx-auto mb-8 w-36 h-36 rounded-3xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-2xl shadow-black/10 hover:scale-110 transition-transform duration-500"
            style="animation: scaleIn 0.5s ease-out both;">
            <img src="/assets/images/logo.png" alt="Logo JasaKami" class="w-28 h-28 object-contain drop-shadow-2xl">
        </div>

        <!-- Headline -->
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight"
            style="animation: fadeUp 0.8s ease-out 0.2s both;">
            Karya <span class="text-mint-100">Digital</span>
        </h1>

        <!-- Subtext -->
        <p class="text-white/90 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto font-light mb-10"
            style="animation: fadeUp 0.8s ease-out 0.5s both;">
            Dari layanan <strong class="font-semibold">perhotelan</strong>, <strong
                class="font-semibold">kuliner</strong>, hingga <strong class="font-semibold">PPLG (Pengembangan
                Perangkat Lunak)</strong>,
            kami hadir sebagai mitra yang dekat dengan kebutuhan lingkungan sekitar.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap gap-4 justify-center" style="animation: fadeUp 0.8s ease-out 0.8s both;">
            <a href="/booking"
                class="group px-8 py-4 bg-white text-brand-dark font-bold rounded-full shadow-lg shadow-black/10 hover:shadow-xl hover:-translate-y-1 transition-all text-sm uppercase tracking-wider flex items-center gap-2">
                Pesan Sekarang
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
            <a href="#layanan"
                class="px-8 py-4 border-2 border-white/60 text-white font-bold rounded-full hover:bg-white/10 hover:-translate-y-1 transition-all text-sm uppercase tracking-wider">
                Jelajahi Layanan
            </a>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce">
        <span class="text-white/60 text-xs font-medium uppercase tracking-widest">Scroll</span>
        <svg class="w-5 h-5 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</section>

<!-- ========== STATS BAR ========== -->
<section class="relative -mt-12 z-10 max-w-5xl mx-auto px-6">
    <div
        class="glass-card rounded-2xl shadow-xl shadow-brand/5 border border-white/50 p-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <?php foreach (array_slice($stats, 0, 4) as $stat): ?>
            <div class="reveal-item">
                <p class="text-3xl md:text-4xl font-extrabold text-brand-dark"><?= htmlspecialchars($stat['value']) ?></p>
                <p class="text-gray-500 text-sm mt-1 font-medium"><?= htmlspecialchars($stat['label']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ========== TENTANG KAMI ========== -->
<section id="tentang" class="py-28 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-mint-50/80 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
            <div class="reveal-item">
                <span
                    class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand/10 text-brand-dark text-sm font-semibold rounded-full mb-6">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tentang Kami
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                    Kami Adalah<br><span class="text-gradient">Karya Digital</span>
                </h2>
                <p class="text-gray-500 text-lg leading-relaxed mb-8">
                    Perusahaan yang bergerak di bidang layanan profesional mulai dari perhotelan, kuliner, hingga
                    pengembangan perangkat lunak. Kami berkomitmen menghadirkan solusi terbaik.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="p-5 rounded-2xl bg-gradient-to-br from-emerald-50 to-mint-50 border border-mint-100 hover:shadow-lg hover:shadow-brand/5 transition-all group">
                        <div class="text-3xl mb-2">🛡️</div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-brand-dark transition-colors">
                            Terpercaya</h4>
                        <p class="text-gray-400 text-xs leading-relaxed">Standar kualitas tinggi & teruji</p>
                    </div>
                    <div
                        class="p-5 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 hover:shadow-lg hover:shadow-blue-100 transition-all group">
                        <div class="text-3xl mb-2">⚡</div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-blue-600 transition-colors">Cepat &
                            Efisien</h4>
                        <p class="text-gray-400 text-xs leading-relaxed">Proses pemesanan mudah & responsif</p>
                    </div>
                    <div
                        class="p-5 rounded-2xl bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-100 hover:shadow-lg hover:shadow-purple-100 transition-all group">
                        <div class="text-3xl mb-2">👥</div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-purple-600 transition-colors">
                            Berpengalaman</h4>
                        <p class="text-gray-400 text-xs leading-relaxed">Pekerja terlatih dari industri ternama</p>
                    </div>
                    <div
                        class="p-5 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100 hover:shadow-lg hover:shadow-amber-100 transition-all group">
                        <div class="text-3xl mb-2">🌟</div>
                        <h4 class="font-bold text-gray-800 mb-1 group-hover:text-amber-600 transition-colors">Premium
                        </h4>
                        <p class="text-gray-400 text-xs leading-relaxed">Layanan berkelas internasional</p>
                    </div>
                </div>
            </div>
            <div class="reveal-item relative">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4 pt-8">
                        <div class="rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-shadow">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80" alt="Hotel"
                                class="w-full h-48 object-cover hover:scale-110 transition-transform duration-700">
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-shadow">
                            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80" alt="Kuliner"
                                class="w-full h-56 object-cover hover:scale-110 transition-transform duration-700">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-shadow">
                            <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=600&q=80" alt="PPLG"
                                class="w-full h-56 object-cover hover:scale-110 transition-transform duration-700">
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-shadow">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80" alt="Housekeeping"
                                class="w-full h-48 object-cover hover:scale-110 transition-transform duration-700">
                        </div>
                    </div>
                </div>
                <!-- Floating badge -->
                <div
                    class="absolute -bottom-6 left-1/2 -translate-x-1/2 glass-card px-6 py-4 rounded-2xl shadow-xl border border-mint-100 flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center">
                        <span class="text-white text-xl">🏆</span>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-800">20+</p>
                        <p class="text-xs text-gray-400">Pekerja Profesional</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== LAYANAN ========== -->
<section id="layanan" class="py-28 bg-gray-50 relative overflow-hidden">
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-mint-200/30 blob-shape blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="text-center mb-20 reveal-item">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand/10 text-brand-dark text-sm font-semibold rounded-full mb-4 mx-auto">
                Layanan Kami
            </span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Tiga Bidang <span
                    class="text-gradient">Utama</span></h2>
            <p class="text-gray-500 max-w-lg mx-auto">Tenaga profesional berpengalaman di setiap bidang.</p>
        </div>

        <!-- Department cards — each with unique gradient and layout -->
        <div class="space-y-16">
            <!-- Perhotelan: horizontal layout, left image -->
            <div
                class="reveal-item group relative rounded-[2rem] overflow-hidden bg-white shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-emerald-200/30 transition-all duration-500 hover:-translate-y-1">
                <div class="grid md:grid-cols-5">
                    <div class="md:col-span-2 relative h-64 md:h-auto overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80" alt="Perhotelan"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-emerald-600/80 to-teal-600/60 mix-blend-multiply group-hover:opacity-70 transition-opacity">
                        </div>
                        <div class="absolute inset-0 flex flex-col justify-center items-center text-center p-8">
                            <span class="text-6xl mb-4">🏨</span>
                            <h3 class="text-3xl font-extrabold text-white">Perhotelan</h3>
                            <span
                                class="mt-2 px-3 py-1 bg-white/20 rounded-full text-white text-xs font-semibold backdrop-blur-sm">11
                                Workers Tersedia</span>
                        </div>
                    </div>
                    <div class="md:col-span-3 p-10 flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">Populer</span>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">✓
                                Available</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-6">Bidang yang berfokus pada pengelolaan jasa
                            penginapan dan akomodasi. Layanan housekeeping, front office, dan guest relation dari tenaga
                            profesional berpengalaman di hotel bintang 5.</p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">🏠
                                Housekeeping</span>
                            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">🛎️ Front
                                Office</span>
                            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">👔
                                Laundry</span>
                            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">🧹 Public
                                Area</span>
                        </div>
                        <a href="/booking"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5 transition-all text-sm w-fit">
                            Pesan Sekarang
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kuliner: horizontal layout, right image  -->
            <div
                class="reveal-item group relative rounded-[2rem] overflow-hidden bg-white shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-orange-200/30 transition-all duration-500 hover:-translate-y-1">
                <div class="grid md:grid-cols-5">
                    <div class="md:col-span-3 p-10 flex flex-col justify-center order-2 md:order-1">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">Baru
                                🔥</span>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">✓
                                Available</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-6">Bidang kuliner yang membahas seni pengolahan dan
                            penyajian makanan dan minuman. Chef profesional, pastry specialist, barista, dan mixologist
                            dengan pengalaman di restoran ternama Bali.</p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">👨‍🍳
                                Chef</span>
                            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">🎂
                                Pastry</span>
                            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">☕
                                Barista</span>
                            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">🍹
                                Mixologist</span>
                        </div>
                        <a href="/booking"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-orange-200 hover:-translate-y-0.5 transition-all text-sm w-fit">
                            Pesan Sekarang
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                    <div class="md:col-span-2 relative h-64 md:h-auto overflow-hidden order-1 md:order-2">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80" alt="Kuliner"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-l from-orange-600/80 to-red-500/60 mix-blend-multiply group-hover:opacity-70 transition-opacity">
                        </div>
                        <div class="absolute inset-0 flex flex-col justify-center items-center text-center p-8">
                            <span class="text-6xl mb-4">🍳</span>
                            <h3 class="text-3xl font-extrabold text-white">Kuliner</h3>
                            <span
                                class="mt-2 px-3 py-1 bg-white/20 rounded-full text-white text-xs font-semibold backdrop-blur-sm">5
                                Workers Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PPLG: full-width stacked layout -->
            <div
                class="reveal-item group relative rounded-[2rem] overflow-hidden bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-700 shadow-xl shadow-purple-200/50 hover:shadow-2xl hover:shadow-purple-300/40 transition-all duration-500 hover:-translate-y-1">
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(circle, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 30px 30px;">
                </div>
                <div class="relative grid md:grid-cols-2 gap-8 p-10 md:p-14">
                    <div class="flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="px-3 py-1 bg-white/20 text-white text-xs font-bold rounded-full backdrop-blur-sm">Tech
                                💻</span>
                            <span
                                class="px-3 py-1 bg-white/20 text-white/90 text-xs font-bold rounded-full backdrop-blur-sm">✓
                                Available</span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-white mb-2">PPLG</h3>
                        <p class="text-purple-200 text-sm font-medium mb-4">Pengembangan Perangkat Lunak & Gim</p>
                        <p class="text-purple-100/80 leading-relaxed mb-6">Bidang teknologi dengan developer, designer,
                            dan game developer profesional. Mulai dari fullstack web, mobile app, UI/UX, hingga game
                            development.</p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span
                                class="px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-xs text-white/90 font-medium border border-white/10">🖥️
                                Fullstack</span>
                            <span
                                class="px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-xs text-white/90 font-medium border border-white/10">📱
                                Mobile</span>
                            <span
                                class="px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-xs text-white/90 font-medium border border-white/10">🎨
                                UI/UX</span>
                            <span
                                class="px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-xs text-white/90 font-medium border border-white/10">🎮
                                Game Dev</span>
                        </div>
                        <a href="/booking"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-white text-purple-700 font-bold rounded-xl hover:shadow-lg hover:shadow-white/20 hover:-translate-y-0.5 transition-all text-sm w-fit">
                            Pesan Sekarang
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                    <div class="relative">
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 transition-colors">
                                <div class="text-4xl mb-3">🖥️</div>
                                <h4 class="text-white font-bold mb-1">Development</h4>
                                <p class="text-purple-200/70 text-xs">Web & Mobile</p>
                            </div>
                            <div
                                class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 transition-colors">
                                <div class="text-4xl mb-3">🎨</div>
                                <h4 class="text-white font-bold mb-1">Design</h4>
                                <p class="text-purple-200/70 text-xs">UI/UX & Graphic</p>
                            </div>
                            <div
                                class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 transition-colors col-span-2">
                                <div class="text-4xl mb-3">🎮</div>
                                <h4 class="text-white font-bold mb-1">Game Development</h4>
                                <p class="text-purple-200/70 text-xs">Unity, Unreal & Custom Engine</p>
                            </div>
                        </div>
                        <div class="absolute -top-4 -right-4 w-16 h-16 border-2 border-white/20 rounded-2xl rotate-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== TIM KAMI (GALLERY) ========== -->
<section id="tim" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16 reveal-item">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand/10 text-brand-dark text-sm font-semibold rounded-full mb-4 mx-auto">Tim
                Kami</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Tenaga <span
                    class="text-gradient">Profesional</span></h2>
            <p class="text-gray-500 max-w-lg mx-auto">Beberapa bidang keahlian tim kami yang siap melayani kebutuhan
                Anda.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="reveal-item group relative rounded-2xl overflow-hidden aspect-square cursor-pointer">
                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80" alt="Housekeeping"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                    <span class="text-white font-bold text-sm">Housekeeping</span>
                    <span class="text-white/70 text-xs">Perhotelan</span>
                </div>
            </div>
            <div class="reveal-item group relative rounded-2xl overflow-hidden aspect-square cursor-pointer">
                <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=600&q=80" alt="Front Office"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                    <span class="text-white font-bold text-sm">Front Office</span>
                    <span class="text-white/70 text-xs">Perhotelan</span>
                </div>
            </div>
            <div class="reveal-item group relative rounded-2xl overflow-hidden aspect-square cursor-pointer">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&q=80" alt="Kuliner"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                    <span class="text-white font-bold text-sm">Kuliner</span>
                    <span class="text-white/70 text-xs">Restoran & Cafe</span>
                </div>
            </div>
            <div class="reveal-item group relative rounded-2xl overflow-hidden aspect-square cursor-pointer">
                <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=600&q=80" alt="PPLG"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                    <span class="text-white font-bold text-sm">PPLG</span>
                    <span class="text-white/70 text-xs">Tech & Development</span>
                </div>
            </div>
        </div>

        <!-- Marquee-style team badges -->
        <div class="mt-12 flex flex-wrap gap-3 justify-center reveal-item">
            <?php foreach (array_slice($workers, 0, 8) as $w):
                $photoSrc = (str_starts_with($w['photo'], 'http')) ? $w['photo'] : '/' . $w['photo'];
            ?>
                <div class="flex items-center gap-3 pl-1 pr-4 py-1 bg-gray-50 rounded-full border border-gray-100 hover:border-brand/30 hover:bg-mint-50/50 transition-all">
                    <img src="<?= htmlspecialchars($photoSrc) ?>" alt=""
                        class="w-8 h-8 rounded-full object-cover"
                        onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($w['name']) ?>&size=40&background=random'">
                    <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars(explode(' ', $w['name'])[0]) ?></span>
                    <span class="text-xs text-gray-400"><?= htmlspecialchars($w['role']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== WHY CHOOSE US ========== -->
<section class="py-24 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
    </div>
    <div
        class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="reveal-item">
                <span
                    class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand/20 text-brand text-sm font-semibold rounded-full mb-6">Mengapa
                    Kami?</span>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Solusi Terpercaya untuk <span
                        class="text-brand">Bisnis</span> Anda</h2>
                <p class="text-gray-400 text-lg leading-relaxed mb-8">
                    Setiap tenaga kerja JasaKami telah melalui proses seleksi dan pelatihan ketat.
                </p>
                <ul class="space-y-4">
                    <li
                        class="flex items-start gap-4 p-4 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors">
                        <span
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex-shrink-0 flex items-center justify-center text-white">✓</span>
                        <div>
                            <h4 class="text-white font-semibold">Profesional & Bersertifikat</h4>
                            <p class="text-gray-400 text-sm">Background check dan training intensif</p>
                        </div>
                    </li>
                    <li
                        class="flex items-start gap-4 p-4 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors">
                        <span
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex-shrink-0 flex items-center justify-center text-white">⚡</span>
                        <div>
                            <h4 class="text-white font-semibold">Respons Cepat</h4>
                            <p class="text-gray-400 text-sm">Layanan tersedia dalam 24 jam</p>
                        </div>
                    </li>
                    <li
                        class="flex items-start gap-4 p-4 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors">
                        <span
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex-shrink-0 flex items-center justify-center text-white">💯</span>
                        <div>
                            <h4 class="text-white font-semibold">Garansi Kepuasan</h4>
                            <p class="text-gray-400 text-sm">100% uang kembali jika tidak puas</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="grid grid-cols-2 gap-4 reveal-item">
                <?php foreach ($counters as $i => $counter):
                    $gradients = [
                        'bg-gradient-to-br from-brand/20 to-brand-dark/20 border-brand/20',
                        'bg-gradient-to-br from-purple-500/20 to-indigo-500/20 border-purple-500/20',
                        'bg-gradient-to-br from-orange-500/20 to-red-500/20 border-orange-500/20',
                        'bg-gradient-to-br from-yellow-500/20 to-amber-500/20 border-yellow-500/20',
                    ];
                    ?>
                    <div
                        class="<?= $gradients[$i % 4] ?> backdrop-blur-sm p-8 rounded-3xl border hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl font-bold <?= htmlspecialchars($counter['color']) ?> mb-2 counter"
                            data-target="<?= htmlspecialchars($counter['value']) ?>">0</div>
                        <div class="text-gray-400 text-sm"><?= htmlspecialchars($counter['label']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ========== TESTIMONIALS ========== -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand via-purple-500 to-orange-500"></div>
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16 reveal-item">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand/10 text-brand-dark text-sm font-semibold rounded-full mb-4 mx-auto">Testimoni</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Kata Mereka Tentang <span
                    class="text-gradient">JasaKami</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <?php
            $cardStyles = [
                'border-t-4 border-t-brand bg-white',
                'border-t-4 border-t-purple-500 bg-white',
                'border-t-4 border-t-orange-500 bg-white',
            ];
            foreach ($testimonials as $i => $t):
                ?>
                <div
                    class="<?= $cardStyles[$i % 3] ?> p-8 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 reveal-item">
                    <div class="flex items-center gap-1 mb-4">
                        <?php for ($s = 0; $s < 5; $s++): ?>
                            <svg class="w-5 h-5 fill-current <?= $s >= $t['rating'] ? 'text-gray-200' : 'text-yellow-400' ?>"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <p class="text-gray-600 italic mb-6 leading-relaxed">"<?= htmlspecialchars($t['text']) ?>"</p>
                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center text-xl text-white">
                            <?= $t['avatar'] ?>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900"><?= htmlspecialchars($t['name']) ?></h4>
                            <p class="text-xs text-gray-500"><?= htmlspecialchars($t['title']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== CTA SECTION ========== -->
<section class="py-24 bg-gradient-to-br from-brand via-mint-400 to-brand-dark relative overflow-hidden">
    <div class="absolute -top-16 -left-16 w-64 h-64 bg-white/10 blob-shape blur-3xl"></div>
    <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-white/10 blob-shape blur-3xl"></div>
    <div class="max-w-3xl mx-auto px-6 text-center relative reveal-item">
        <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6">Siap Memesan<br>Layanan Kami?</h2>
        <p class="text-white/80 text-lg mb-10 max-w-xl mx-auto">Temukan tenaga profesional terbaik untuk kebutuhan
            perhotelan, kuliner, dan pengembangan perangkat lunak Anda.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/booking"
                class="group px-10 py-4 bg-white text-brand-dark font-bold rounded-full shadow-xl shadow-black/10 hover:shadow-2xl hover:-translate-y-1 transition-all text-sm uppercase tracking-wider flex items-center gap-2">
                Pesan Sekarang
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
            <a href="/login"
                class="px-10 py-4 border-2 border-white/60 text-white font-bold rounded-full hover:bg-white/10 hover:-translate-y-1 transition-all text-sm uppercase tracking-wider">
                Login Dulu
            </a>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>