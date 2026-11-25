<?php
    $profile = $profile ?? \App\Models\CompanyProfile::query()->first();
    $footerServices = $footerServices ?? \App\Models\Service::query()->ordered()->take(5)->get();

    $companyName = $profile?->company_name ?: 'CV. Merah Putih';
    $companyPhone = $profile?->phone ?: '0812-8899-2323';
    $companyWaDigits = preg_replace('/\D+/', '', (string) ($profile?->whatsapp ?: $companyPhone)) ?: '6281288992323';
    if (str_starts_with($companyWaDigits, '0')) {
        $companyWaDigits = '62' . substr($companyWaDigits, 1);
    } elseif (! str_starts_with($companyWaDigits, '62')) {
        $companyWaDigits = '62' . $companyWaDigits;
    }
    $waNavUrl = 'https://wa.me/' . $companyWaDigits . '?text=' . rawurlencode("Halo {$companyName}, saya melihat website Anda dan ingin menanyakan informasi ketersediaan sewa mobil.");
    $logoUrl = trim((string) ($profile?->logo_url ?? ''));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', $companyName . ' — Rental Mobil Depok Terpercaya'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', $profile?->tagline ?? 'Solusi Transportasi & Rental Mobil Terpercaya di Depok'); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', ui-monospace, SFMono-Regular, monospace;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-white text-slate-900 font-sans antialiased">

    
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-2 sm:gap-4 md:gap-8">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 sm:gap-2.5 whitespace-nowrap shrink-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-600 rounded-md">
                <?php if($logoUrl !== ''): ?>
                    <img src="<?php echo e(asset(ltrim($logoUrl, '/'))); ?>" alt="<?php echo e($companyName); ?>" class="h-8 w-8 sm:h-9 sm:w-9 rounded-lg object-contain bg-slate-50 border border-slate-200 p-0.5">
                <?php else: ?>
                    <span class="h-8 w-8 sm:h-9 sm:w-9 rounded-lg bg-red-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                            <circle cx="7" cy="17" r="2"/>
                            <path d="M9 17h6"/>
                            <circle cx="17" cy="17" r="2"/>
                        </svg>
                    </span>
                <?php endif; ?>
                <span class="text-sm sm:text-lg font-extrabold tracking-tight text-slate-900">
                    <?php if(str_contains(strtoupper($companyName), 'MERAH PUTIH')): ?>
                        CV. <span class="text-red-600">MERAH PUTIH</span>
                    <?php else: ?>
                        <?php echo e($companyName); ?>

                    <?php endif; ?>
                </span>
            </a>

            <nav aria-label="Navigasi Utama" class="hidden md:flex items-center gap-7">
                <a href="<?php echo e(route('home')); ?>" class="text-sm font-medium whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors <?php echo e(request()->routeIs('home') ? 'text-red-600 border-red-600 font-semibold' : 'text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                    Beranda
                </a>
                <a href="<?php echo e(route('vehicles.index')); ?>" class="text-sm font-medium whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors <?php echo e(request()->routeIs('vehicles.*') ? 'text-red-600 border-red-600 font-semibold' : 'text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                    Daftar Mobil
                </a>
                <a href="<?php echo e(route('services.index')); ?>" class="text-sm font-medium whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors <?php echo e(request()->routeIs('services.*') ? 'text-red-600 border-red-600 font-semibold' : 'text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                    Layanan
                </a>
                <a href="<?php echo e(route('blog.index')); ?>" class="text-sm font-medium whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors <?php echo e(request()->routeIs('blog.*') ? 'text-red-600 border-red-600 font-semibold' : 'text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                    Blog &amp; Promo
                </a>
                <a href="<?php echo e(route('about')); ?>" class="text-sm font-medium whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors <?php echo e(request()->routeIs('about') ? 'text-red-600 border-red-600 font-semibold' : 'text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                    Tentang Kami
                </a>
            </nav>

            <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
                <a href="<?php echo e($waNavUrl); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors whitespace-nowrap shrink-0">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>

                <button type="button" id="mobile-menu-toggle" aria-expanded="false" aria-controls="mobile-nav-drawer" aria-label="Buka menu navigasi" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg text-slate-700 hover:bg-slate-100 transition-colors">
                    <svg id="mobile-icon-open" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
                    </svg>
                    <svg id="mobile-icon-close" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <nav id="mobile-nav-drawer" aria-label="Navigasi Mobile" class="hidden md:hidden border-t border-slate-200 bg-white px-4 py-3 space-y-1">
            <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('home') ? 'bg-red-50 text-red-700 font-semibold' : 'text-slate-700 hover:bg-slate-50'); ?>">Beranda</a>
            <a href="<?php echo e(route('vehicles.index')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('vehicles.*') ? 'bg-red-50 text-red-700 font-semibold' : 'text-slate-700 hover:bg-slate-50'); ?>">Daftar Mobil</a>
            <a href="<?php echo e(route('services.index')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('services.*') ? 'bg-red-50 text-red-700 font-semibold' : 'text-slate-700 hover:bg-slate-50'); ?>">Layanan</a>
            <a href="<?php echo e(route('blog.index')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('blog.*') ? 'bg-red-50 text-red-700 font-semibold' : 'text-slate-700 hover:bg-slate-50'); ?>">Blog &amp; Promo</a>
            <a href="<?php echo e(route('about')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium <?php echo e(request()->routeIs('about') ? 'bg-red-50 text-red-700 font-semibold' : 'text-slate-700 hover:bg-slate-50'); ?>">Tentang Kami</a>
        </nav>
    </header>

    <main class="flex-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="bg-[#0B1120] text-slate-300 border-t border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2.5 mb-4">
                        <?php if($logoUrl !== ''): ?>
                            <img src="<?php echo e(asset(ltrim($logoUrl, '/'))); ?>" alt="<?php echo e($companyName); ?>" class="h-9 w-9 rounded-lg object-contain bg-white p-0.5">
                        <?php else: ?>
                            <span class="h-9 w-9 rounded-lg bg-red-600 text-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                                    <circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/>
                                </svg>
                            </span>
                        <?php endif; ?>
                        <span class="text-base font-extrabold tracking-tight text-white"><?php echo e(strtoupper($companyName)); ?></span>
                    </a>
                    <p class="text-sm leading-relaxed text-slate-400">
                        Portal informasi dan katalog resmi penyewaan kendaraan roda empat di Kota Depok. Melayani sewa harian, mingguan, bulanan, dengan sopir maupun lepas kunci.
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-white tracking-wide mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="<?php echo e(route('home')); ?>" class="text-slate-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="<?php echo e(route('vehicles.index')); ?>" class="text-slate-400 hover:text-white transition-colors">Katalog Daftar Mobil</a></li>
                        <li><a href="<?php echo e(route('services.index')); ?>" class="text-slate-400 hover:text-white transition-colors">Paket Layanan Rental</a></li>
                        <li><a href="<?php echo e(route('blog.index')); ?>" class="text-slate-400 hover:text-white transition-colors">Blog, Berita &amp; Promo</a></li>
                        <li><a href="<?php echo e(route('about')); ?>" class="text-slate-400 hover:text-white transition-colors">Tentang Kami &amp; Lokasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-white tracking-wide mb-4">Layanan Unggulan</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <?php $__currentLoopData = $footerServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $srv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('services.index')); ?>" class="hover:text-white transition-colors"><?php echo e($srv->title); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-white tracking-wide mb-4">Kontak &amp; Alamat</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span><?php echo e($profile?->address ?? 'Jalan Jati No. 23, Depok, Jawa Barat 16411'); ?></span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-red-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span class="font-mono tabular-nums"><?php echo e($companyPhone); ?></span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-red-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span><?php echo e($profile?->email ?? 'info@cvmerahputih-rental.co.id'); ?></span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($companyName); ?> Depok. Seluruh Hak Cipta Dilindungi.</p>
                <p><?php echo e($profile?->operating_hours ?? 'Senin - Minggu: 07.00 - 22.00 WIB'); ?></p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggleBtn = document.getElementById('mobile-menu-toggle');
            var drawer = document.getElementById('mobile-nav-drawer');
            var iconOpen = document.getElementById('mobile-icon-open');
            var iconClose = document.getElementById('mobile-icon-close');

            if (toggleBtn && drawer) {
                toggleBtn.addEventListener('click', function () {
                    var isHidden = drawer.classList.contains('hidden');
                    drawer.classList.toggle('hidden');
                    toggleBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                    if (iconOpen && iconClose) {
                        iconOpen.classList.toggle('hidden');
                        iconClose.classList.toggle('hidden');
                    }
                });
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\envy\Documents\WEB2\CV-Merah-Putih2\resources\views/layouts/app.blade.php ENDPATH**/ ?>