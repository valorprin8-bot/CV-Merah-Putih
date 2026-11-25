<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['article']));

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

foreach (array_filter((['article']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<article class="group flex flex-col bg-white border border-slate-200 rounded-xl overflow-hidden hover:border-slate-300 transition-colors duration-150">
    <a href="<?php echo e(route('blog.show', $article)); ?>" class="block aspect-[16/10] overflow-hidden bg-slate-100">
        <img src="<?php echo e(asset(ltrim($article->image_url, '/'))); ?>" alt="<?php echo e($article->title); ?>" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-300">
    </a>

    <div class="p-5 flex-1 flex flex-col">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="font-semibold text-red-600"><?php echo e($article->category); ?></span>
            <span aria-hidden="true">&middot;</span>
            <time datetime="<?php echo e($article->published_at?->format('Y-m-d')); ?>">
                <?php echo e($article->published_at?->translatedFormat('d F Y')); ?>

            </time>
        </div>

        <h3 class="mt-2.5 text-base font-bold text-slate-900 leading-snug group-hover:text-red-600 transition-colors line-clamp-2">
            <a href="<?php echo e(route('blog.show', $article)); ?>"><?php echo e($article->title); ?></a>
        </h3>

        <p class="mt-2 text-sm text-slate-600 leading-relaxed line-clamp-3 flex-1">
            <?php echo e($article->excerpt); ?>

        </p>

        <div class="mt-5 pt-3 border-t border-slate-100">
            <a href="<?php echo e(route('blog.show', $article)); ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-red-700 whitespace-nowrap">
                <span>Baca Selengkapnya</span>
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</article><?php /**PATH C:\Users\envy\Documents\WEB2\CV-Merah-Putih2\resources\views/components/article-card.blade.php ENDPATH**/ ?>