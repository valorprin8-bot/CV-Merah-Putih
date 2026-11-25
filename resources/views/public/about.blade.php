@extends('layouts.app')

@section('title', 'Tentang Kami — ' . $profile->company_name)

@section('content')
@php
    $waDigits = preg_replace('/\D+/', '', (string) ($profile->whatsapp ?: $profile->phone)) ?: '6281288992323';
    if (str_starts_with($waDigits, '0')) {
        $waDigits = '62' . substr($waDigits, 1);
    } elseif (! str_starts_with($waDigits, '62')) {
        $waDigits = '62' . $waDigits;
    }
    $waUrl = 'https://wa.me/' . $waDigits . '?text=' . rawurlencode("Halo {$profile->company_name}, saya ingin menghubungi kantor Depok untuk informasi sewa mobil.");
    $mapsUrl = $profile->maps_url ?: 'https://maps.google.com/?q=Jalan+Jati+No.+23+Depok+Jawa+Barat+16411';
@endphp

<section class="bg-slate-900 text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-semibold text-red-400 tracking-wide">Profil Perusahaan</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $profile->company_name }}</h1>
        <p class="mt-3 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">{{ $profile->tagline }}</p>
    </div>
</section>

<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-stretch">
            <div class="lg:col-span-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        @if (! empty($profile->logo_url))
                            <img src="{{ asset(ltrim($profile->logo_url, '/')) }}" alt="Logo {{ $profile->company_name }}" class="h-12 w-12 rounded-xl object-contain border border-slate-200 bg-slate-50 p-1">
                        @endif
                        <div>
                            <p class="text-xs font-semibold text-slate-500">Identitas Resmi</p>
                            <p class="text-base font-bold text-slate-900">Terdaftar &amp; Beroperasi di Depok</p>
                        </div>
                    </div>

                    <p class="text-base text-slate-700 leading-relaxed whitespace-pre-line">{{ $profile->description }}</p>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Alamat Kantor &amp; Garasi</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">{{ $profile->address }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Telepon / WhatsApp</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900 font-mono tabular-nums">{{ $profile->phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Email Resmi</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">{{ $profile->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Jam Operasional</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">{{ $profile->operating_hours }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="h-full min-h-[280px] rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
                    <img src="{{ asset(ltrim($profile->about_image_url ?: '/images/hero-garage.jpg', '/')) }}" alt="Kantor & Garasi {{ $profile->company_name }}" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-12 lg:py-16 bg-slate-50 border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-5 bg-slate-900 text-white rounded-2xl p-7 sm:p-8 flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-red-400 tracking-wide">Visi Perusahaan</p>
                <blockquote class="mt-4 text-xl sm:text-2xl font-bold leading-snug text-white">
                    &ldquo;{{ $profile->vision }}&rdquo;
                </blockquote>
            </div>
            <p class="mt-8 text-xs text-slate-400">{{ $profile->company_name }} &middot; Depok, Jawa Barat</p>
        </div>

        <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl p-7 sm:p-8">
            <p class="text-xs font-bold text-red-600 tracking-wide">Misi Perusahaan</p>
            <h2 class="mt-2 text-xl font-extrabold text-slate-900">Komitmen Pelayanan Kami</h2>
            <ul class="mt-5 space-y-3.5">
                @foreach (($profile->missions ?? []) as $mission)
                    <li class="flex items-start gap-3 text-sm sm:text-base text-slate-700 leading-relaxed">
                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        <span>{{ $mission }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <p class="text-xs font-bold text-red-600 tracking-wide">Lokasi Kantor &amp; Garasi</p>
                <h2 class="mt-1.5 text-2xl font-extrabold text-slate-900">{{ $profile->company_name }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ $profile->address }}</p>
                <p class="mt-1 text-xs text-slate-500">
                    Akses mudah dari Jl. Margonda Raya &amp; pusat Kota Depok. Silakan konfirmasi jadwal kunjungan dengan admin kami.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded-lg transition-colors whitespace-nowrap">
                    <span>Buka di Google Maps</span>
                </a>
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors whitespace-nowrap">
                    <span>Chat WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection