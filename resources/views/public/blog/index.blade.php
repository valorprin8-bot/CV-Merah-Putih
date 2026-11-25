@extends('layouts.app')

@section('title', 'Blog & Promo — ' . $profile->company_name)

@section('content')
<section class="bg-slate-900 text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-semibold text-red-400 tracking-wide">Blog &amp; Informasi</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight">Berita, Promo &amp; Tips Perjalanan</h1>
        <p class="mt-3 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">
            Dapatkan informasi promo sewa mobil terbaru, panduan lengkap sewa lepas kunci, serta rekomendasi destinasi wisata keluarga dari Depok.
        </p>
    </div>
</section>

<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('blog.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 mb-8 border-b border-slate-200">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('blog.index', ['q' => $filters['q']]) }}" class="px-3.5 py-2 text-xs font-semibold rounded-lg border transition-colors {{ $filters['category'] === 'all' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                    Semua Kategori
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat, 'q' => $filters['q']]) }}" class="px-3.5 py-2 text-xs font-semibold rounded-lg border transition-colors {{ $filters['category'] === $cat ? 'bg-red-600 text-white border-red-600' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center gap-2 w-full md:w-80">
                @if ($filters['category'] !== 'all')
                    <input type="hidden" name="category" value="{{ $filters['category'] }}">
                @endif
                <input type="search" name="q" value="{{ $filters['q'] }}" placeholder="Cari berita atau promo..." class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded-lg shrink-0">Cari</button>
            </div>
        </form>

        @if ($articles->isEmpty())
            <div class="text-center py-16 px-6 bg-slate-50 border border-slate-200 rounded-xl">
                <p class="text-base font-bold text-slate-900">Artikel tidak ditemukan</p>
                <p class="mt-1.5 text-sm text-slate-600">Belum ada artikel yang cocok dengan filter pencarian Anda.</p>
                <a href="{{ route('blog.index') }}" class="mt-4 inline-flex px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg">Lihat Semua Artikel</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($articles as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection