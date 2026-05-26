@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dasbord')

@section('content')

<div class="mb-6">
    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Daftar Dokumen Kebijakan</h1>
    <p class="text-gray-500 mt-1 text-sm">Kelola seluruh dokumen kebijakan akademik Anda di sini.</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-4 gap-5 mb-6">
    @php
        $stats = [
            ['label'=>'PROSEDUR',        'value'=>'00', 'color'=>'text-red-500',   'bg'=>'bg-red-50'],
            ['label'=>'INSTRUKSI KERJA', 'value'=>'00', 'color'=>'text-blue-500',  'bg'=>'bg-blue-50'],
            ['label'=>'FORMULIR SMPI',   'value'=>'00', 'color'=>'text-green-500', 'bg'=>'bg-green-50'],
            ['label'=>'DOKUMEN INTERNAL','value'=>'00', 'color'=>'text-amber-500', 'bg'=>'bg-amber-50'],
        ];
    @endphp

    @foreach($stats as $s)
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl {{ $s['bg'] }} flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 {{ $s['color'] }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">{{ $s['label'] }}</p>
            <p class="text-3xl font-extrabold text-gray-900">{{ $s['value'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Action bar --}}
<div class="flex items-center gap-3 mb-4">
    <div class="relative flex-1 max-w-xs">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" placeholder="Cari Nama Kebijakan..."
            class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 placeholder-gray-400"/>
    </div>
    <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
        Filter
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 8h10M11 12h2M9 16h6"/>
        </svg>
    </button>
    <div class="flex-1"></div>
    <a href="{{ route('admins.index') }}"
        class="flex items-center gap-2 bg-brand-800 hover:bg-brand-900 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        TAMBAH DOKUMEN
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="px-5 py-3 border-b border-gray-100">
        <p class="text-sm text-gray-600">Menampilkan <span class="font-semibold">4</span> dari <span class="font-semibold">24</span> dokumen</p>
    </div>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-5 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Nama / Judul Dokumen</th>
                <th class="text-left px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Jenis Dokumen</th>
                <th class="text-left px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Diunggah</th>
                <th class="text-center px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @php
                $docs = [
                    ['name'=>'Dokumen','size'=>'2.4 MB','type'=>'KERJA',   'color'=>'bg-blue-50 text-blue-600',  'icon'=>'text-blue-500',  'date'=>'20 Jul 2026'],
                    ['name'=>'Dokumen','size'=>'1.8 MB','type'=>'SMPI',    'color'=>'bg-green-50 text-green-600','icon'=>'text-green-500', 'date'=>'17 April 2024'],
                    ['name'=>'Dokumen','size'=>'1 MB',  'type'=>'INTERNAL','color'=>'bg-amber-50 text-amber-600','icon'=>'text-amber-500', 'date'=>'1 April 2000'],
                    ['name'=>'Dokumen','size'=>'2 MB',  'type'=>'PROSEDUR','color'=>'bg-red-50 text-red-600',   'icon'=>'text-red-500',   'date'=>'23 Mei 2003'],
                ];
            @endphp
            @foreach($docs as $doc)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 {{ $doc['icon'] }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $doc['name'] }}</p>
                            <p class="text-xs text-gray-400">PDF · {{ $doc['size'] }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3.5">
                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wide {{ $doc['color'] }}">
                        {{ $doc['type'] }}
                    </span>
                </td>
                <td class="px-4 py-3.5 text-gray-600 text-xs">{{ $doc['date'] }}</td>
                <td class="px-4 py-3.5">
                    <div class="flex items-center justify-center gap-2">
                        <button class="px-3.5 py-1.5 text-xs font-semibold text-blue-600 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 transition">Edit</button>
                        <button class="px-3.5 py-1.5 text-xs font-semibold text-red-600 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition">Hapus</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-xs text-gray-500">Halaman <span class="font-semibold">1</span> dari <span class="font-semibold">6</span></p>
        <div class="flex items-center gap-1">
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-400 text-sm flex items-center justify-center">‹</button>
            <button class="w-8 h-8 rounded-lg bg-brand-800 text-white text-xs font-bold flex items-center justify-center">1</button>
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-600 text-xs flex items-center justify-center hover:bg-gray-50">2</button>
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-600 text-xs flex items-center justify-center hover:bg-gray-50">3</button>
            <span class="px-1 text-gray-400 text-xs">...</span>
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-600 text-xs flex items-center justify-center hover:bg-gray-50">6</button>
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-600 text-sm flex items-center justify-center hover:bg-gray-50">›</button>
        </div>
    </div>
</div>

@endsection