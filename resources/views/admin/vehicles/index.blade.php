@extends('layouts.admin')

@section('title', 'Kelola Kendaraan')
@section('page_title', 'Kelola Kendaraan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900">Daftar Armada ({{ $vehicles->count() }} Unit)</h2>
            <p class="text-xs text-slate-500 mt-0.5">Tambah unit baru, ubah tarif sewa, unggah foto unit, atau perbarui status ketersediaan.</p>
        </div>
        <a href="{{ route('admin.vehicles.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors whitespace-nowrap shrink-0">
            <span>+ Tambah Kendaraan</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/70 text-xs font-semibold text-slate-500">
                        <th class="py-3.5 px-5">Unit Armada</th>
                        <th class="py-3.5 px-5">Spesifikasi</th>
                        <th class="py-3.5 px-5 text-right">Tarif / Hari</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($vehicles as $v)
                        @php($isAvailable = $v->status === 'tersedia')
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset(ltrim($v->image_url, '/')) }}" alt="{{ $v->name }}" class="w-16 h-12 rounded-lg object-cover border border-slate-200 bg-slate-100 shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-900 truncate">{{ $v->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $v->category }} @if($v->featured) &middot; Unggulan @endif</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-xs text-slate-600">
                                {{ $v->transmission }} &middot; {{ $v->seats }} Kursi &middot; {{ $v->year }}
                            </td>
                            <td class="py-3.5 px-5 text-right font-mono font-bold text-slate-900 tabular-nums">
                                Rp {{ number_format((int) $v->price_per_day, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-5">
                                <form action="{{ route('admin.vehicles.toggle-status', $v) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 rounded-md text-xs font-semibold border {{ $isAvailable ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-amber-50 text-amber-800 border-amber-200 hover:bg-amber-100' }}">
                                        {{ $isAvailable ? 'Tersedia' : 'Sedang Disewa' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-5 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('admin.vehicles.edit', $v) }}" class="inline-flex px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg">Edit</a>
                                <form action="{{ route('admin.vehicles.destroy', $v) }}" method="POST" class="inline" onsubmit="return confirm('Hapus unit {{ addslashes($v->name) }} dari katalog?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-sm text-slate-500">Belum ada unit kendaraan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection