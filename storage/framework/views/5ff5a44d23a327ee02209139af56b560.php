<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['vehicle']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['vehicle']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $isAvailable = $vehicle->status === 'tersedia';
?>

<article class="group flex flex-col bg-white border border-slate-200 rounded-xl overflow-hidden hover:border-slate-300 transition-colors duration-150">
    <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" class="block relative aspect-[4/3] overflow-hidden bg-slate-100">
        <img src="<?php echo e(asset(ltrim($vehicle->image_url, '/'))); ?>" alt="<?php echo e($vehicle->name); ?>" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-300">
        <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-slate-950/60 to-transparent pointer-events-none"></div>
        <div class="absolute bottom-3 left-3.5 right-3.5 flex items-center justify-between gap-2 text-xs font-medium text-white">
            <span><?php echo e($vehicle->category); ?></span>
            <span class="inline-flex items-center gap-1.5 font-semibold">
                <?php if($isAvailable): ?>
                    <svg class="w-3.5 h-3.5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                    </svg>
                    <span class="text-emerald-200">Tersedia</span>
                <?php else: ?>
                    <svg class="w-3.5 h-3.5 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span class="text-amber-200">Sedang Disewa</span>
                <?php endif; ?>
            </span>
        </div>
    </a>

    <div class="p-5 flex-1 flex flex-col">
        <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" class="text-base font-bold text-slate-900 group-hover:text-red-600 transition-colors line-clamp-1">
            <?php echo e($vehicle->name); ?>

        </a>

        <p class="mt-1.5 text-xs text-slate-500 flex items-center flex-wrap gap-x-2 gap-y-1">
            <span><?php echo e($vehicle->seats); ?> Kursi</span>
            <span aria-hidden="true">&middot;</span>
            <span><?php echo e($vehicle->transmission); ?></span>
            <span aria-hidden="true">&middot;</span>
            <span class="font-mono tabular-nums"><?php echo e($vehicle->year); ?></span>
            <span aria-hidden="true">&middot;</span>
            <span><?php echo e($vehicle->fuel); ?></span>
        </p>

        <div class="mt-5 pt-4 border-t border-slate-100 flex items-end justify-between gap-3">
            <div>
                <p class="text-[11px] font-medium text-slate-500">Harga Sewa</p>
                <p class="text-base font-bold text-slate-900 font-mono tabular-nums">
                    Rp <?php echo e(number_format((int) $vehicle->price_per_day, 0, ',', '.')); ?>

                    <span class="text-xs font-sans font-normal text-slate-500">/hari</span>
                </p>
            </div>
            <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-red-700 whitespace-nowrap shrink-0 py-1.5">
                <span>Detail Unit</span>
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</article><?php /**PATH C:\Users\envy\Documents\WEB2\CV-Merah-Putih2\resources\views/components/vehicle-card.blade.php ENDPATH**/ ?>