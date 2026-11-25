@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru')
@section('page_title', $isEdit ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru')

@section('content')
<div class="max-w-3xl bg-white border border-slate-200 rounded-2xl p-6 sm:p-8">
    <div class="flex items-center justify-between gap-4 pb-5 mb-6 border-b border-slate-200">
        <div>
            <h2 class="text-base font-extrabold text-slate-900">{{ $isEdit ? 'Ubah Data Unit: ' . $vehicle->name : 'Tambah Unit Kendaraan Baru' }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi spesifikasi, tarif sewa harian, dan foto kendaraan.</p>
        </div>
        <a href="{{ route('admin.vehicles.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>

    <form action="{{ $isEdit ? route('admin.vehicles.update', $vehicle) : route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Kendaraan</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $vehicle->name) }}" placeholder="Contoh: Toyota Avanza Veloz 1.5 Q" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category" class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                <input id="category" name="category" type="text" required value="{{ old('category', $vehicle->category) }}" placeholder="Contoh: MPV Keluarga / City Car" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="transmission" class="block text-xs font-semibold text-slate-700 mb-1.5">Transmisi</label>
                <select id="transmission" name="transmission" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                    <option value="Matic" @selected(old('transmission', $vehicle->transmission) === 'Matic')>Otomatis (Matic)</option>
                    <option value="Manual" @selected(old('transmission', $vehicle->transmission) === 'Manual')>Manual</option>
                </select>
                @error('transmission') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Ketersediaan</label>
                <select id="status" name="status" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                    <option value="tersedia" @selected(old('status', $vehicle->status) === 'tersedia')>Tersedia</option>
                    <option value="disewa" @selected(old('status', $vehicle->status) === 'disewa')>Sedang Disewa</option>
                </select>
                @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="seats" class="block text-xs font-semibold text-slate-700 mb-1.5">Kapasitas Kursi</label>
                <input id="seats" name="seats" type="number" min="2" max="60" required value="{{ old('seats', $vehicle->seats) }}" class="w-full px-3.5 py-2 text-sm font-mono border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('seats') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="year" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Unit</label>
                <input id="year" name="year" type="number" min="2005" max="2030" required value="{{ old('year', $vehicle->year) }}" class="w-full px-3.5 py-2 text-sm font-mono border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('year') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="price_per_day" class="block text-xs font-semibold text-slate-700 mb-1.5">Tarif Sewa Harian (Rp)</label>
                <input id="price_per_day" name="price_per_day" type="number" min="50000" step="5000" required value="{{ old('price_per_day', $vehicle->price_per_day) }}" class="w-full px-3.5 py-2 text-sm font-mono border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('price_per_day') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fuel" class="block text-xs font-semibold text-slate-700 mb-1.5">Bahan Bakar</label>
                <input id="fuel" name="fuel" type="text" value="{{ old('fuel', $vehicle->fuel) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>
        </div>

        <div>
            <label for="engine" class="block text-xs font-semibold text-slate-700 mb-1.5">Spesifikasi Mesin</label>
            <input id="engine" name="engine" type="text" value="{{ old('engine', $vehicle->engine) }}" placeholder="Contoh: 1.5L Dual VVT-i CVT" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
        </div>

        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
            <label for="image" class="block text-xs font-semibold text-slate-700">Foto Kendaraan (Upload File JPG/PNG/WebP, maks 5 MB)</label>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <img id="vehicle-image-preview" src="{{ asset(ltrim($vehicle->image_url ?: '/images/car-avanza-veloz.jpg', '/')) }}" alt="Preview Foto Mobil" class="w-36 h-24 rounded-lg object-cover border border-slate-200 bg-white">
                <div class="flex-1 w-full space-y-2">
                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    <input name="image_url" type="hidden" value="{{ old('image_url', $vehicle->image_url) }}">
                    @error('image') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div>
            <label for="description" class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Unit</label>
            <textarea id="description" name="description" rows="3" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">{{ old('description', $vehicle->description) }}</textarea>
        </div>

        <div>
            <label for="features" class="block text-xs font-semibold text-slate-700 mb-1.5">Fasilitas &amp; Keunggulan (1 poin per baris)</label>
            @php($featuresText = is_array(old('features')) ? implode("\n", old('features')) : old('features', implode("\n", $vehicle->features ?? [])))
            <textarea id="features" name="features" rows="4" placeholder="AC Double Blower&#10;Kamera 360 &amp; Sensor Parkir&#10;Kabin Bersih &amp; Bebas Asap Rokok" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">{{ $featuresText }}</textarea>
        </div>

        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
            <input type="checkbox" name="featured" value="1" @checked(old('featured', $vehicle->featured)) class="rounded border-slate-300 text-red-600 focus:ring-red-600">
            <span>Tampilkan sebagai Kendaraan Unggulan di Beranda</span>
        </label>

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.vehicles.index') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-lg">Batal</a>
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg">
                {{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Kendaraan' }}
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
            var img = document.getElementById('vehicle-image-preview');
            if (img && ev.target && ev.target.result) img.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush