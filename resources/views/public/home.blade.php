@extends('layouts.app')

@section('title', $profile->company_name . ' — Rental Mobil Depok Aman & Terpercaya')

@section('content')
@php
    $waDigits = preg_replace('/\D+/', '', (string) ($profile->whatsapp ?: $profile->phone)) ?: '6281288992323';
    if (str_starts_with($waDigits, '0')) {
        $waDigits = '62' . substr($waDigits, 1);
    } elseif (! str_starts_with($waDigits, '62')) {
        $waDigits = '62' . $waDigits;
    }
    $waUrl = 'https://wa.me/' . $waDigits . '?text=' . rawurlencode("Halo {$profile->company_name} Depok, saya melihat website Anda dan ingin menanyakan informasi ketersediaan sewa mobil.");

    $lowestCompact = $lowestPrice >= 1000000
        ? 'Rp ' . str_replace('.', ',', rtrim(rtrim(number_format($lowestPrice / 1000000, 1, '.', ''), '0'), '.')) . 'jt'
        : 'Rp ' . round($lowestPrice / 1000) . 'rb';
    $shortAddress = explode(',', $profile->address)[0] ?? 'Jalan Jati No. 23';
@endphp

{{-- Hero Section --}}
<section class="relative bg-[#0B1120] text-white overflow-hidden">
    <div class="absolute inset-0 pointer-events-none opacity-40" style="background: radial-gradient(circle at 80% 25%, rgba(220, 38, 38, 0.28), transparent 48%), radial-gradient(circle at 12% 85%, rgba(220, 38, 38, 0.14), transparent 45%);"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            <div class="lg:col-span-7">
                <p class="text-xs sm:text-sm font-medium text-slate-300 tracking-wide mb-4">
                    Pusat Informasi &amp; Katalog Resmi &middot; {{ $shortAddress }}, Depok
                </p>

                <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold tracking-tight leading-[1.1] text-white">
                    Rental Mobil Depok <span class="text-red-500">Aman, Nyaman</span> &amp; Terpercaya
                </h1>

                <p class="mt-5 text-base sm:text-lg text-slate-300 leading-relaxed max-w-xl">
                    {{ $profile->company_name }} menyediakan beragam pilihan armada keluaran terbaru untuk kebutuhan perjalanan keluarga, dinas kantor, maupun wisata. Tersedia layanan <strong class="text-white font-semibold">Dengan Sopir</strong> dan <strong class="text-white font-semibold">Lepas Kunci</strong>.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3.5">
                    <a href="{{ route('vehicles.index') }}" class="inline-flex items-center gap-2.5 px-6 py-3.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                            <circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/>
                        </svg>
                        <span>Lihat Katalog Mobil</span>
                    </a>

                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 px-6 py-3.5 text-sm font-semibold text-slate-100 bg-white/10 hover:bg-white/15 border border-white/15 rounded-lg transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
                        </svg>
                        <span>Konsultasi via WhatsApp</span>
                    </a>
                </div>

                <div class="mt-10 pt-8 border-t border-slate-800 grid grid-cols-3 gap-6 max-w-lg">
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-white font-mono tabular-nums">{{ $vehicles->count() }}+</p>
                        <p class="mt-1 text-xs text-slate-400">Varian Armada</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-emerald-400 font-mono tabular-nums">
                            {{ $availableCount }} <span class="font-sans text-base sm:text-lg font-bold">Unit</span>
                        </p>
                        <p class="mt-1 text-xs text-slate-400">Siap Sewa Hari Ini</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-white font-mono tabular-nums">100%</p>
                        <p class="mt-1 text-xs text-slate-400">Unit Terawat Resmi</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-4 sm:p-5">
                    <div class="relative aspect-[16/10] rounded-xl overflow-hidden bg-slate-800">
                        <img src="{{ asset(ltrim($profile->hero_image_url ?: '/images/hero-garage.jpg', '/')) }}" alt="Armada {{ $profile->company_name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/75 via-slate-950/25 to-transparent pointer-events-none"></div>
                        <div class="absolute top-3 right-3 px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs font-bold font-mono tabular-nums">
                            Mulai {{ $lowestCompact }}/hari
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-white">Garasi Pusat Depok</p>
                            <p class="mt-0.5 text-xs text-slate-400 flex items-center gap-1.5 truncate">
                                <svg class="w-3.5 h-3.5 text-red-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span class="truncate">{{ $profile->address }}</span>
                            </p>
                        </div>
                        <a href="{{ route('about') }}" class="text-xs font-semibold text-white hover:text-red-400 transition-colors whitespace-nowrap shrink-0">
                            Lihat Lokasi &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Pilihan Paket Rental --}}
