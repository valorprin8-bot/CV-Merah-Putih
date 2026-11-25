@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Artikel' : 'Tulis Artikel Baru')
@section('page_title', $isEdit ? 'Edit Artikel' : 'Tulis Artikel Baru')

@section('content')
<div class="max-w-3xl bg-white border border-slate-200 rounded-2xl p-6 sm:p-8">
    <div class="flex items-center justify-between gap-4 pb-5 mb-6 border-b border-slate-200">
        <div>
            <h2 class="text-base font-extrabold text-slate-900">{{ $isEdit ? 'Edit Artikel' : 'Tulis Artikel & Promo Baru' }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Artikel berstatus Terpublikasi akan langsung tampil pada halaman Blog publik.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>

    <form action="{{ $isEdit ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="title" class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Artikel</label>
            <input id="title" name="title" type="text" required value="{{ old('title', $article->title) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="category" class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                <input id="category" name="category" type="text" required value="{{ old('category', $article->category) }}" placeholder="Promo Spesial / Panduan Layanan" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Publikasi</label>
                <select id="status" name="status" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                    <option value="published" @selected(old('status', $article->status) === 'published')>Terpublikasi</option>
                    <option value="draft" @selected(old('status', $article->status) === 'draft')>Draft (Sembunyikan)</option>
                </select>
            </div>

            <div>
                <label for="published_at" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Terbit</label>
                <input id="published_at" name="published_at" type="date" required value="{{ old('published_at', $article->published_at?->format('Y-m-d') ?? now()->toDateString()) }}" class="w-full px-3.5 py-2 text-sm font-mono border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('published_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="author" class="block text-xs font-semibold text-slate-700 mb-1.5">Penulis</label>
                <input id="author" name="author" type="text" value="{{ old('author', $article->author) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
        </div>

        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
            <label for="image" class="block text-xs font-semibold text-slate-700">Gambar Cover Artikel (JPG/PNG/WebP, maks 5 MB)</label>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <img id="article-image-preview" src="{{ asset(ltrim($article->image_url ?: '/images/blog-puncak-trip.jpg', '/')) }}" alt="Preview Cover Artikel" class="w-40 h-24 rounded-lg object-cover border border-slate-200 bg-white">
                <div class="flex-1 w-full">
                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    <input name="image_url" type="hidden" value="{{ old('image_url', $article->image_url) }}">
                    @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div>
            <label for="excerpt" class="block text-xs font-semibold text-slate-700 mb-1.5">Ringkasan Singkat</label>
            <textarea id="excerpt" name="excerpt" rows="2" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">{{ old('excerpt', $article->excerpt) }}</textarea>
            @error('excerpt') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="content" class="block text-xs font-semibold text-slate-700 mb-1.5">Isi Artikel Lengkap (Pisahkan paragraf dengan Enter 2x)</label>
            <textarea id="content" name="content" rows="8" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">{{ old('content', $article->content) }}</textarea>
            @error('content') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-lg">Batal</a>
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg">
                {{ $isEdit ? 'Simpan Perubahan' : 'Publikasikan Artikel' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('image')?.addEventListener('change', function (e) {
        var file = e.target.files && e.target.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (ev) {
            var img = document.getElementById('article-image-preview');
            if (img && ev.target && ev.target.result) img.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpushs