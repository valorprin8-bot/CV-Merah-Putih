@extends('layouts.admin')

@section('title', 'Kelola Artikel & Blog')
@section('page_title', 'Kelola Artikel & Blog')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900">Daftar Artikel &amp; Promo ({{ $articles->count() }})</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola publikasi berita, promo spesial, serta tips perjalanan CV. Merah Putih.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors whitespace-nowrap shrink-0">
            <span>+ Tulis Artikel Baru</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/70 text-xs font-semibold text-slate-500">
                        <th class="py-3.5 px-5">Artikel</th>
                        <th class="py-3.5 px-5">Kategori</th>
                        <th class="py-3.5 px-5">Tanggal</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($articles as $a)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset(ltrim($a->image_url, '/')) }}" alt="{{ $a->title }}" class="w-16 h-11 rounded-lg object-cover border border-slate-200 bg-slate-100 shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-900 line-clamp-1">{{ $a->title }}</p>
                                        <p class="text-xs text-slate-500">Oleh {{ $a->author }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-xs font-semibold text-slate-700">{{ $a->category }}</td>
                            <td class="py-3.5 px-5 text-xs text-slate-600 font-mono">{{ $a->published_at?->format('Y-m-d') }}</td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-md text-xs font-semibold border {{ $a->status === 'published' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                    {{ $a->status === 'published' ? 'Terpublikasi' : 'Draft' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('admin.articles.edit', $a) }}" class="inline-flex px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg">Edit</a>
                                <form action="{{ route('admin.articles.destroy', $a) }}" method="POST" class="inline" onsubmit="return confirm('Hapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-sm text-slate-500">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection