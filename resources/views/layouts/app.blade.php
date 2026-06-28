<!DOCTYPE html>
<html lang="id" class="bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMKEB | @yield('title', 'Sistem Manajemen Kebijakan')</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'red': {
                            50:  '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        }
                    }
                }
            }
        }
    </script>

    {{-- Lucide Icons via CDN --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link-active { background-color: #fef2f2; color: #991b1b; font-weight: 600; }
        .sidebar-link        { color: #374151; }
        .sidebar-link:hover  { background-color: #f9fafb; }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

@php
    $user          = auth()->user();
    $pendingCount  = \App\Models\User::where('status', 'Pending')->count();
    $totalNotif    = $pendingCount; // bisa ditambah notifikasi lain ke depannya
@endphp

<div class="flex min-h-screen bg-gray-50">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 bg-white border-r border-gray-200 sticky top-0 h-screen overflow-y-auto flex-shrink-0">
        <div class="p-6">
            {{-- Logo --}}
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-red-800 rounded-lg flex items-center justify-center">
                    <i data-lucide="folder-cog" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg text-gray-900">SIMKEB</h1>
                    <p class="text-xs text-gray-500">Manajemen Dokumen</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="space-y-1">
                @php
                    $navLinks = [
                        ['route' => 'dashboard',          'icon' => 'bar-chart-3', 'label' => 'Dashboard'],
                        ['route' => 'dokumen.index',       'icon' => 'file-text',   'label' => 'Dokumen'],
                        ['route' => 'proses-bisnis.index', 'icon' => 'workflow',    'label' => 'Proses Bisnis'],
                        ['route' => 'admin.index',         'icon' => 'folder-cog',  'label' => 'Admin'],
                    ];
                @endphp

                @foreach($navLinks as $nav)
                    @php $isActive = request()->routeIs($nav['route']); @endphp
                    <a href="{{ route($nav['route']) }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ $isActive ? 'sidebar-link-active' : 'sidebar-link' }}">
                        <i data-lucide="{{ $nav['icon'] }}" class="w-5 h-5"></i>
                        <span>{{ $nav['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>
    </aside>

    {{-- ===== MAIN AREA ===== --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- ===== HEADER ===== --}}
        <header class="sticky top-0 z-40 border-b border-gray-200 bg-white">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-4">
                    <button class="rounded-lg p-2 hover:bg-gray-100 lg:hidden">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-900">Sistem Manajemen Dokumen</h2>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Notifications --}}
                    <div class="relative">
                        <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                                class="relative rounded-lg p-2 hover:bg-gray-100">
                            <i data-lucide="bell" class="w-5 h-5 text-gray-600"></i>
                            @if($totalNotif > 0)
                                <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-800"></span>
                            @endif
                        </button>
                        {{-- Notification Dropdown --}}
                        <div class="hidden absolute right-0 mt-2 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg z-50">
                            <div class="border-b border-gray-100 px-4 py-3 flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900 text-sm">Notifikasi</h3>
                                @if($totalNotif > 0)
                                    <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-800">
                                        {{ $totalNotif }} baru
                                    </span>
                                @endif
                            </div>
                            <div class="divide-y divide-gray-100">
                                @if($pendingCount > 0)
                                    <a href="{{ route('admin.index') }}"
                                       class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50">
                                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                                            <i data-lucide="user-check" class="h-4 w-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $pendingCount }} permintaan admin menunggu persetujuan
                                            </p>
                                            <p class="text-xs text-gray-500">Klik untuk lihat daftar admin</p>
                                        </div>
                                    </a>
                                @else
                                    <div class="px-4 py-6 text-center text-sm text-gray-500">
                                        Tidak ada notifikasi baru
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Profile --}}
                    <div class="relative">
                        <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                                class="flex items-center gap-2 rounded-lg p-2 hover:bg-gray-100">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-800 text-xs font-bold text-white">
                                {{ $user->initials() }}
                            </div>
                            <div class="text-sm text-left hidden sm:block">
                                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->role }}</p>
                            </div>
                        </button>
                        {{-- Profile Dropdown --}}
                        <div class="hidden absolute right-0 mt-2 w-56 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg z-50">
                            <div class="border-b border-gray-100 px-4 py-3">
                                <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->role }}</p>
                            </div>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                <i data-lucide="settings" class="w-4 h-4"></i>
                                <span>Pengaturan Akun</span>
                            </a>
                            <div class="border-t border-gray-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ===== CONTENT ===== --}}
        <main class="flex-1">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div id="flash-success"
                     class="mx-6 mt-4 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <i data-lucide="check-circle" class="h-5 w-5 shrink-0 text-green-600"></i>
                    <span>{{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-green-600 hover:text-green-800">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="flash-error"
                     class="mx-6 mt-4 flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <i data-lucide="alert-circle" class="h-5 w-5 shrink-0 text-red-600"></i>
                    <span>{{ session('error') }}</span>
                    <button onclick="document.getElementById('flash-error').remove()" class="ml-auto text-red-600 hover:text-red-800">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- Init Lucide Icons --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        // Auto-hide flash messages after 4 seconds
        setTimeout(() => {
            document.getElementById('flash-success')?.remove();
            document.getElementById('flash-error')?.remove();
        }, 4000);
    });
</script>

@stack('scripts')
</body>
</html>
