@php
    $adminProfile = $profile ?? \App\Models\CompanyProfile::query()->first();
    $adminUser = \Illuminate\Support\Facades\Auth::user();
    $totalVehiclesCount = \App\Models\Vehicle::query()->count();
    $totalArticlesCount = \App\Models\Article::query()->count();
    $totalServicesCount = \App\Models\Service::query()->count();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin Panel') — {{ $adminProfile?->company_name ?? 'CV. Merah Putih' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', ui-monospace, SFMono-Regular, monospace;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 font-sans antialiased flex">

    {{-- Backdrop Sidebar Mobile --}}
    <div id="admin-sidebar-backdrop" class="fixed inset-0 z-40 bg-slate-950/60 hidden lg:hidden"></div>

    {{-- Sidebar Kiri Obsidian --}}
    <aside id="admin-sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-[#0B1120] text-slate-200 flex flex-col justify-between -translate-x-full lg:translate-x-0 transition-transform duration-200 shrink-0">
        <div>
            <div class="p-5 border-b border-slate-800/80 flex items-center justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-9 h-9 rounded-lg bg-red-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-extrabold text-white truncate">Admin Panel</p>
                        <p class="text-xs text-slate-400 truncate">{{ $adminProfile?->company_name ?? 'CV. Merah Putih' }}</p>
                    </div>
                </div>
                <button type="button" id="admin-sidebar-close" aria-label="Tutup menu admin" class="lg:hidden p-1.5 text-slate-400 hover:text-white rounded-lg">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            <nav aria-label="Menu Admin CMS" class="p-3.5 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <span class="flex items-center gap-2.5 truncate">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        <span>Dashboard</span>
                    </span>
                </a>

                <a href="{{ route('admin.vehicles.index') }}" class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.vehicles.*') ? 'bg-red-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <span class="flex items-center gap-2.5 truncate">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                        <span>Kelola Kendaraan</span>
                    </span>
                    <span class="text-xs font-mono tabular-nums px-1.5 py-0.5 rounded {{ request()->routeIs('admin.vehicles.*') ? 'bg-red-700 text-white' : 'bg-slate-800 text-slate-400' }}">{{ $totalVehiclesCount }}</span>
                </a>

                <a href="{{ route('admin.articles.index') }}" class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-red-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <span class="flex items-center gap-2.5 truncate">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                        <span>Kelola Artikel/Blog</span>
                    </span>
                    <span class="text-xs font-mono tabular-nums px-1.5 py-0.5 rounded {{ request()->routeIs('admin.articles.*') ? 'bg-red-700 text-white' : 'bg-slate-800 text-slate-400' }}">{{ $totalArticlesCount }}</span>
                </a>

                <a href="{{ route('admin.services.index') }}" class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-red-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <span class="flex items-center gap-2.5 truncate">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"/><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"/></svg>
                        <span>Kelola Layanan</span>
                    </span>
                    <span class="text-xs font-mono tabular-nums px-1.5 py-0.5 rounded {{ request()->routeIs('admin.services.*') ? 'bg-red-700 text-white' : 'bg-slate-800 text-slate-400' }}">{{ $totalServicesCount }}</span>
                </a>

                <a href="{{ route('admin.profile.edit') }}" class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-red-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <span class="flex items-center gap-2.5 truncate">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg>
                        <span>Profil Perusahaan</span>
                    </span>
                </a>

                <a href="{{ route('admin.account.edit') }}" class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.account.*') ? 'bg-red-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <span class="flex items-center gap-2.5 truncate">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
                        <span>Akun Administrator</span>
                    </span>
                </a>
            </nav>
        </div>

        <div class="p-3.5 border-t border-slate-800/80 space-y-1.5">
            <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center gap-2.5 px-3.5 py-2.5 rounded-lg text-xs font-semibold text-slate-200 bg-slate-800/70 hover:bg-slate-800 transition-colors">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                <span>Lihat Website Publik</span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2.5 rounded-lg text-xs font-semibold text-red-400 hover:bg-red-950/50 hover:text-red-300 transition-colors">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    <span>Logout Administrator</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Area Konten Utama --}}
    <div class="flex-1 min-w-0 flex flex-col">
        <header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <button type="button" id="admin-sidebar-open" aria-label="Buka menu navigasi admin" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
                    </svg>
                </button>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-red-600 tracking-wide">Sistem Manajemen Konten (CMS)</p>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 truncate">@yield('page_title', 'Dashboard')</h1>
                </div>
            </div>

            @if ($adminUser)
                <div class="hidden sm:flex items-center gap-3 pl-3 pr-4 py-2 rounded-xl border border-slate-200 bg-slate-50/70 shrink-0">
                    <span class="w-8 h-8 rounded-full bg-red-100 text-red-700 text-xs font-bold flex items-center justify-center">
                        {{ strtoupper(mb_substr($adminUser->name, 0, 1)) }}
                    </span>
                    <div class="leading-tight">
                        <p class="text-xs font-bold text-slate-900">{{ $adminUser->name }}</p>
                        <p class="text-[11px] text-slate-500">{{ $adminUser->email }}</p>
                    </div>
                </div>
            @endif
        </header>

        <main class="flex-1 p-4 sm:p-8 max-w-6xl w-full mx-auto">
            {{-- Flash Message Sukses / Error & Validation Summary --}}
            @if (session('success'))
                <div role="status" class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm font-medium text-emerald-800 flex items-center justify-between gap-3">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div role="alert" class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm font-medium text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-800">
                    <p class="font-bold mb-1">Periksa kembali isian formulir Anda:</p>
                    <ul class="list-disc pl-5 space-y-0.5 text-xs">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('admin-sidebar');
            var backdrop = document.getElementById('admin-sidebar-backdrop');
            var openBtn = document.getElementById('admin-sidebar-open');
            var closeBtn = document.getElementById('admin-sidebar-close');

            function openSidebar() {
                if (sidebar) sidebar.classList.remove('-translate-x-full');
                if (backdrop) backdrop.classList.remove('hidden');
            }
            function closeSidebar() {
                if (sidebar) sidebar.classList.add('-translate-x-full');
                if (backdrop) backdrop.classList.add('hidden');
            }

            if (openBtn) openBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>
    @stack('scripts')
</body>
</html>