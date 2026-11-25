@extends('layouts.admin')

@section('title', 'Akun Administrator')
@section('page_title', 'Akun Administrator')

@section('content')
<div class="max-w-2xl bg-white border border-slate-200 rounded-2xl p-6 sm:p-8">
    <h2 class="text-base font-extrabold text-slate-900 pb-4 mb-6 border-b border-slate-200">Pengaturan Akun &amp; Keamanan Administrator</h2>

    <form action="{{ route('admin.account.update') }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Administrator</label>
            <input id="name" name="name" type="text" required value="{{ old('name', $admin->name) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email Login</label>
            <input id="email" name="email" type="email" required value="{{ old('email', $admin->email) }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-5 border-t border-slate-200 space-y-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Ganti Kata Sandi (Opsional)</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kosongkan kolom di bawah ini jika tidak ingin mengubah kata sandi saat ini.</p>
            </div>

            <div>
                <label for="current_password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('current_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="new_password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Baru (Min. 8 karakter)</label>
                    <input id="new_password" name="new_password" type="password" minlength="8" autocomplete="new-password" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                    @error('new_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                    <input id="new_password_confirmation" name="new_password_confirmation" type="password" minlength="8" autocomplete="new-password" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 flex justify-end">
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                Simpan Pengaturan Akun
            </button>
        </div>
    </form>
</div>
@endsection