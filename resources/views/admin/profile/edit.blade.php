@extends('layouts.admin')

@section('title', 'Profil Perusahaan')
@section('page_title', 'Profil Perusahaan')

@section('content')
<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    {{-- Kartu Upload Logo & Aset Gambar --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-6">
        <div class="pb-4 border-b border-slate-200">
            <h2 class="text-base font-extrabold text-slate-900">Logo &amp; Aset Gambar Perusahaan</h2>
            <p class="text-xs text-slate-500 mt-0.5">Unggah logo resmi dan foto garasi/kantor perusahaan. Perubahan langsung tampil di website publik setelah disimpan.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- 1. Logo Perusahaan --}}
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                <div>
                    <p class="text-xs font-bold text-slate-900">Logo Perusahaan</p>
                    <p class="text-[11px] text-slate-500">Tampil pada header navigasi, footer, dan Tentang Kami.</p>
                </div>
                <div class="aspect-[4/3] rounded-lg border border-slate-200 bg-white overflow-hidden flex items-center justify-center p-2">
                    @if (! empty($profile->logo_url))
                        <img id="preview-logo" src="{{ asset(ltrim($profile->logo_url, '/')) }}" alt="Logo Perusahaan" class="max-h-full max-w-full object-contain">
                    @else
                        <img id="preview-logo" src="" alt="Preview Logo" class="max-h-full max-w-full object-contain hidden">
                        <span id="placeholder-logo" class="text-xs text-slate-400">Belum ada logo (Ikon default aktif)</span>
                    @endif
                </div>
                <input id="logo_file" name="logo_file" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                @error('logo_file') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                @if (! empty($profile->logo_url))
                    <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remove_logo" value="1" class="rounded border-slate-300 text-red-600">
                        <span>Hapus logo (gunakan ikon default)</span>
                    </label>
                @endif
            </div>

            {{-- 2. Foto Hero Beranda --}}
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                <div>
                    <p class="text-xs font-bold text-slate-900">Foto Hero Beranda</p>
                    <p class="text-[11px] text-slate-500">Tampil di kartu armada utama pada bagian atas Beranda.</p>
                </div>
                <div class="aspect-[4/3] rounded-lg border border-slate-200 bg-white overflow-hidden">
                    <img id="preview-hero" src="{{ asset(ltrim($profile->hero_image_url ?: '/images/hero-garage.jpg', '/')) }}" alt="Foto Hero" class="w-full h-full object-cover">
                </div>
                <input id="hero_image_file" name="hero_image_file" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                @error('hero_image_file') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                    <input type="checkbox" name="reset_hero_image" value="1" class="rounded border-slate-300 text-red-600">
                    <span>Kembalikan ke foto garasi bawaan</span>
                </label>
            </div>

            {{-- 3. Foto Profil Tentang Kami --}}
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                <div>
                    <p class="text-xs font-bold text-slate-900">Foto Profil Tentang Kami</p>
                    <p class="text-[11px] text-slate-500">Tampil di samping profil resmi halaman Tentang Kami.</p>
                </div>
                <div class="aspect-[4/3] rounded-lg border border-slate-200 bg-white overflow-hidden">
                    <img id="preview-about" src="{{ asset(ltrim($profile->about_image_url ?: '/images/hero-garage.jpg', '/')) }}" alt="Foto Tentang Kami" class="w-full h-full object-cover">
                </div>
                <input id="about_image_file" name="about_image_file" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                @error('about_image_file') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                    <input type="checkbox" name="reset_about_image" value="1" class="rounded border-slate-300 text-red-600">
                    <span>Kembalikan ke foto garasi bawaan</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Identitas, Kontak & Visi Misi --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-5">
        <h2 class="text-base font-extrabold text-slate-900 pb-3 border-b border-slate-200">Identitas, Kontak &amp; Visi Misi Perusahaan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="company_name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Perusahaan</label>
                <input id="company_name" name="company_name" type="text" required value="{{ old('company_name', $profile->company_name) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
            <div>
                <label for="tagline" class="block text-xs font-semibold text-slate-700 mb-1.5">Tagline Perusahaan</label>
                <input id="tagline" name="tagline" type="text" required value="{{ old('tagline', $profile->tagline) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
        </div>

        <div>
            <label for="description" class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Profil Perusahaan</label>
            <textarea id="description" name="description" rows="4" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">{{ old('description', $profile->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="address" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap Kantor &amp; Garasi</label>
                <input id="address" name="address" type="text" required value="{{ old('address', $profile->address) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
            <div>
                <label for="operating_hours" class="block text-xs font-semibold text-slate-700 mb-1.5">Jam Operasional</label>
                <input id="operating_hours" name="operating_hours" type="text" required value="{{ old('operating_hours', $profile->operating_hours) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
            <div>
                <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Telepon (Tampilan)</label>
                <input id="phone" name="phone" type="text" required value="{{ old('phone', $profile->phone) }}" class="w-full px-3.5 py-2 text-sm font-mono border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
            <div>
                <label for="whatsapp" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp (Format 628xxx)</label>
                <input id="whatsapp" name="whatsapp" type="text" required value="{{ old('whatsapp', $profile->whatsapp) }}" class="w-full px-3.5 py-2 text-sm font-mono border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email Resmi</label>
                <input id="email" name="email" type="email" required value="{{ old('email', $profile->email) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
            <div>
                <label for="maps_url" class="block text-xs font-semibold text-slate-700 mb-1.5">Tautan Google Maps</label>
                <input id="maps_url" name="maps_url" type="url" value="{{ old('maps_url', $profile->maps_url) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
        </div>

        <div>
            <label for="vision" class="block text-xs font-semibold text-slate-700 mb-1.5">Visi Perusahaan</label>
            <textarea id="vision" name="vision" rows="2" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">{{ old('vision', $profile->vision) }}</textarea>
        </div>

        <div>
            <label for="missions" class="block text-xs font-semibold text-slate-700 mb-1.5">Misi Perusahaan (1 poin misi per baris)</label>
            @php($missionsText = is_array(old('missions')) ? implode("\n", old('missions')) : old('missions', implode("\n", $profile->missions ?? [])))
            <textarea id="missions" name="missions" rows="4" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">{{ $missionsText }}</textarea>
        </div>

        <div class="pt-3 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                <span>Simpan Profil Perusahaan</span>
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function bindPreview(inputId, previewId, placeholderId) {
        var input = document.getElementById(inputId);
        if (!input) return;
        input.addEventListener('change', function (e) {
            var file = e.target.files && e.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                var img = document.getElementById(previewId);
                var ph = placeholderId ? document.getElementById(placeholderId) : null;
                if (img && ev.target && ev.target.result) {
                    img.src = ev.target.result;
                    img.classList.remove('hidden');
                }
                if (ph) ph.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    }
    bindPreview('logo_file', 'preview-logo', 'placeholder-logo');
    bindPreview('hero_image_file', 'preview-hero', null);
    bindPreview('about_image_file', 'preview-about', null);
</script>
@endpush