<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Login Administrator — {{ $profile?->company_name ?? 'CV. Merah Putih' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[#0B1120] font-sans antialiased flex flex-col items-center justify-center p-4 sm:p-6">
    <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 p-7 sm:p-8 shadow-xl">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-11 h-11 rounded-xl bg-red-600 text-white flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
                </svg>
            </span>
            <div>
                <h1 class="text-lg font-extrabold text-slate-900">Login Administrator</h1>
                <p class="text-xs text-slate-500">Panel Pengelolaan Website {{ $profile?->company_name ?? 'CV. Merah Putih' }}</p>
            </div>
        </div>

        @if (session('success'))
            <div role="status" class="mb-5 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-xs font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-xs font-medium text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div role="alert" class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-xs font-medium text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email Administrator</label>
                <input id="email" name="email" type="email" required value="{{ old('email', 'admin@merahputih.co.id') }}" autocomplete="username" class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Masukkan kata sandi administrator" class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-600">
                <span>Ingat sesi masuk di browser ini</span>
            </label>

            <button type="submit" class="w-full py-2.5 px-4 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900">
                &larr; Kembali ke Halaman Publik Website
            </a>
        </div>
    </div>
</body>
</html>