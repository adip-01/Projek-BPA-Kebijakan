    <!DOCTYPE html>
    <html lang="id" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Dashboard') – SIMKA</title>

        {{-- Tailwind CSS CDN (ganti dengan Vite jika sudah setup) --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                50:  '#fdf2f2',
                                100: '#fce4e4',
                                200: '#f9c0c0',
                                500: '#b91c1c',
                                600: '#991b1b',
                                700: '#7f1d1d',
                                800: '#6b1313',
                                900: '#450a0a',
                            }
                        },
                        fontFamily: {
                            sans: ['Inter', 'system-ui', 'sans-serif']
                        }
                    }
                }
            }
        </script>

        {{-- Alpine.js --}}
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        {{-- Google Font Inter --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>

        <style>
            [x-cloak] { display: none !important; }

            /* Scrollbar custom */
            ::-webkit-scrollbar       { width: 5px; }
            ::-webkit-scrollbar-track { background: #f1f5f9; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

            /* Sidebar nav active */
            .nav-active {
                background: #7f1d1d !important;
                color: #ffffff !important;
            }
            .nav-active svg { color: #ffffff !important; }
            .nav-active .dot-indicator { display: inline-block; }

            .nav-item {
                transition: background .15s, color .15s;
            }
            .nav-item:hover:not(.nav-active) {
                background: #fdf2f2;
            }

            /* Modal animation */
            .modal-enter { animation: fadeSlide .2s ease forwards; }
            @keyframes fadeSlide {
                from { opacity:0; transform:scale(.96) translateY(8px); }
                to   { opacity:1; transform:scale(1) translateY(0); }
            }
        </style>
    </head>

    <body class="bg-gray-100 font-sans antialiased flex min-h-screen">

    {{-- ═══════════════════════════════
        SIDEBAR
    ═══════════════════════════════ --}}
    <aside class="w-56 min-h-screen bg-white border-r border-gray-200 flex flex-col flex-shrink-0 fixed left-0 top-0 bottom-0 z-30 overflow-y-auto">

        {{-- Brand --}}
        <div class="px-4 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-brand-800 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="leading-tight">
                <p class="text-sm font-bold text-gray-900">SIMKA</p>
                <p class="text-[10px] text-gray-400">Telkom University · SIMK</p>
            </div>
        </div>

        {{-- Profile card --}}
        <div class="px-3 py-3 border-b border-gray-100">
            <div class="flex items-center gap-2.5 bg-brand-800 rounded-xl px-3 py-2.5">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white text-sm font-bold">
                    A
                </div>
                <div class="leading-tight">
                    <p class="text-xs font-semibold text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-red-200">Admin SIMKEB</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-3 space-y-0.5">

            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 pt-2 pb-1">Menu Utama</p>

            <a href="{{ route('dashboard') }}"
            class="nav-item {{ request()->routeIs('dashboard') ? 'nav-active' : 'text-brand-700' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium relative">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
                <span class="dot-indicator hidden ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
            </a>

            <a href="{{ route('admins.index') }}"
            class="nav-item {{ request()->routeIs('admins.*') ? 'nav-active' : 'text-brand-700' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium relative">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Admin
                <span class="dot-indicator hidden ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
            </a>

            <a href="{{ route('bisnis-proses.index') }}"
   class="nav-item {{ request()->routeIs('bisnis-proses.*') ? 'nav-active' : 'text-brand-700' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium relative">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
    </svg>
    Bisnis Proses
    <span class="dot-indicator {{ request()->routeIs('bisnis-proses.*') ? 'inline-block' : 'hidden' }} ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
</a>

            <a href="{{ route('dokumen-unit.index') }}"
   class="nav-item {{ request()->routeIs('dokumen-unit.*') ? 'nav-active' : 'text-brand-700' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
    </svg>
    Tentang Dokumen Unit
    <span class="dot-indicator {{ request()->routeIs('dokumen-unit.*') ? 'inline-block' : 'hidden' }} ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
</a>

            <a href="{{ route('sasaran-mutu.index') }}"
   class="nav-item {{ request()->routeIs('sasaran-mutu.*') ? 'nav-active' : 'text-brand-700' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
    </svg>
    Sasaran Mutu
    <span class="dot-indicator {{ request()->routeIs('sasaran-mutu.*') ? 'inline-block' : 'hidden' }} ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
</a>

            <a href="{{ route('daftar-dokumen.index') }}"
   class="nav-item {{ request()->routeIs('daftar-dokumen.*') ? 'nav-active' : 'text-brand-700' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
    </svg>
    Daftar Dokumen
    <span class="dot-indicator {{ request()->routeIs('daftar-dokumen.*') ? 'inline-block' : 'hidden' }} ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
</a>

            <a href="{{ route('dokumen-spmi.index') }}"
   class="nav-item {{ request()->routeIs('dokumen-spmi.*') ? 'nav-active' : 'text-brand-700' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
    </svg>
    Dokumen SPMI
    <span class="dot-indicator {{ request()->routeIs('dokumen-spmi.*') ? 'inline-block' : 'hidden' }} ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
</a>

            <a href="{{ route('informasi-tambahan.index') }}"
   class="nav-item {{ request()->routeIs('informasi-tambahan.*') ? 'nav-active' : 'text-brand-700' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
    </svg>
    Informasi Tambahan
    <span class="dot-indicator {{ request()->routeIs('informasi-tambahan.*') ? 'inline-block' : 'hidden' }} ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
</a>

            {{-- PENGATURAN --}}
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 pt-4 pb-1">Pengaturan</p>

            <a href="#"
            class="nav-item text-brand-700 flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Data Akun
            </a>
        </nav>

        {{-- Footer sidebar --}}
        <div class="px-4 py-3 border-t border-gray-100">
            <p class="text-[10px] text-gray-400 text-center">SIMKEB v2.1.4 · © 2026 SIMKTel-U</p>
        </div>
    </aside>

    {{-- ═══════════════════════════════
        WRAPPER KANAN SIDEBAR
    ═══════════════════════════════ --}}
    <div class="ml-56 flex-1 flex flex-col min-h-screen">

        {{-- ── TOP HEADER ── --}}
        <header class="bg-white border-b border-gray-200 px-6 h-14 flex items-center justify-between sticky top-0 z-20">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm font-medium text-gray-700">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" stroke-linecap="round"/>
                    <rect x="14" y="3" width="7" height="7" rx="1" stroke-linecap="round"/>
                    <rect x="3" y="14" width="7" height="7" rx="1" stroke-linecap="round"/>
                    <rect x="14" y="14" width="7" height="7" rx="1" stroke-linecap="round"/>
                </svg>
                @yield('breadcrumb', 'Dashboard')
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">
                {{-- Bell --}}
                <button class="relative w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
                    <svg class="w-4.5 h-4.5 w-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                </button>

                {{-- Profile dropdown (Alpine) --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 transition text-sm font-medium text-gray-700">
                        <div class="w-6 h-6 rounded-md bg-brand-800 flex items-center justify-center text-white text-xs font-bold">A</div>
                        Admin
                        <svg class="w-3.5 h-3.5 text-gray-400 transition" :class="{'rotate-180': open}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak @click.outside="open = false"
                        class="absolute right-0 top-11 w-44 bg-white rounded-xl border border-gray-200 shadow-lg py-1 z-50">
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Dark mode toggle --}}
                <button @click="darkMode = !darkMode"
                    class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
                    <svg x-show="!darkMode" class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v1m0 16v1m8.66-9h-1M4.34 12h-1m15.07-6.07l-.71.71M6.34 17.66l-.71.71m0-12.02l.71.71M17.66 17.66l.71.71M12 7a5 5 0 100 10A5 5 0 0012 7z"/>
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                    </svg>
                </button>

                {{-- Toggle switch --}}
                <button @click="darkMode = !darkMode"
                    class="relative w-10 h-5 rounded-full transition-colors duration-300"
                    :class="darkMode ? 'bg-brand-700' : 'bg-gray-300'">
                    <span class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform duration-300"
                        :class="darkMode ? 'translate-x-5' : 'translate-x-0'"></span>
                </button>
            </div>
        </header>

        {{-- ── PAGE CONTENT ── --}}
        <main class="flex-1 bg-gray-50 p-8">
            @yield('content')
        </main>

    </div>

    </body>
    </html>