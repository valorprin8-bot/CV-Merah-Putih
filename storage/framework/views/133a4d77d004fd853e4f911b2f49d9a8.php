

<?php $__env->startSection('title', 'Layanan & Syarat Ketentuan — ' . $profile->company_name); ?>

<?php $__env->startSection('content'); ?>
<?php
    $waDigits = preg_replace('/\D+/', '', (string) ($profile->whatsapp ?: $profile->phone)) ?: '6281288992323';
    if (str_starts_with($waDigits, '0')) {
        $waDigits = '62' . substr($waDigits, 1);
    } elseif (! str_starts_with($waDigits, '62')) {
        $waDigits = '62' . $waDigits;
    }
?>

<section class="bg-slate-900 text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-semibold text-red-400 tracking-wide">Layanan Rental</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight">Paket Layanan <?php echo e($profile->company_name); ?></h1>
        <p class="mt-3 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">
            Kami menyediakan berbagai skema layanan penyewaan mobil yang dapat disesuaikan dengan kebutuhan perjalanan pribadi, keluarga, maupun operasional perusahaan Anda.
        </p>
    </div>
</section>

<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $serviceWaUrl = 'https://wa.me/' . $waDigits . '?text=' . rawurlencode("Halo {$profile->company_name}, saya ingin menanyakan detail tarif dan ketersediaan untuk layanan \"{$service->title}\".");
                ?>
                <article class="flex flex-col justify-between bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 hover:border-slate-300 transition-colors">
                    <div>
                        <div class="flex items-center justify-between gap-4 mb-5">
                            <span class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                <?php if (isset($component)) { $__componentOriginal6c5e28112e70617adc1cb07908b1be1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c5e28112e70617adc1cb07908b1be1b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.service-icon','data' => ['name' => $service->icon,'class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('service-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($service->icon),'class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c5e28112e70617adc1cb07908b1be1b)): ?>
<?php $attributes = $__attributesOriginal6c5e28112e70617adc1cb07908b1be1b; ?>
<?php unset($__attributesOriginal6c5e28112e70617adc1cb07908b1be1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c5e28112e70617adc1cb07908b1be1b)): ?>
<?php $component = $__componentOriginal6c5e28112e70617adc1cb07908b1be1b; ?>
<?php unset($__componentOriginal6c5e28112e70617adc1cb07908b1be1b); ?>
<?php endif; ?>
                            </span>
                            <span class="text-xs font-semibold text-slate-500">
                                <?php echo e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?> &middot; <?php echo e($service->subtitle); ?>

                            </span>
                        </div>

                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight"><?php echo e($service->title); ?></h2>
                        <p class="mt-3 text-sm text-slate-600 leading-relaxed"><?php echo e($service->description); ?></p>

                        <div class="mt-6 pt-5 border-t border-slate-100">
                            <p class="text-xs font-bold text-slate-900 mb-3">Keunggulan &amp; Cakupan</p>
                            <ul class="space-y-2.5">
                                <?php $__currentLoopData = ($service->highlights ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="flex items-start gap-2.5 text-sm text-slate-700">
                                        <svg class="w-4 h-4 text-emerald-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        <span><?php echo e($item); ?></span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                        <a href="<?php echo e(route('vehicles.index')); ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-900 hover:text-red-600 transition-colors">
                            <span>Lihat Pilihan Unit &rarr;</span>
                        </a>

                        <a href="<?php echo e($serviceWaUrl); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors whitespace-nowrap">
                            <span>Tanya Paket Ini</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<section id="syarat-ketentuan" class="py-12 lg:py-16 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-bold text-red-600 tracking-wide">Ketentuan Resmi</p>
        <h2 class="mt-1 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Syarat &amp; Ketentuan Umum Penyewaan</h2>
        <p class="mt-2 text-sm text-slate-600 max-w-2xl">
            Ketentuan berikut berlaku untuk seluruh layanan penyewaan kendaraan pada <?php echo e($profile->company_name); ?> dan diperbarui secara berkala oleh pengelola.
        </p>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php $__currentLoopData = $termsSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7">
                    <h3 class="text-base font-bold text-slate-900 mb-4"><?php echo e($section->title); ?></h3>
                    <ul class="space-y-3">
                        <?php $__currentLoopData = ($section->items ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $clause): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-start gap-3 text-sm text-slate-700 leading-relaxed">
                                <span class="font-mono text-xs font-semibold text-slate-400 mt-0.5 tabular-nums shrink-0">
                                    <?php echo e(str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT)); ?>.
                                </span>
                                <span><?php echo e($clause); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\envy\Documents\WEB2\CV-Merah-Putih2\resources\views/public/services.blade.php ENDPATH**/ ?>