<section class="py-16 lg:py-20 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <p class="text-xs font-bold text-red-600 tracking-wide">Layanan Kami</p>
            <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Pilihan Paket Rental Fleksibel</h2>
            <p class="mt-2.5 text-sm sm:text-base text-slate-600 leading-relaxed">
                Sesuaikan jenis penyewaan kendaraan dengan kebutuhan mobilitas pribadi, keluarga, maupun korporat Anda di Depok dan sekitarnya.
            </p>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($services as $index => $service)
                <div class="flex flex-col justify-between p-6 bg-slate-50/70 border border-slate-200 rounded-xl hover:border-slate-300 transition-colors">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-5">
                            <span class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                <x-service-icon :name="$service->icon" class="w-5 h-5" />
                            </span>
                            <span class="text-xs font-medium text-slate-500">
                                {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} &middot; {{ $service->subtitle }}
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $service->title }}</h3>
                        <p class="mt-2.5 text-sm text-slate-600 leading-relaxed">{{ $service->description }}</p>
                    </div>

                    <a href="{{ route('services.index') }}" class="mt-6 pt-4 border-t border-slate-200/80 inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-red-700">
                        <span>Pelajari Syarat Layanan</span>
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Kendaraan Unggulan --}}
<section class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200/70">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <p class="text-xs font-bold text-red-600 tracking-wide">Katalog Armada</p>
                <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kendaraan Unggulan {{ $profile->company_name }}</h2>
            </div>
            <a href="{{ route('vehicles.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700 whitespace-nowrap">
                <span>Lihat Semua ({{ $vehicles->count() }} Mobil)</span>
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($featuredVehicles as $vehicle)
                <x-vehicle-card :vehicle="$vehicle" />
            @endforeach
        </div>
    </div>
</section>

{{-- Blog & Informasi Terbaru --}}
<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <p class="text-xs font-bold text-red-600 tracking-wide">Blog &amp; Informasi</p>
                <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Berita, Promo &amp; Tips Perjalanan</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700 whitespace-nowrap">
                <span>Baca Semua Artikel</span>
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($latestArticles as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>
    </div>
</section>

{{-- Banner Kontak & Garasi --}}
<section class="pb-16 lg:pb-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900 rounded-2xl p-8 sm:p-10 lg:p-12 flex flex-col lg:flex-row lg:items-center justify-between gap-8 border border-slate-800">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold text-red-400 tracking-wide">Kunjungi Kantor &amp; Garasi Kami</p>
                <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Siap Memulai Perjalanan Anda Bersama {{ $profile->company_name }}?
                </h2>
                <p class="mt-3 text-sm text-slate-300 flex flex-wrap items-center gap-x-2 gap-y-1">
                    <span>{{ $profile->address }}</span>
                    <span aria-hidden="true">&middot;</span>
                    <span>Telp/WA: <strong class="text-white font-mono tabular-nums">{{ $profile->phone }}</strong></span>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors whitespace-nowrap">
                    <span>Hubungi Admin</span>
                </a>
                <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-slate-100 bg-white/10 hover:bg-white/15 border border-white/15 rounded-lg transition-colors whitespace-nowrap">
                    <span>Profil &amp; Peta Lokasi</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection