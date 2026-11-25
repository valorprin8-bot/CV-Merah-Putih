@extends('layouts.app')

@section('title', 'Daftar Armada — ' . $profile->company_name)

@section('content')
<section class="bg-slate-900 text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-semibold text-red-400 tracking-wide">Katalog Kendaraan</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight">Daftar Armada Siap Sewa</h1>
        <p class="mt-3 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">
            Telusuri seluruh unit kendaraan {{ $profile->company_name }} lengkap dengan status ketersediaan terkini, kapasitas kursi, jenis transmisi, serta tarif sewa harian yang transparan.
        </p>
    </div>
</section>

<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Filter Toolbar --}}
        <form action="{{ route('vehicles.index') }}" method="GET" class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                <div class="lg:col-span-5">
                    <label for="vehicle-search" class="block text-xs font-semibold text-slate-700 mb-1.5">Cari Nama atau Tipe Mobil</label>
                    <input id="vehicle-search" type="search" name="q" value="{{ $filters['q'] }}" placeholder="Contoh: Avanza, Brio, HiAce, MPV..." class="w-full px-4 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>

                <div class="lg:col-span-3">
                    <label for="status-filter" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Ketersediaan</label>
                    <select id="status-filter" name="status" class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-600">
                        <option value="all" @selected($filters['status'] === 'all')>Semua Status</option>
                        <option value="tersedia" @selected($filters['status'] === 'tersedia')>Tersedia</option>
                        <option value="disewa" @selected($filters['status'] === 'disewa')>Sedang Disewa</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="transmission-filter" class="block text-xs font-semibold text-slate-700 mb-1.5">Transmisi</label>
                    <select id="transmission-filter" name="transmission" class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-600">
                        <option value="all" @selected($filters['transmission'] === 'all')>Semua</option>
                        <option value="Matic" @selected($filters['transmission'] === 'Matic')>Matic</option>
                        <option value="Manual" @selected($filters['transmission'] === 'Manual')>Manual</option>
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
                    Menampilkan <span class="font-mono font-bold text-slate-900 tabular-nums">{{ $vehicles->count() }}</span> dari
                    <span class="font-mono font-bold text-slate-900 tabular-nums">{{ $totalAllVehicles }}</span> unit armada
                </p>
                @if ($filters['q'] !== '' || $filters['status'] !== 'all' || $filters['transmission'] !== 'all')
                    <a href="{{ route('vehicles.index') }}" class="text-red-600 hover:text-red-700 font-semibold">Reset Filter</a>
                @endif
            </div>
        </form>

        @if ($vehicles->isEmpty())
            <div class="text-center py-16 px-6 bg-slate-50 border border-slate-200 rounded-xl">
                <p class="text-base font-bold text-slate-900">Kendaraan tidak ditemukan</p>
                <p class="mt-1.5 text-sm text-slate-600 max-w-md mx-auto">
                    Tidak ada armada yang cocok dengan kriteria pencarian Anda. Silakan ubah kata kunci atau reset filter.
                </p>
                <a href="{{ route('vehicles.index') }}" class="mt-5 inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                    Tampilkan Semua Armada
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($vehicles as $vehicle)
                    <x-vehicle-card :vehicle="$vehicle" />
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection