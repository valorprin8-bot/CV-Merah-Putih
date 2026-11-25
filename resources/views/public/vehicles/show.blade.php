@extends('layouts.app')

@section('title', $vehicle->name . ' — ' . $profile->company_name)

@section('content')
@php
    $isAvailable = $vehicle->status === 'tersedia';
    $waDigits = preg_replace('/\D+/', '', (string) ($profile->whatsapp ?: $profile->phone)) ?: '6281288992323';
    if (str_starts_with($waDigits, '0')) {
        $waDigits = '62' . substr($waDigits, 1);
    } elseif (! str_starts_with($waDigits, '62')) {
        $waDigits = '62' . $waDigits;
    }
    $formattedPrice = 'Rp ' . number_format((int) $vehicle->price_per_day, 0, ',', '.');
    $waUrl = 'https://wa.me/' . $waDigits . '?text=' . rawurlencode("Halo {$profile->company_name}, saya tertarik menyewa unit {$vehicle->name} ({$vehicle->transmission}, {$formattedPrice}/hari). Apakah tersedia untuk jadwal saya?");
@endphp

<section class="py-10 lg:py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('vehicles.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 mb-6 transition-colors">
            <span>&larr; Kembali ke Daftar Mobil</span>
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-7">
                <div class="aspect-[4/3] rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
                    <img src="{{ asset(ltrim($vehicle->image_url, '/')) }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
                </div>

                <div class="mt-8">
                    <h2 class="text-lg font-bold text-slate-900">Deskripsi &amp; Kondisi Unit</h2>
                    <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $vehicle->description ?: 'Unit terawat rutin di bengkel resmi, kabin bersih dan siap menemani perjalanan Anda di Depok maupun luar kota.' }}
                    </p>

                    @if (! empty($vehicle->features))
                        <div class="mt-8 pt-6 border-t border-slate-200">
                            <h3 class="text-base font-bold text-slate-900 mb-4">Fasilitas &amp; Keunggulan Unit</h3>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($vehicle->features as $feat)
                                    <li class="flex items-start gap-2.5 text-sm text-slate-700">
                                        <svg class="w-4 h-4 text-emerald-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        <span>{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-7">
                    <div class="flex items-center justify-between gap-3 text-xs font-semibold">
                        <span class="text-red-600">{{ $vehicle->category }}</span>
                        <span class="inline-flex items-center gap-1.5 {{ $isAvailable ? 'text-emerald-700' : 'text-amber-700' }}">
                            <span>{{ $isAvailable ? 'Tersedia' : 'Sedang Disewa' }}</span>
                        </span>
                    </div>

                    <h1 class="mt-2.5 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $vehicle->name }}</h1>

                    <div class="mt-5 pb-5 border-b border-slate-200">
                        <p class="text-xs font-medium text-slate-500">Tarif Sewa Harian</p>
                        <p class="mt-1 text-3xl font-extrabold text-slate-900 font-mono tabular-nums">
                            {{ $formattedPrice }}
                            <span class="text-sm font-sans font-normal text-slate-500">/ 24 jam</span>
                        </p>
                    </div>

                    <dl class="mt-5 grid grid-cols-2 gap-4">
                        <div class="bg-white border border-slate-200 rounded-xl p-3.5">
                            <dt class="text-xs text-slate-500">Kapasitas</dt>
                            <dd class="mt-1 text-sm font-bold text-slate-900">{{ $vehicle->seats }} Penumpang</dd>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-3.5">
                            <dt class="text-xs text-slate-500">Transmisi</dt>
                            <dd class="mt-1 text-sm font-bold text-slate-900">{{ $vehicle->transmission }}</dd>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-3.5">
                            <dt class="text-xs text-slate-500">Tahun Unit</dt>
                            <dd class="mt-1 text-sm font-bold text-slate-900 font-mono tabular-nums">{{ $vehicle->year }}</dd>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-3.5">
                            <dt class="text-xs text-slate-500">Bahan Bakar</dt>
                            <dd class="mt-1 text-sm font-bold text-slate-900">{{ $vehicle->fuel }}</dd>
                        </div>
                    </dl>

                    @if ($vehicle->engine)
                        <div class="mt-4 bg-white border border-slate-200 rounded-xl p-3.5 flex items-center justify-between text-sm">
                            <span class="text-xs text-slate-500">Spesifikasi Mesin</span>
                            <span class="font-semibold text-slate-900">{{ $vehicle->engine }}</span>
                        </div>
                    @endif

                    <div class="mt-6 space-y-3">
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors">
                            <span>Tanyakan Ketersediaan via WhatsApp</span>
                        </a>
                        <a href="{{ route('services.index') }}#syarat-ketentuan" class="w-full inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg transition-colors">
                            Lihat Syarat &amp; Ketentuan Sewa
                        </a>
                    </div>

                    <p class="mt-4 text-xs text-slate-500 leading-relaxed">
                        Informasi ketersediaan diperbarui langsung oleh tim admin {{ $profile->company_name }}. Pemesanan dan konfirmasi jadwal dilakukan langsung melalui admin resmi kami.
                    </p>
                </div>
            </div>
        </div>

        @if ($otherVehicles->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-extrabold text-slate-900">Armada Lainnya</h2>
                    <a href="{{ route('vehicles.index') }}" class="text-sm font-semibold text-red-600 hover:text-red-700">Lihat Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($otherVehicles as $car)
                        <x-vehicle-card :vehicle="$car" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection