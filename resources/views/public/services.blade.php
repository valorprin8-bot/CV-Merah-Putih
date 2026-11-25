@extends('layouts.app')

@section('title', 'Layanan & Syarat Ketentuan — ' . $profile->company_name)

@section('content')
@php
    $waDigits = preg_replace('/\D+/', '', (string) ($profile->whatsapp ?: $profile->phone)) ?: '6281288992323';
    if (str_starts_with($waDigits, '0')) {
        $waDigits = '62' . substr($waDigits, 1);
    } elseif (! str_starts_with($waDigits, '62')) {
        $waDigits = '62' . $waDigits;
    }
@endphp

<section class="bg-slate-900 text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-semibold text-red-400 tracking-wide">Layanan Rental</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight">Paket Layanan {{ $profile->company_name }}</h1>
        <p class="mt-3 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">
            Kami menyediakan berbagai skema layanan penyewaan mobil yang dapat disesuaikan dengan kebutuhan perjalanan pribadi, keluarga, maupun operasional perusahaan Anda.
        </p>
    </div>
</section>

<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($services as $index => $service)
                @php
                    $serviceWaUrl = 'https://wa.me/' . $waDigits . '?text=' . rawurlencode("Halo {$profile->company_name}, saya ingin menanyakan detail tarif dan ketersediaan untuk layanan \"{$service->title}\".");
                @endphp
                <article class="flex flex-col justify-between bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 hover:border-slate-300 transition-colors">
                    <div>
                        <div class="flex items-center justify-between gap-4 mb-5">
                            <span class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                <x-service-icon :name="$service->icon" class="w-5 h-5" />
                            </span>
                            <span class="text-xs font-semibold text-slate-500">
                                {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} &middot; {{ $service->subtitle }}
                            </span>
                        </div>

                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">{{ $service->title }}</h2>
                        <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $service->description }}</p>

                        <div class="mt-6 pt-5 border-t border-slate-100">
                            <p class="text-xs font-bold text-slate-900 mb-3">Keunggulan &amp; Cakupan</p>
                            <ul class="space-y-2.5">
                                @foreach (($service->highlights ?? []) as $item)
                                    <li class="flex items-start gap-2.5 text-sm text-slate-700">
                                        <svg class="w-4 h-4 text-emerald-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                        <a href="{{ route('vehicles.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-900 hover:text-red-600 transition-colors">
                            <span>Lihat Pilihan Unit &rarr;</span>
                        </a>

                        <a href="{{ $serviceWaUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors whitespace-nowrap">
                            <span>Tanya Paket Ini</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="syarat-ketentuan" class="py-12 lg:py-16 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-bold text-red-600 tracking-wide">Ketentuan Resmi</p>
        <h2 class="mt-1 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Syarat &amp; Ketentuan Umum Penyewaan</h2>
        <p class="mt-2 text-sm text-slate-600 max-w-2xl">
            Ketentuan berikut berlaku untuk seluruh layanan penyewaan kendaraan pada {{ $profile->company_name }} dan diperbarui secara berkala oleh pengelola.
        </p>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($termsSections as $section)
                <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7">
                    <h3 class="text-base font-bold text-slate-900 mb-4">{{ $section->title }}</h3>
                    <ul class="space-y-3">
                        @foreach (($section->items ?? []) as $idx => $clause)
                            <li class="flex items-start gap-3 text-sm text-slate-700 leading-relaxed">
                                <span class="font-mono text-xs font-semibold text-slate-400 mt-0.5 tabular-nums shrink-0">
                                    {{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }}.
                                </span>
                                <span>{{ $clause }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection