@extends('layouts.app')

@section('title', $article->title . ' — ' . $profile->company_name)

@section('content')
@php
    $waDigits = preg_replace('/\D+/', '', (string) ($profile->whatsapp ?: $profile->phone)) ?: '6281288992323';
    if (str_starts_with($waDigits, '0')) {
        $waDigits = '62' . substr($waDigits, 1);
    } elseif (! str_starts_with($waDigits, '62')) {
        $waDigits = '62' . $waDigits;
    }
    $waUrl = 'https://wa.me/' . $waDigits . '?text=' . rawurlencode("Halo {$profile->company_name}, saya baru membaca artikel \"{$article->title}\" dan ingin menanyakan informasi lebih lanjut.");
    $paragraphs = array_values(array_filter(array_map('trim', preg_split('/\R\s*\R/', (string) $article->content) ?: [])));
@endphp

<article class="py-10 lg:py-14 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 mb-6 transition-colors">
            <span>&larr; Kembali ke Blog &amp; Promo</span>
        </a>

        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
            <span class="font-semibold text-red-600">{{ $article->category }}</span>
            <span aria-hidden="true">&middot;</span>
            <time datetime="{{ $article->published_at?->format('Y-m-d') }}">
                {{ $article->published_at?->translatedFormat('d F Y') }}
            </time>
            <span aria-hidden="true">&middot;</span>
            <span>Oleh {{ $article->author }}</span>
        </div>

        <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
            {{ $article->title }}
        </h1>

        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">{{ $article->excerpt }}</p>

        <div class="mt-8 aspect-[16/9] rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
            <img src="{{ asset(ltrim($article->image_url, '/')) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>

        <div class="mt-9 space-y-5 text-base text-slate-700 leading-[1.8]">
            @foreach ($paragraphs as $para)
                <p>{{ $para }}</p>
            @endforeach
        </div>

        <div class="mt-12 p-6 sm:p-7 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Butuh Informasi Lebih Lanjut?</h2>
                <p class="mt-1 text-sm text-slate-600">Hubungi admin {{ $profile->company_name }} untuk menanyakan promo atau ketersediaan armada terbaru.</p>
            </div>
            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors whitespace-nowrap shrink-0">
                <span>Hubungi via WhatsApp</span>
            </a>
        </div>
    </div>
</article>

@if ($relatedArticles->isNotEmpty())
    <section class="py-12 lg:py-16 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-extrabold text-slate-900 mb-6">Artikel Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($relatedArticles as $item)
                    <x-article-card :article="$item" />
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection