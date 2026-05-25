@extends('layouts.admin-base')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Main Container -->
<div class="flex min-h-screen bg-slate-900">
    
    <!-- ===== SIDEBAR KIRI (FIXED) ===== -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-slate-800 border-r border-slate-700 flex flex-col overflow-y-auto">
        
        <!-- Header Sidebar -->
        <div class="p-4 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <!-- Logo SIMKA -->
                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('assets/icons/logo-simka.png') }}" alt="SIMKA" class="w-6 h-6">
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wider">SIMKA</p>
                    <p class="text-xs text-slate-300 font-medium">Telkom University</p>
                </div>
            </div>
        </div>

        <!-- Card Profil Admin -->
        <div class="p-4">
            <div class="bg-emerald-600 rounded-lg p-4 flex items-center gap-3 cursor-pointer hover:bg-emerald-700 transition">
                <div class="w-12 h-12 bg-emerald-700 rounded-lg flex items-center justify-center font-bold text-white text-lg">
                    A
                </div>
                <div>
                    <p class="font-semibold text-white text-sm">Admin</p>
                    <p class="text-emerald-100 text-xs">Admin SIMKEB</p>
                </div>
            </div>
        </div>

        <!-- Menu Utama -->
        <div class="px-4 py-2">
            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-3">Menu Utama</p>
            
            <!-- Dashboard (Active) -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-emerald-600 text-white mb-2 transition hover:bg-emerald-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4"></path>
                </svg>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <!-- Admin -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700 transition mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                </svg>
                <span class="text-sm font-medium">Admin</span>
            </a>
        </div>

        <!-- Pengaturan -->
        <div class="px-4 py-2 mt-4">
            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-3">Pengaturan</p>
            
            <!-- Data Akun -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="text-sm font-medium">Data Akun</span>
            </a>
        </div>

        <!-- Logout -->
        <div class="p-4 mt-auto border-t border-slate-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-slate-300 hover:bg-slate-700 transition text-sm font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT AREA ===== -->
    <main class="flex-1 ml-64 flex flex-col">
        
        <!-- ===== TOP NAVBAR ===== -->
        <nav class="bg-slate-800 border-b border-slate-700 sticky top-0 z-40">
            <div class="px-6 py-4 flex items-center justify-between">
                <!-- Left: Page Title -->
                <h1 class="text-slate-300 font-medium text-sm uppercase tracking-wider">Dashboard</h1>

                <!-- Right: Icons & Controls -->
                <div class="flex items-center gap-6">
                    <!-- Notification Bell -->
                    <button class="relative text-slate-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Divider -->
                    <div class="w-px h-6 bg-slate-700"></div>

                    <!-- Profile Dropdown -->
                    <div class="flex items-center gap-3 cursor-pointer group">
                        <div class="flex items-center justify-center w-8 h-8 bg-emerald-600 rounded-lg">
                            <span class="text-white font-bold text-sm">A</span>
                        </div>
                        <span class="text-slate-300 text-sm font-medium group-hover:text-white transition">Admin</span>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>

                    <!-- Dark/Light Toggle -->
                    <button class="relative inline-flex h-7 w-14 items-center rounded-full bg-slate-700 transition hover:bg-slate-600">
                        <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-lg transition absolute right-1"></span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- ===== CONTENT ===== -->
        <div class="flex-1 overflow-y-auto bg-slate-900">
            <div class="p-8">
                
                <!-- Page Title Section -->
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-white mb-2">Daftar Dokumen Kebijakan</h2>
                    <p class="text-slate-400 text-base">Kelola seluruh dokumen kebijakan akademik Anda di sini.</p>
                </div>

                <!-- ===== STATISTICS CARDS ===== -->
                <div class="grid grid-cols-4 gap-6 mb-8">
                    <!-- Total Dokumen -->
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 flex items-start gap-4">
                        <div class="w-14 h-14 bg-red-600 bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16H3v-2h10v2zm0-4H3v-2h10v2zm0-4H3V6h10v2zm8-2v8h4V6h-4zm2 6h-2v2h2v-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider font-semibold">Total Dokumen</p>
                            <p class="text-3xl font-bold text-white">{{ $statistics['total_dokumen'] }}</p>
                        </div>
                    </div>

                    <!-- Dokumen Magang -->
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 flex items-start gap-4">
                        <div class="w-14 h-14 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider font-semibold">Dokumen Magang</p>
                            <p class="text-3xl font-bold text-white">{{ $statistics['dokumen_magang'] }}</p>
                        </div>
                    </div>

                    <!-- Dokumen IISMA -->
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 flex items-start gap-4">
                        <div class="w-14 h-14 bg-emerald-600 bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider font-semibold">Dokumen IISMA</p>
                            <p class="text-3xl font-bold text-white">{{ $statistics['dokumen_iisma'] }}</p>
                        </div>
                    </div>

                    <!-- Dokumen SIMKA -->
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 flex items-start gap-4">
                        <div class="w-14 h-14 bg-amber-600 bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider font-semibold">Dokumen SIMKA</p>
                            <p class="text-3xl font-bold text-white">{{ $statistics['dokumen_simka'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- ===== ACTION BAR (Search, Filter, Add Button) ===== -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input 
                            type="text" 
                            placeholder="Cari Nama Kebijakan..." 
                            class="w-full pl-10 pr-4 py-3 bg-white text-slate-900 placeholder-slate-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm"
                        >
                    </div>

                    <button class="px-4 py-3 bg-slate-800 border border-slate-700 text-slate-300 rounded-lg hover:bg-slate-700 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span class="text-sm font-medium">Filter</span>
                    </button>

                    <button class="px-5 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition flex items-center gap-2 font-semibold text-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                        </svg>
                        <span>TAMBAH DOKUMEN</span>
                    </button>
                </div>

                <!-- ===== DOCUMENTS TABLE ===== -->
                <div class="bg-slate-800 border border-slate-700 rounded-lg overflow-hidden">
                    <!-- Table showing 4 of 24 documents -->
                    <div class="text-slate-400 text-xs px-6 py-3 border-b border-slate-700">
                        Menampilkan 4 dari 24 dokumen
                    </div>

                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-700 bg-slate-900 bg-opacity-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama / Judul Dokumen</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-emerald-500 uppercase tracking-wider">Jenis Dokumen</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal Diunggah</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            <tr class="border-b border-slate-700 hover:bg-slate-700 bg-opacity-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-white font-medium text-sm">{{ $document['name'] }}</p>
                                            <p class="text-slate-500 text-xs">PDF • {{ $document['file_size'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($document['type'] === 'Magang')
                                        <span class="px-3 py-1 bg-blue-600 bg-opacity-30 text-blue-400 text-xs font-semibold rounded">{{ $document['type'] }}</span>
                                    @elseif($document['type'] === 'IISMA')
                                        <span class="px-3 py-1 bg-emerald-600 bg-opacity-30 text-emerald-400 text-xs font-semibold rounded">{{ $document['type'] }}</span>
                                    @elseif($document['type'] === 'SIMKA')
                                        <span class="px-3 py-1 bg-amber-600 bg-opacity-30 text-amber-400 text-xs font-semibold rounded">{{ $document['type'] }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-slate-300 text-sm">{{ $document['date_uploaded'] }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button class="px-4 py-2 bg-white text-slate-900 text-sm font-semibold rounded hover:bg-slate-100 transition">
                                            Edit
                                        </button>
                                        <button class="px-4 py-2 border-2 border-red-500 text-red-500 text-sm font-semibold rounded hover:bg-red-600 hover:text-white transition">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-slate-700 flex items-center justify-end gap-2">
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-slate-700 text-slate-300 text-sm hover:bg-slate-600 transition">&larr;</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-emerald-600 text-white text-sm font-semibold">1</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-slate-700 text-slate-300 text-sm hover:bg-slate-600 transition">2</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-slate-700 text-slate-300 text-sm hover:bg-slate-600 transition">3</button>
                        <span class="text-slate-400 text-sm">...</span>
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-slate-700 text-slate-300 text-sm hover:bg-slate-600 transition">6</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-slate-700 text-slate-300 text-sm hover:bg-slate-600 transition">&rarr;</button>
                    </div>
                </div>

                <!-- Version Info -->
                <div class="text-center text-slate-500 text-xs mt-6">
                    SIMKEB v2.1.4 • © 2026 SIMK Tel-U
                </div>

            </div>
        </div>

    </main>

</div>

<style>
    /* Smooth scrollbar styling */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }
</style>
@endsection