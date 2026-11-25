@extends('layouts.admin')

@section('title', 'Kelola Layanan & Ketentuan')
@section('page_title', 'Kelola Layanan & Ketentuan')

@section('content')
<div class="space-y-10">
    {{-- Bagian 1: Kelola Daftar Paket Layanan --}}
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Daftar Paket Layanan ({{ $services->count() }})</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tambah, ubah, atau hapus paket layanan yang tampil di Beranda dan halaman Layanan.</p>
            </div>
            <button type="button" id="open-create-service-btn" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors whitespace-nowrap shrink-0">
                <span>+ Tambah Layanan</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach ($services as $service)
                <div class="bg-white border border-slate-200 rounded-xl p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                    <x-service-icon :name="$service->icon" class="w-5 h-5" />
                                </span>
                                <div>
                                    <p class="text-xs font-medium text-slate-500">{{ $service->subtitle }} &middot; Urutan #{{ $service->sort_order }}</p>
                                    <h3 class="text-base font-bold text-slate-900">{{ $service->title }}</h3>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <button
                                    type="button"
                                    class="edit-service-btn px-2.5 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg"
                                    data-update-url="{{ route('admin.services.update', $service) }}"
                                    data-title="{{ $service->title }}"
                                    data-subtitle="{{ $service->subtitle }}"
                                    data-icon="{{ $service->icon }}"
                                    data-sort-order="{{ $service->sort_order }}"
                                    data-description="{{ $service->description }}"
                                    data-highlights="{{ implode("\n", $service->highlights ?? []) }}"
                                >
                                    Edit
                                </button>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Hapus paket layanan {{ addslashes($service->title) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg">Hapus</button>
                                </form>
                            </div>
                        </div>

                        <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $service->description }}</p>
                        <ul class="mt-3 space-y-1 text-xs text-slate-600 list-disc pl-4">
                            @foreach (($service->highlights ?? []) as $h)
                                <li>{{ $h }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Bagian 2: Editor Syarat & Ketentuan Umum Penyewaan --}}
    <form action="{{ route('admin.terms.update') }}" method="POST" class="bg-white border border-slate-200 rounded-2xl p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Syarat &amp; Ketentuan Umum Penyewaan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelompok &amp; poin di bawah ini langsung tampil pada halaman Layanan publik.</p>
            </div>
            <button type="button" id="add-term-group-btn" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors whitespace-nowrap shrink-0">
                <span>+ Tambah Kelompok Ketentuan</span>
            </button>
        </div>

        <div id="terms-groups-container" class="space-y-5">
            @foreach ($termsSections as $idx => $sec)
                <div class="term-group-card p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <span class="term-group-label text-xs font-bold text-slate-700">Kelompok Ketentuan #{{ $idx + 1 }}</span>
                        <button type="button" class="remove-term-group-btn text-xs font-semibold text-red-600 hover:text-red-700">Hapus Kelompok</button>
                    </div>
                    <input type="text" name="sections[{{ $idx }}][title]" required value="{{ $sec->title }}" class="term-title-input w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Daftar Poin Ketentuan (1 poin per baris)</label>
                        <textarea name="sections[{{ $idx }}][items]" rows="4" required class="term-items-input w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">{{ implode("\n", $sec->items ?? []) }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded-lg transition-colors">
                <span>Simpan Syarat &amp; Ketentuan</span>
            </button>
        </div>
    </form>
</div>

{{-- Modal Tambah / Edit Layanan --}}
<div id="service-modal" class="fixed inset-0 z-50 bg-slate-950/60 hidden items-center justify-center p-4 overflow-y-auto">
    <div role="dialog" aria-modal="true" class="bg-white rounded-2xl border border-slate-200 w-full max-w-xl max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 id="service-modal-title" class="text-base font-bold text-slate-900">Tambah Paket Layanan Baru</h2>
            <button type="button" id="close-service-modal" class="px-2 py-1 text-sm font-semibold text-slate-500 hover:text-slate-900">&times;</button>
        </div>

        <form id="service-modal-form" action="{{ route('admin.services.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="service-method-field" value="POST">

            <div>
                <label for="s-title" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Layanan</label>
                <input id="s-title" name="title" type="text" required placeholder="Contoh: Sewa Mobil Pernikahan (Wedding Car)" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="s-subtitle" class="block text-xs font-semibold text-slate-700 mb-1.5">Label Singkat</label>
                    <input id="s-subtitle" name="subtitle" type="text" required placeholder="Momen Spesial" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>
                <div>
                    <label for="s-icon" class="block text-xs font-semibold text-slate-700 mb-1.5">Ikon</label>
                    <select id="s-icon" name="icon" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                        @foreach ($allowedIcons as $iconName)
                            <option value="{{ $iconName }}">{{ $iconName }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="s-sort" class="block text-xs font-semibold text-slate-700 mb-1.5">Urutan Tampil</label>
                    <input id="s-sort" name="sort_order" type="number" min="0" value="{{ $services->count() + 1 }}" class="w-full px-3.5 py-2 text-sm font-mono border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>
            </div>

            <div>
                <label for="s-description" class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Layanan</label>
                <textarea id="s-description" name="description" rows="3" required class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"></textarea>
            </div>

            <div>
                <label for="s-highlights" class="block text-xs font-semibold text-slate-700 mb-1.5">Keunggulan &amp; Cakupan (1 poin per baris)</label>
                <textarea id="s-highlights" name="highlights" rows="4" required placeholder="Armada bersih &amp; dekorasi standar&#10;Pengemudi berseragam rapi&#10;Tersedia paket 12 jam atau Full Day" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"></textarea>
            </div>

            <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
                <button type="button" id="cancel-service-modal" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-lg">Batal</button>
                <button type="submit" id="submit-service-modal" class="px-5 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg">Tambahkan Layanan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('service-modal');
        var modalForm = document.getElementById('service-modal-form');
        var modalTitle = document.getElementById('service-modal-title');
        var methodField = document.getElementById('service-method-field');
        var submitBtn = document.getElementById('submit-service-modal');

        var fTitle = document.getElementById('s-title');
        var fSubtitle = document.getElementById('s-subtitle');
        var fIcon = document.getElementById('s-icon');
        var fSort = document.getElementById('s-sort');
        var fDesc = document.getElementById('s-description');
        var fHighlights = document.getElementById('s-highlights');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('open-create-service-btn')?.addEventListener('click', function () {
            modalForm.action = "{{ route('admin.services.store') }}";
            methodField.value = 'POST';
            modalTitle.textContent = 'Tambah Paket Layanan Baru';
            submitBtn.textContent = 'Tambahkan Layanan';
            fTitle.value = '';
            fSubtitle.value = '';
            fIcon.value = 'Car';
            fSort.value = '{{ $services->count() + 1 }}';
            fDesc.value = '';
            fHighlights.value = '';
            openModal();
        });

        document.querySelectorAll('.edit-service-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                modalForm.action = btn.dataset.updateUrl;
                methodField.value = 'PUT';
                modalTitle.textContent = 'Edit Paket Layanan';
                submitBtn.textContent = 'Simpan Perubahan';
                fTitle.value = btn.dataset.title || '';
                fSubtitle.value = btn.dataset.subtitle || '';
                fIcon.value = btn.dataset.icon || 'Car';
                fSort.value = btn.dataset.sortOrder || '1';
                fDesc.value = btn.dataset.description || '';
                fHighlights.value = btn.dataset.highlights || '';
                openModal();
            });
        });

        document.getElementById('close-service-modal')?.addEventListener('click', closeModal);
        document.getElementById('cancel-service-modal')?.addEventListener('click', closeModal);

        // Repeater Syarat & Ketentuan Umum
        var container = document.getElementById('terms-groups-container');
        var addTermBtn = document.getElementById('add-term-group-btn');

        function reindexTermGroups() {
            var cards = container.querySelectorAll('.term-group-card');
            cards.forEach(function (card, index) {
                card.querySelector('.term-group-label').textContent = 'Kelompok Ketentuan #' + (index + 1);
                card.querySelector('.term-title-input').setAttribute('name', 'sections[' + index + '][title]');
                card.querySelector('.term-items-input').setAttribute('name', 'sections[' + index + '][items]');
                var rmBtn = card.querySelector('.remove-term-group-btn');
                if (rmBtn) {
                    rmBtn.style.display = cards.length > 1 ? 'inline-block' : 'none';
                }
            });
        }

        container?.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-term-group-btn')) {
                var card = e.target.closest('.term-group-card');
                if (card && container.querySelectorAll('.term-group-card').length > 1) {
                    card.remove();
                    reindexTermGroups();
                }
            }
        });

        addTermBtn?.addEventListener('click', function () {
            var count = container.querySelectorAll('.term-group-card').length;
            var wrapper = document.createElement('div');
            wrapper.className = 'term-group-card p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3';
            wrapper.innerHTML =
                '<div class="flex items-center justify-between gap-3">' +
                    '<span class="term-group-label text-xs font-bold text-slate-700">Kelompok Ketentuan #' + (count + 1) + '</span>' +
                    '<button type="button" class="remove-term-group-btn text-xs font-semibold text-red-600 hover:text-red-700">Hapus Kelompok</button>' +
                '</div>' +
                '<input type="text" name="sections[' + count + '][title]" required value="' + (count + 1) + '. Ketentuan Tambahan" class="term-title-input w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">' +
                '<div>' +
                    '<label class="block text-xs font-semibold text-slate-600 mb-1">Daftar Poin Ketentuan (1 poin per baris)</label>' +
                    '<textarea name="sections[' + count + '][items]" rows="4" required placeholder="Masukkan poin ketentuan..." class="term-items-input w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"></textarea>' +
                '</div>';
            container.appendChild(wrapper);
            reindexTermGroups();
        });

        reindexTermGroups();
    });
</script>
@endpush