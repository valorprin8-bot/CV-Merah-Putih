

<?php $__env->startSection('title', 'Daftar Armada — ' . $profile->company_name); ?>

<?php $__env->startSection('content'); ?>
<section class="bg-slate-900 text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-semibold text-red-400 tracking-wide">Katalog Kendaraan</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight">Daftar Armada Siap Sewa</h1>
        <p class="mt-3 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">
            Telusuri seluruh unit kendaraan <?php echo e($profile->company_name); ?> lengkap dengan status ketersediaan terkini, kapasitas kursi, jenis transmisi, serta tarif sewa harian yang transparan.
        </p>
    </div>
</section>

<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <form action="<?php echo e(route('vehicles.index')); ?>" method="GET" class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                <div class="lg:col-span-5">
                    <label for="vehicle-search" class="block text-xs font-semibold text-slate-700 mb-1.5">Cari Nama atau Tipe Mobil</label>
                    <input id="vehicle-search" type="search" name="q" value="<?php echo e($filters['q']); ?>" placeholder="Contoh: Avanza, Brio, HiAce, MPV..." class="w-full px-4 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>

                <div class="lg:col-span-3">
                    <label for="status-filter" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Ketersediaan</label>
                    <select id="status-filter" name="status" class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-600">
                        <option value="all" <?php if($filters['status'] === 'all'): echo 'selected'; endif; ?>>Semua Status</option>
                        <option value="tersedia" <?php if($filters['status'] === 'tersedia'): echo 'selected'; endif; ?>>Tersedia</option>
                        <option value="disewa" <?php if($filters['status'] === 'disewa'): echo 'selected'; endif; ?>>Sedang Disewa</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="transmission-filter" class="block text-xs font-semibold text-slate-700 mb-1.5">Transmisi</label>
                    <select id="transmission-filter" name="transmission" class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-600">
                        <option value="all" <?php if($filters['transmission'] === 'all'): echo 'selected'; endif; ?>>Semua</option>
                        <option value="Matic" <?php if($filters['transmission'] === 'Matic'): echo 'selected'; endif; ?>>Matic</option>
                        <option value="Manual" <?php if($filters['transmission'] === 'Manual'): echo 'selected'; endif; ?>>Manual</option>
                    </select>
                </div>

                <div class="lg:col-span-2 flex gap-2">
                    <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                        Filter
                    </button>
                </div>
            </div>

            <div class="mt-4 pt-3.5 border-t border-slate-200/80 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-600">
                <p class="font-medium">
                    Menampilkan <span class="font-mono font-bold text-slate-900 tabular-nums"><?php echo e($vehicles->count()); ?></span> dari
                    <span class="font-mono font-bold text-slate-900 tabular-nums"><?php echo e($totalAllVehicles); ?></span> unit armada
                </p>
                <?php if($filters['q'] !== '' || $filters['status'] !== 'all' || $filters['transmission'] !== 'all'): ?>
                    <a href="<?php echo e(route('vehicles.index')); ?>" class="text-red-600 hover:text-red-700 font-semibold">Reset Filter</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if($vehicles->isEmpty()): ?>
            <div class="text-center py-16 px-6 bg-slate-50 border border-slate-200 rounded-xl">
                <p class="text-base font-bold text-slate-900">Kendaraan tidak ditemukan</p>
                <p class="mt-1.5 text-sm text-slate-600 max-w-md mx-auto">
                    Tidak ada armada yang cocok dengan kriteria pencarian Anda. Silakan ubah kata kunci atau reset filter.
                </p>
                <a href="<?php echo e(route('vehicles.index')); ?>" class="mt-5 inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                    Tampilkan Semua Armada
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginale56e826e722be54fb6fce6ea617765f3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale56e826e722be54fb6fce6ea617765f3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.vehicle-card','data' => ['vehicle' => $vehicle]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('vehicle-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['vehicle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($vehicle)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale56e826e722be54fb6fce6ea617765f3)): ?>
<?php $attributes = $__attributesOriginale56e826e722be54fb6fce6ea617765f3; ?>
<?php unset($__attributesOriginale56e826e722be54fb6fce6ea617765f3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale56e826e722be54fb6fce6ea617765f3)): ?>
<?php $component = $__componentOriginale56e826e722be54fb6fce6ea617765f3; ?>
<?php unset($__componentOriginale56e826e722be54fb6fce6ea617765f3); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\envy\Documents\WEB2\CV-Merah-Putih2\resources\views/public/vehicles/index.blade.php ENDPATH**/ ?>