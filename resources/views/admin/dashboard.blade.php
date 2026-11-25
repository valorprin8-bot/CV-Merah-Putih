@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-xs font-semibold text-slate-500">Total Armada</p>
            <p class="mt-3 text-3xl font-extrabold text-slate-900 font-mono tabular-nums">{{ $stats['totalVehicles'] }}</p>
            <p class="mt-1 text-xs text-slate-500">Unit terdaftar di katalog</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-xs font-semibold text-slate-500">Unit Tersedia</p>
            <p class="mt-3 text-3xl font-extrabold text-emerald-600 font-mono tabular-nums">{{ $stats['availableVehicles'] }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ $stats['rentedVehicles'] }} unit sedang disewa</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-xs font-semibold text-slate-500">Artikel &amp; Promo</p>
            <p class="mt-3 text-3xl font-extrabold text-slate-900 font-mono tabular-nums">{{ $stats['publishedArticles'] }}</p>
            <p class="mt-1 text-xs text-slate-500">Konten terpublikasi ({{ $stats['totalArticles'] }} total)</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5">
            <p class="text-xs font-semibold text-slate-500">Paket Layanan</p>
            <p class="mt-3 text-3xl font-extrabold text-slate-900 font-mono tabular-nums">{{ $stats['totalServices'] }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ $stats['totalTermsClauses'] }} poin syarat &amp; ketentuan</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-extrabold text-slate-900">Status Ketersediaan Armada Terkini</h2>
                <p class="text-xs text-slate-500 mt-0.5">Klik tombol status untuk mengubah ketersediaan mobil secara cepat.</p>
            </div>
            <a href="{{ route('admin.vehicles.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded-lg transition-colors whitespace-nowrap shrink-0">
                <span>Kelola Semua Kendaraan &rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/70 text-xs font-semibold text-slate-500">
                        <th class="py-3.5 px-5">Kendaraan</th>
                        <th class="py-3.5 px-5">Transmisi</th>
                        <th class="py-3.5 px-5 text-right">Tarif / Hari</th>
                        <th class="py-3.5 px-5 text-right">Status (Klik Ubah)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach ($vehicles as $v)
                        @php($isAvailable = $v->status === 'tersedia')
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-5 font-bold text-slate-900">{{ $v->name }}</td>
                            <td class="py-3.5 px-5 text-xs text-slate-600">{{ $v->transmission }} &middot; {{ $v->seats }} Kursi</td>
                            <td class="py-3.5 px-5 text-right font-mono font-bold text-slate-900 tabular-nums">
                                Rp {{ number_format((int) $v->price_per_day, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-5 text-right">
                                <form action="{{ route('admin.vehicles.toggle-status', $v) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border transition-colors whitespace-nowrap {{ $isAvailable ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-amber-50 text-amber-800 border-amber-200 hover:bg-amber-100' }}">
                                        <span>{{ $isAvailable ? 'Tersedia' : 'Sedang Disewa' }}</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection