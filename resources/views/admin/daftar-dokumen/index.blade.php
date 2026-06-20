@extends('layouts.admin')

@section('title', 'Daftar Dokumen')
@section('breadcrumb', 'Daftar Dokumen')

@section('content')
<div x-data="daftarDokumenAdmin()">

    {{-- ══ FLASH ALERT ══ --}}
    <div x-show="alert.show" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        :class="alert.type === 'success'
            ? 'bg-green-50 border-green-200 text-green-800'
            : 'bg-red-50 border-red-200 text-red-800'"
        class="mb-5 flex items-center gap-3 border text-sm px-4 py-3 rounded-xl">
        <svg x-show="alert.type === 'success'"
            class="w-4 h-4 text-green-500 flex-shrink-0"
            fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0
                   00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414
                   1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <svg x-show="alert.type === 'error'" x-cloak
            class="w-4 h-4 text-red-500 flex-shrink-0"
            fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0
                   00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414
                   1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414
                   L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10
                   8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <span x-text="alert.message"></span>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 1: PAGE HEADER
    ══════════════════════════════════════════ --}}
    <div class="mb-6">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
            Daftar Dokumen
        </h1>
        <p class="text-gray-500 mt-1 text-sm">
            Kelola seluruh dokumen kebijakan akademik Anda di sini.
        </p>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 2: ACTION BAR
    ══════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center
                gap-3 mb-4">

        {{-- Search --}}
        <div class="relative w-full sm:w-72">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4
                        text-gray-400" fill="none" stroke="currentColor"
                stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchInput"
                placeholder="Cari Nama Kebijakan..."
                class="w-full pl-9 pr-4 py-2 text-sm bg-white border
                       border-gray-200 rounded-xl focus:outline-none
                       focus:ring-2 focus:ring-brand-200
                       focus:border-brand-500 transition
                       placeholder-gray-400"/>
        </div>

        {{-- Filter --}}
        <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium
                       text-gray-600 bg-white border border-gray-200
                       rounded-xl hover:bg-gray-50 transition">
            Filter
            <svg class="w-4 h-4 text-gray-400" fill="none"
                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 4h18M7 8h10M11 12h2M9 16h6"/>
            </svg>
        </button>

        <div class="flex-1"></div>

        {{-- Tambah Dokumen --}}
        <button @click="openTambah()"
            class="flex items-center gap-2 bg-brand-800 hover:bg-brand-900
                   text-white text-sm font-semibold px-5 py-2 rounded-xl
                   shadow-sm transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4v16m8-8H4"/>
            </svg>
             TAMBAH DOKUMEN
        </button>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 3: TABEL (10 KOLOM, SCROLLABLE)
    ══════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm
                overflow-hidden">

        {{-- Info count --}}
        <div class="px-5 py-3 border-b border-gray-100">
            <p class="text-sm text-gray-600">
                Menampilkan
                <span class="font-semibold">{{ $dokumens->count() }}</span>
                dari
                <span class="font-semibold">{{ $dokumens->total() }}</span>
                dokumen
            </p>
        </div>

        {{-- Scroll wrapper --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm whitespace-nowrap">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[110px]">
                            Standard
                        </th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[100px]">
                            Klasul
                        </th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[130px]">
                            Jenis Dokumen
                        </th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[200px]">
                            Nama / Judul Dokumen
                        </th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[130px]">
                            Pemilik Dokumen
                        </th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[130px]">
                            Data Pendukung
                        </th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[120px]">
                            Link Aplikasi
                        </th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[130px]">
                            Revisi Dokumen
                        </th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[140px]">
                            Tanggal Efektif
                        </th>
                        <th class="text-center px-4 py-3 text-[10px] font-bold
                                   text-gray-400 uppercase tracking-wider
                                   min-w-[100px] sticky right-0 bg-gray-50
                                   border-l border-gray-100">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50" id="dokumenTableBody">

                    @forelse($dokumens as $dok)
                    @php
                        $jenisBadge = [
                            'KERJA'    => 'bg-blue-100 text-blue-700',
                            'SMPI'     => 'bg-green-100 text-green-700',
                            'INTERNAL' => 'bg-amber-100 text-amber-700',
                            'PROSEDUR' => 'bg-red-100 text-red-700',
                        ];
                        $badgeClass = $jenisBadge[strtoupper($dok->jenis_dokumen ?? '')]
                            ?? 'bg-gray-100 text-gray-700';

                        $iconColors = [
                            'KERJA'    => 'text-blue-500 bg-blue-50',
                            'SMPI'     => 'text-green-500 bg-green-50',
                            'INTERNAL' => 'text-amber-500 bg-amber-50',
                            'PROSEDUR' => 'text-red-500 bg-red-50',
                        ];
                        $iconClass = $iconColors[strtoupper($dok->jenis_dokumen ?? '')]
                            ?? 'text-gray-400 bg-gray-50';
                    @endphp

                    <tr class="hover:bg-gray-50 transition-colors dokumen-row"
                        data-nama="{{ strtolower($dok->nama_dokumen ?? '') }}">

                        {{-- Standard --}}
                        <td class="px-4 py-3.5 text-gray-700 text-xs">
                            {{ $dok->standard ?? '—' }}
                        </td>

                        {{-- Klasul --}}
                        <td class="px-4 py-3.5 text-gray-700 text-xs">
                            {{ $dok->klasul ?? '—' }}
                        </td>

                        {{-- Jenis Dokumen — badge --}}
                        <td class="px-4 py-3.5">
                            @if($dok->jenis_dokumen)
                            <span class="inline-flex items-center px-2.5 py-1
                                         rounded-md text-[10px] font-bold
                                         uppercase tracking-wide
                                         {{ $badgeClass }}">
                                {{ strtoupper($dok->jenis_dokumen) }}
                            </span>
                            @else
                            <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>

                        {{-- Nama / Judul Dokumen --}}
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg {{ $iconClass }}
                                            flex items-center justify-center
                                            flex-shrink-0">
                                    <svg class="w-3.5 h-3.5"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2
                                                 0 002 2h12a2 2 0 002-2V8l-6
                                                 -6zm-1 1.5L18.5 9H13V3.5zM6
                                                 20V4h5v7h7v9H6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-xs">
                                        {{ $dok->nama_dokumen ?? 'Dokumen' }}
                                    </p>
                                    @if($dok->path_dokumen)
                                    <p class="text-[10px] text-gray-400 mt-0.5">
                                        PDF ·
                                        @php
                                            try {
                                                echo number_format(
                                                    Storage::disk('public')
                                                        ->size($dok->path_dokumen)
                                                    / 1048576, 1) . ' MB';
                                            } catch(\Exception $e) {
                                                echo '—';
                                            }
                                        @endphp
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Pemilik Dokumen --}}
                        <td class="px-4 py-3.5 text-gray-600 text-xs">
                            {{ $dok->pemilik_dokumen ?? '—' }}
                        </td>

                        {{-- Data Pendukung --}}
                        <td class="px-4 py-3.5 text-gray-600 text-xs">
                            {{ $dok->data_pendukung ?? '—' }}
                        </td>

                        {{-- Link Aplikasi --}}
                        <td class="px-4 py-3.5">
                            @if($dok->link_aplikasi)
                            <a href="{{ $dok->link_aplikasi }}" target="_blank"
                                class="text-xs text-brand-700 hover:underline
                                       truncate max-w-[100px] block">
                                {{ $dok->link_aplikasi }}
                            </a>
                            @else
                            <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>

                        {{-- Revisi Dokumen --}}
                        <td class="px-4 py-3.5 text-gray-600 text-xs">
                            {{ $dok->revisi_dokumen ?? '—' }}
                        </td>

                        {{-- Tanggal Efektif --}}
                        <td class="px-4 py-3.5 text-gray-600 text-xs">
                            @if($dok->tanggal_efektif)
                                {{ \Carbon\Carbon::parse($dok->tanggal_efektif)
                                    ->translatedFormat('j F Y') }}
                            @else
                                —
                            @endif
                        </td>

                        {{-- Aksi — sticky kanan --}}
                        <td class="px-4 py-3.5 sticky right-0 bg-white
                                   border-l border-gray-100
                                   group-hover:bg-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    @click="openEdit(
                                        {{ $dok->id }},
                                        @js($dok->standard ?? ''),
                                        @js($dok->klasul ?? ''),
                                        @js($dok->jenis_dokumen ?? 'Jenis 1'),
                                        @js($dok->nama_dokumen ?? ''),
                                        @js($dok->pemilik_dokumen ?? ''),
                                        @js($dok->data_pendukung ?? ''),
                                        @js($dok->link_aplikasi ?? ''),
                                        @js($dok->revisi_dokumen ?? ''),
                                        @js($dok->tanggal_efektif ?? '')
                                    )"
                                    class="px-3 py-1.5 text-xs font-semibold
                                           text-blue-600 bg-white border
                                           border-gray-200 rounded-lg
                                           hover:bg-blue-50
                                           hover:border-blue-200 transition">
                                    Edit
                                </button>
                                <button
                                    @click="openHapus(
                                        {{ $dok->id }},
                                        @js($dok->nama_dokumen ?? '')
                                    )"
                                    class="px-3 py-1.5 text-xs font-semibold
                                           text-red-600 bg-red-50 border
                                           border-red-100 rounded-lg
                                           hover:bg-red-100 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="10"
                            class="px-5 py-14 text-center text-sm
                                   text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-gray-300"
                                    fill="none" stroke="currentColor"
                                    stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0
                                           01-2-2V5a2 2 0 012-2h5.586a1 1
                                           0 01.707.293l5.414 5.414A1 1 0
                                           0119 9.414V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="font-medium">
                                    Belum ada dokumen.
                                
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-gray-100
                    flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Halaman
                <span class="font-semibold">
                    {{ $dokumens->currentPage() }}
                </span>
                dari
                <span class="font-semibold">
                    {{ $dokumens->lastPage() }}
                </span>
            </p>
            <div class="flex items-center gap-1">

                @if($dokumens->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center
                                 text-gray-300 text-sm">‹</span>
                @else
                    <a href="{{ $dokumens->previousPageUrl() }}"
                        class="w-8 h-8 flex items-center justify-center
                               rounded-lg border border-gray-200 text-gray-600
                               hover:bg-gray-50 text-sm transition">‹</a>
                @endif

                @foreach($dokumens->getUrlRange(1, $dokumens->lastPage())
                    as $page => $url)
                    @if($page == $dokumens->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center
                                     rounded-lg bg-brand-800 text-white
                                     text-xs font-bold">
                            {{ $page }}
                        </span>
                    @elseif(
                        $page == 1 ||
                        $page == $dokumens->lastPage() ||
                        abs($page - $dokumens->currentPage()) <= 1
                    )
                        <a href="{{ $url }}"
                            class="w-8 h-8 flex items-center justify-center
                                   rounded-lg border border-gray-200
                                   text-gray-600 hover:bg-gray-50
                                   text-xs transition">
                            {{ $page }}
                        </a>
                    @elseif(abs($page - $dokumens->currentPage()) == 2)
                        <span class="px-1 text-gray-400 text-xs">...</span>
                    @endif
                @endforeach

                @if($dokumens->hasMorePages())
                    <a href="{{ $dokumens->nextPageUrl() }}"
                        class="w-8 h-8 flex items-center justify-center
                               rounded-lg border border-gray-200 text-gray-600
                               hover:bg-gray-50 text-sm transition">›</a>
                @else
                    <span class="w-8 h-8 flex items-center justify-center
                                 text-gray-300 text-sm">›</span>
                @endif

            </div>
        </div>

    </div>{{-- end table card --}}


    {{-- ══════════════════════════════════════════
         MODAL 1: TAMBAH DOKUMEN BARU
    ══════════════════════════════════════════ --}}
    <div x-show="showTambah" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"
             @click="showTambah = false"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg
                    z-10 flex flex-col max-h-[90vh]"
            x-show="showTambah"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            {{-- Header sticky --}}
            <div class="flex items-center justify-between px-6 pt-6 pb-4
                        border-b border-gray-100 flex-shrink-0">
                <h2 class="text-lg font-bold text-gray-900">
                    Tambah Dokumen Baru
                </h2>
                <button @click="showTambah = false"
                    class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center
                           justify-center text-gray-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                        stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Scrollable body --}}
            <div class="overflow-y-auto flex-1 px-6 py-4 space-y-4">

                {{-- Error bag --}}
                <template x-if="tambahForm.errors.length > 0">
                    <div class="bg-red-50 border border-red-200 rounded-xl
                                px-4 py-3">
                        <ul class="space-y-1">
                            <template x-for="err in tambahForm.errors"
                                :key="err">
                                <li class="text-xs text-red-700 flex
                                           items-start gap-2">
                                    <svg class="w-3.5 h-3.5 mt-0.5
                                               flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000
                                               16zM8.707 7.293a1 1 0 00-1.414
                                               1.414L8.586 10l-1.293 1.293a1 1
                                               0 101.414 1.414L10 11.414l1.293
                                               1.293a1 1 0 001.414-1.414
                                               L11.414 10l1.293-1.293a1 1 0
                                               00-1.414-1.414L10 8.586
                                               8.707 7.293z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="err"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

                {{-- Standard --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Standard
                    </label>
                    <input type="text" x-model="tambahForm.standard"
                        placeholder="Standard"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Klasul --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Klasul
                    </label>
                    <input type="text" x-model="tambahForm.klasul"
                        placeholder="Klasul"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Jenis Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Jenis Dokumen <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="tambahForm.jenis_dokumen"
                            class="w-full px-3.5 py-2.5 text-sm border
                                   border-gray-300 rounded-xl focus:outline-none
                                   focus:ring-2 focus:ring-brand-200
                                   focus:border-brand-500 bg-white
                                   appearance-none text-gray-700 transition">
                            <option value="Jenis 1">Jenis 1</option>
                            <option value="Jenis 2">Jenis 2</option>
                            <option value="Jenis 3">Jenis 3</option>
                            <option value="PROSEDUR">PROSEDUR</option>
                            <option value="KERJA">KERJA</option>
                            <option value="SMPI">SMPI</option>
                            <option value="INTERNAL">INTERNAL</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2
                                    w-4 h-4 text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Nama Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Nama Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="tambahForm.nama_dokumen"
                        placeholder="Nama Dokumen"
                        class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                               focus:outline-none focus:ring-2
                               focus:ring-brand-200 focus:border-brand-500
                               transition placeholder-gray-400"
                        :class="tambahForm.fieldErrors.nama_dokumen
                            ? 'border-red-400' : 'border-gray-300'"/>
                    <p x-show="tambahForm.fieldErrors.nama_dokumen"
                       x-text="tambahForm.fieldErrors.nama_dokumen"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Pemilik Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Pemilik Dokumen
                    </label>
                    <input type="text" x-model="tambahForm.pemilik_dokumen"
                        placeholder="Pemilik Dokumen"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Data Pendukung --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Data Pendukung
                    </label>
                    <input type="text" x-model="tambahForm.data_pendukung"
                        placeholder="Data Pendukung"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Link Aplikasi --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Link Aplikasi
                    </label>
                    <input type="url" x-model="tambahForm.link_aplikasi"
                        placeholder="Link Aplikasi"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Revisi Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Revisi Dokumen
                    </label>
                    <input type="text" x-model="tambahForm.revisi_dokumen"
                        placeholder="Revisi Dokumen"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Tanggal Efektif --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Tanggal Efektif Dokumen
                    </label>
                    <input type="date" x-model="tambahForm.tanggal_efektif"
                        placeholder="Tanggal Efektif Dokumen"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               text-gray-700"/>
                </div>

                {{-- Unggah Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Unggah Dokumen
                        <span class="font-normal text-gray-400">
                            (PDF, maks 10MB)
                        </span>
                    </label>

                    <label x-show="!tambahForm.namaFile"
                        class="flex flex-col items-center justify-center gap-2
                               w-full py-8 border-2 border-dashed rounded-xl
                               cursor-pointer hover:border-brand-400
                               hover:bg-brand-50/30 transition group"
                        :class="tambahForm.fieldErrors.file_dokumen
                            ? 'border-red-400 bg-red-50/20'
                            : 'border-gray-300'"
                        @dragover.prevent
                        @drop.prevent="
                            const f = $event.dataTransfer.files[0];
                            if (f) {
                                tambahForm.file    = f;
                                tambahForm.namaFile = f.name;
                                tambahForm.fieldErrors.file_dokumen = '';
                            }
                        ">
                        <svg class="w-12 h-12 text-gray-300
                                    group-hover:text-gray-400 transition"
                            fill="none" viewBox="0 0 56 56">
                            <rect x="8" y="4" width="28" height="40" rx="3"
                                stroke="currentColor" stroke-width="2.5"
                                fill="none"/>
                            <path d="M30 4v14h14" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"
                                fill="none"/>
                            <path d="M22 34l6-6 6 6" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round"/>
                            <path d="M28 28v10" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        <span class="text-sm text-gray-500">
                            Tarik &amp; Lepas File Disini
                        </span>
                        <span class="px-4 py-1.5 text-xs font-medium
                                     text-gray-700 bg-white border
                                     border-gray-300 rounded-lg
                                     hover:bg-gray-50 transition">
                            Pilih File Lokal
                        </span>
                        <span class="text-xs text-gray-400">File Max 10MB</span>
                        <input type="file" accept=".pdf" class="hidden"
                            @change="
                                const f = $event.target.files[0];
                                if (f) {
                                    tambahForm.file    = f;
                                    tambahForm.namaFile = f.name;
                                    tambahForm.fieldErrors.file_dokumen = '';
                                }
                            "/>
                    </label>

                    <div x-show="tambahForm.namaFile"
                        class="flex items-center gap-3 px-4 py-3 bg-red-50
                               border border-red-100 rounded-xl">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12
                                     a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13
                                     V3.5zM6 20V4h5v7h7v9H6z"/>
                        </svg>
                        <span class="text-xs text-gray-700 truncate flex-1"
                              x-text="tambahForm.namaFile"></span>
                        <button type="button"
                            @click="tambahForm.file = null;
                                    tambahForm.namaFile = ''"
                            class="text-gray-400 hover:text-red-500
                                   font-bold transition">✕</button>
                    </div>
                    <p x-show="tambahForm.fieldErrors.file_dokumen"
                       x-text="tambahForm.fieldErrors.file_dokumen"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

            </div>{{-- end scrollable body --}}

            {{-- Footer sticky --}}
            <div class="px-6 py-4 flex items-center justify-end gap-3
                        border-t border-gray-100 flex-shrink-0">
                <button type="button" @click="showTambah = false"
                    class="px-5 py-2.5 text-sm font-bold text-gray-700
                           bg-white border-2 border-gray-300 rounded-xl
                           hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="button" @click="submitTambah()"
                    :disabled="tambahForm.loading"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm
                           font-bold text-white bg-brand-800 hover:bg-brand-900
                           rounded-xl shadow-sm transition uppercase
                           tracking-wide disabled:opacity-60
                           disabled:cursor-not-allowed">
                    <svg x-show="tambahForm.loading" x-cloak
                        class="w-4 h-4 animate-spin" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    <span x-text="tambahForm.loading
                        ? 'Menyimpan...' : 'TAMBAH DOKUMEN'"></span>
                </button>
            </div>

        </div>
    </div>


    {{-- ══════════════════════════════════════════
         MODAL 2: EDIT DOKUMEN
    ══════════════════════════════════════════ --}}
    <div x-show="showEdit" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"
             @click="showEdit = false"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg
                    z-10 flex flex-col max-h-[90vh]"
            x-show="showEdit"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            <div class="flex items-center justify-between px-6 pt-6 pb-4
                        border-b border-gray-100 flex-shrink-0">
                <h2 class="text-lg font-bold text-gray-900">Edit Dokumen</h2>
                <button @click="showEdit = false"
                    class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center
                           justify-center text-gray-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                        stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto flex-1 px-6 py-4 space-y-4">

                {{-- Error bag --}}
                <template x-if="editForm.errors.length > 0">
                    <div class="bg-red-50 border border-red-200 rounded-xl
                                px-4 py-3">
                        <ul class="space-y-1">
                            <template x-for="err in editForm.errors" :key="err">
                                <li class="text-xs text-red-700 flex
                                           items-start gap-2">
                                    <svg class="w-3.5 h-3.5 mt-0.5
                                               flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000
                                               16zM8.707 7.293a1 1 0 00-1.414
                                               1.414L8.586 10l-1.293 1.293a1 1
                                               0 101.414 1.414L10 11.414l1.293
                                               1.293a1 1 0 001.414-1.414
                                               L11.414 10l1.293-1.293a1 1 0
                                               00-1.414-1.414L10 8.586
                                               8.707 7.293z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="err"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

                {{-- Standard --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">Standard</label>
                    <input type="text" x-model="editForm.standard"
                        placeholder="Standard"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Klasul --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">Klasul</label>
                    <input type="text" x-model="editForm.klasul"
                        placeholder="Klasul"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Jenis Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Jenis Dokumen <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="editForm.jenis_dokumen"
                            class="w-full px-3.5 py-2.5 text-sm border
                                   border-gray-300 rounded-xl focus:outline-none
                                   focus:ring-2 focus:ring-brand-200
                                   focus:border-brand-500 bg-white
                                   appearance-none text-gray-700 transition">
                            <option value="Jenis 1">Jenis 1</option>
                            <option value="Jenis 2">Jenis 2</option>
                            <option value="Jenis 3">Jenis 3</option>
                            <option value="PROSEDUR">PROSEDUR</option>
                            <option value="KERJA">KERJA</option>
                            <option value="SMPI">SMPI</option>
                            <option value="INTERNAL">INTERNAL</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2
                                    w-4 h-4 text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Nama Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Nama Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="editForm.nama_dokumen"
                        placeholder="Nama Dokumen"
                        class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                               focus:outline-none focus:ring-2
                               focus:ring-brand-200 focus:border-brand-500
                               transition placeholder-gray-400"
                        :class="editForm.fieldErrors.nama_dokumen
                            ? 'border-red-400' : 'border-gray-300'"/>
                    <p x-show="editForm.fieldErrors.nama_dokumen"
                       x-text="editForm.fieldErrors.nama_dokumen"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Pemilik Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">Pemilik Dokumen</label>
                    <input type="text" x-model="editForm.pemilik_dokumen"
                        placeholder="Pemilik Dokumen"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Data Pendukung --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">Data Pendukung</label>
                    <input type="text" x-model="editForm.data_pendukung"
                        placeholder="Data Pendukung"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Link Aplikasi --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">Link Aplikasi</label>
                    <input type="url" x-model="editForm.link_aplikasi"
                        placeholder="Link Aplikasi"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Revisi Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">Revisi Dokumen</label>
                    <input type="text" x-model="editForm.revisi_dokumen"
                        placeholder="Revisi Dokumen"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition
                               placeholder-gray-400"/>
                </div>

                {{-- Tanggal Efektif --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">Tanggal Efektif Dokumen</label>
                    <input type="date" x-model="editForm.tanggal_efektif"
                        class="w-full px-3.5 py-2.5 text-sm border
                               border-gray-300 rounded-xl focus:outline-none
                               focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition text-gray-700"/>
                </div>

                {{-- Upload --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Unggah Dokumen
                        <span class="font-normal text-gray-400">
                            (kosongkan jika tidak ingin mengganti)
                        </span>
                    </label>

                    <label x-show="!editForm.namaFile"
                        class="flex flex-col items-center justify-center gap-2
                               w-full py-8 border-2 border-dashed
                               border-gray-300 rounded-xl cursor-pointer
                               hover:border-brand-400 hover:bg-brand-50/30
                               transition group"
                        @dragover.prevent
                        @drop.prevent="
                            const f = $event.dataTransfer.files[0];
                            if (f) {
                                editForm.file    = f;
                                editForm.namaFile = f.name;
                            }
                        ">
                        <svg class="w-12 h-12 text-gray-300
                                    group-hover:text-gray-400 transition"
                            fill="none" viewBox="0 0 56 56">
                            <rect x="8" y="4" width="28" height="40" rx="3"
                                stroke="currentColor" stroke-width="2.5"
                                fill="none"/>
                            <path d="M30 4v14h14" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"
                                fill="none"/>
                            <path d="M22 34l6-6 6 6" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round"/>
                            <path d="M28 28v10" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        <span class="text-sm text-gray-500">
                            Tarik &amp; Lepas File Disini
                        </span>
                        <span class="px-4 py-1.5 text-xs font-medium
                                     text-gray-700 bg-white border
                                     border-gray-300 rounded-lg
                                     hover:bg-gray-50 transition">
                            Pilih File Lokal
                        </span>
                        <span class="text-xs text-gray-400">File Max 10MB</span>
                        <input type="file" accept=".pdf" class="hidden"
                            @change="
                                const f = $event.target.files[0];
                                if (f) {
                                    editForm.file    = f;
                                    editForm.namaFile = f.name;
                                }
                            "/>
                    </label>

                    <div x-show="editForm.namaFile"
                        class="flex items-center gap-3 px-4 py-3 bg-red-50
                               border border-red-100 rounded-xl">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12
                                     a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13
                                     V3.5zM6 20V4h5v7h7v9H6z"/>
                        </svg>
                        <span class="text-xs text-gray-700 truncate flex-1"
                              x-text="editForm.namaFile"></span>
                        <button type="button"
                            @click="editForm.file = null;
                                    editForm.namaFile = ''"
                            class="text-gray-400 hover:text-red-500
                                   font-bold transition">✕</button>
                    </div>
                </div>

            </div>{{-- end scrollable body --}}

            <div class="px-6 py-4 flex items-center justify-end gap-3
                        border-t border-gray-100 flex-shrink-0">
                <button type="button" @click="showEdit = false"
                    class="px-5 py-2.5 text-sm font-bold text-gray-700
                           bg-white border-2 border-gray-300 rounded-xl
                           hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="button" @click="submitEdit()"
                    :disabled="editForm.loading"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm
                           font-bold text-white bg-brand-800 hover:bg-brand-900
                           rounded-xl shadow-sm transition uppercase
                           tracking-wide disabled:opacity-60
                           disabled:cursor-not-allowed">
                    <svg x-show="editForm.loading" x-cloak
                        class="w-4 h-4 animate-spin" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    <span x-text="editForm.loading
                        ? 'Menyimpan...' : 'EDIT DOKUMEN'"></span>
                </button>
            </div>

        </div>
    </div>


    {{-- ══════════════════════════════════════════
         MODAL 3: KONFIRMASI HAPUS
    ══════════════════════════════════════════ --}}
    <div x-show="showHapus" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"
             @click="showHapus = false"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm
                    z-10 text-center"
            x-show="showHapus"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            <div class="px-8 py-8">
                <p class="text-lg font-semibold text-gray-800 mb-6">
                    Anda yakin ingin menghapus dokumen ?
                </p>

                <template x-if="hapusForm.error">
                    <div class="mb-4 bg-red-50 border border-red-200
                                text-red-700 text-xs px-3 py-2 rounded-lg
                                text-left">
                        <span x-text="hapusForm.error"></span>
                    </div>
                </template>

                <div class="flex items-center justify-center gap-3">
                    <button type="button" @click="showHapus = false"
                        class="flex-1 py-2.5 text-sm font-bold text-gray-700
                               bg-white border-2 border-gray-300 rounded-xl
                               hover:bg-gray-50 transition uppercase
                               tracking-wide">
                        BATAL
                    </button>
                    <button type="button" @click="submitHapus()"
                        :disabled="hapusForm.loading"
                        class="flex-1 flex items-center justify-center gap-2
                               py-2.5 text-sm font-bold text-white
                               bg-brand-800 hover:bg-brand-900 rounded-xl
                               shadow-sm transition uppercase tracking-wide
                               disabled:opacity-60 disabled:cursor-not-allowed">
                        <svg x-show="hapusForm.loading" x-cloak
                            class="w-4 h-4 animate-spin" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        <span x-text="hapusForm.loading
                            ? 'Menghapus...' : 'KONFIRMASI'"></span>
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>{{-- end x-data --}}

<script>
function daftarDokumenAdmin() {
    return {

        // ════════════════════════════════
        // STATE
        // ════════════════════════════════

        alert: {
            show:    false,
            type:    'success',
            message: ''
        },

        showTambah: false,
        showEdit:   false,
        showHapus:  false,

        tambahForm: {
            standard:        '',
            klasul:          '',
            jenis_dokumen:   'Jenis 1',
            nama_dokumen:    '',
            pemilik_dokumen: '',
            data_pendukung:  '',
            link_aplikasi:   '',
            revisi_dokumen:  '',
            tanggal_efektif: '',
            file:            null,
            namaFile:        '',
            loading:         false,
            errors:          [],
            fieldErrors:     {}
        },

        editForm: {
            id:              null,
            standard:        '',
            klasul:          '',
            jenis_dokumen:   'Jenis 1',
            nama_dokumen:    '',
            pemilik_dokumen: '',
            data_pendukung:  '',
            link_aplikasi:   '',
            revisi_dokumen:  '',
            tanggal_efektif: '',
            file:            null,
            namaFile:        '',
            loading:         false,
            errors:          [],
            fieldErrors:     {}
        },

        hapusForm: {
            id:      null,
            nama:    '',
            loading: false,
            error:   ''
        },

        // ════════════════════════════════
        // HELPERS
        // ════════════════════════════════

        showAlertMsg(type, message) {
            this.alert = { show: true, type, message };
            setTimeout(() => { this.alert.show = false; }, 4000);
        },

        async parseErrors(response) {
            const errors      = [];
            const fieldErrors = {};
            try {
                const json = await response.json();
                if (response.status === 422 && json.errors) {
                    for (const [field, msgs] of Object.entries(json.errors)) {
                        msgs.forEach(m => errors.push(m));
                        fieldErrors[field] = msgs[0];
                    }
                } else if (json.message) {
                    errors.push(json.message);
                } else {
                    errors.push('Terjadi kesalahan yang tidak diketahui.');
                }
            } catch (_) {
                errors.push('Gagal membaca respons dari server.');
            }
            return { errors, fieldErrors };
        },

        resetTambahForm() {
            this.tambahForm = {
                standard:        '',
                klasul:          '',
                jenis_dokumen:   'Jenis 1',
                nama_dokumen:    '',
                pemilik_dokumen: '',
                data_pendukung:  '',
                link_aplikasi:   '',
                revisi_dokumen:  '',
                tanggal_efektif: '',
                file:            null,
                namaFile:        '',
                loading:         false,
                errors:          [],
                fieldErrors:     {}
            };
        },

        resetEditForm() {
            this.editForm = {
                id:              null,
                standard:        '',
                klasul:          '',
                jenis_dokumen:   'Jenis 1',
                nama_dokumen:    '',
                pemilik_dokumen: '',
                data_pendukung:  '',
                link_aplikasi:   '',
                revisi_dokumen:  '',
                tanggal_efektif: '',
                file:            null,
                namaFile:        '',
                loading:         false,
                errors:          [],
                fieldErrors:     {}
            };
        },

        // ════════════════════════════════
        // OPEN HANDLERS
        // ════════════════════════════════

        openTambah() {
            this.resetTambahForm();
            this.showTambah = true;
        },

        openEdit(
            id, standard, klasul, jenisDokumen,
            namaDokumen, pemilikDokumen, dataPendukung,
            linkAplikasi, revisiDokumen, tanggalEfektif
        ) {
            this.resetEditForm();
            this.editForm.id              = id;
            this.editForm.standard        = standard       || '';
            this.editForm.klasul          = klasul         || '';
            this.editForm.jenis_dokumen   = jenisDokumen   || 'Jenis 1';
            this.editForm.nama_dokumen    = namaDokumen    || '';
            this.editForm.pemilik_dokumen = pemilikDokumen || '';
            this.editForm.data_pendukung  = dataPendukung  || '';
            this.editForm.link_aplikasi   = linkAplikasi   || '';
            this.editForm.revisi_dokumen  = revisiDokumen  || '';
            this.editForm.tanggal_efektif = tanggalEfektif || '';
            this.showEdit = true;
        },

        openHapus(id, nama) {
            this.hapusForm = {
                id,
                nama,
                loading: false,
                error:   ''
            };
            this.showHapus = true;
        },

        // ════════════════════════════════
        // SUBMIT: TAMBAH
        // ════════════════════════════════

        async submitTambah() {
            if (this.tambahForm.loading) return;

            // Validasi client-side minimal
            if (!this.tambahForm.nama_dokumen.trim()) {
                this.tambahForm.errors      = ['Nama dokumen wajib diisi.'];
                this.tambahForm.fieldErrors = {
                    nama_dokumen: 'Nama dokumen wajib diisi.'
                };
                return;
            }

            this.tambahForm.loading     = true;
            this.tambahForm.errors      = [];
            this.tambahForm.fieldErrors = {};

            const fd = new FormData();
            fd.append('_token',          '{{ csrf_token() }}');
            fd.append('standard',        this.tambahForm.standard);
            fd.append('klasul',          this.tambahForm.klasul);
            fd.append('jenis_dokumen',   this.tambahForm.jenis_dokumen);
            fd.append('nama_dokumen',    this.tambahForm.nama_dokumen.trim());
            fd.append('pemilik_dokumen', this.tambahForm.pemilik_dokumen);
            fd.append('data_pendukung',  this.tambahForm.data_pendukung);
            fd.append('link_aplikasi',   this.tambahForm.link_aplikasi);
            fd.append('revisi_dokumen',  this.tambahForm.revisi_dokumen);
            fd.append('tanggal_efektif', this.tambahForm.tanggal_efektif);
            if (this.tambahForm.file) {
                fd.append('file_dokumen', this.tambahForm.file);
            }

            try {
                const res = await fetch(
                    '{{ route("daftar-dokumen.store") }}',
                    { method: 'POST', body: fd }
                );

                if (res.ok) {
                    const json = await res.json();
                    this.showTambah = false;
                    this.showAlertMsg(
                        'success',
                        json.message || 'Dokumen berhasil ditambahkan.'
                    );
                    setTimeout(() => location.reload(), 900);
                } else {
                    const { errors, fieldErrors } = await this.parseErrors(res);
                    this.tambahForm.errors      = errors;
                    this.tambahForm.fieldErrors = fieldErrors;
                }

            } catch (_) {
                this.tambahForm.errors = [
                    'Gagal terhubung ke server. Periksa koneksi Anda.'
                ];
            } finally {
                this.tambahForm.loading = false;
            }
        },

        // ════════════════════════════════
        // SUBMIT: EDIT
        // ════════════════════════════════

        async submitEdit() {
            if (this.editForm.loading) return;

            if (!this.editForm.id) {
                this.editForm.errors = ['ID dokumen tidak valid.'];
                return;
            }

            if (!this.editForm.nama_dokumen.trim()) {
                this.editForm.errors      = ['Nama dokumen wajib diisi.'];
                this.editForm.fieldErrors = {
                    nama_dokumen: 'Nama dokumen wajib diisi.'
                };
                return;
            }

            this.editForm.loading     = true;
            this.editForm.errors      = [];
            this.editForm.fieldErrors = {};

            const fd = new FormData();
            fd.append('_token',          '{{ csrf_token() }}');
            fd.append('_method',         'POST');
            fd.append('standard',        this.editForm.standard);
            fd.append('klasul',          this.editForm.klasul);
            fd.append('jenis_dokumen',   this.editForm.jenis_dokumen);
            fd.append('nama_dokumen',    this.editForm.nama_dokumen.trim());
            fd.append('pemilik_dokumen', this.editForm.pemilik_dokumen);
            fd.append('data_pendukung',  this.editForm.data_pendukung);
            fd.append('link_aplikasi',   this.editForm.link_aplikasi);
            fd.append('revisi_dokumen',  this.editForm.revisi_dokumen);
            fd.append('tanggal_efektif', this.editForm.tanggal_efektif);
            if (this.editForm.file) {
                fd.append('file_dokumen', this.editForm.file);
            }

            try {
                const url =
                    `{{ url('dashboard/daftar-dokumen') }}/${this.editForm.id}`;
                const res = await fetch(url, { method: 'POST', body: fd });

                if (res.ok) {
                    const json = await res.json();
                    this.showEdit = false;
                    this.showAlertMsg(
                        'success',
                        json.message || 'Dokumen berhasil diperbarui.'
                    );
                    setTimeout(() => location.reload(), 900);
                } else {
                    const { errors, fieldErrors } = await this.parseErrors(res);
                    this.editForm.errors      = errors;
                    this.editForm.fieldErrors = fieldErrors;
                }

            } catch (_) {
                this.editForm.errors = [
                    'Gagal terhubung ke server. Periksa koneksi Anda.'
                ];
            } finally {
                this.editForm.loading = false;
            }
        },

        // ════════════════════════════════
        // SUBMIT: HAPUS
        // ════════════════════════════════

        async submitHapus() {
            if (this.hapusForm.loading) return;

            if (!this.hapusForm.id) {
                this.hapusForm.error = 'ID dokumen tidak valid.';
                return;
            }

            this.hapusForm.loading = true;
            this.hapusForm.error   = '';

            try {
                const url =
                    `{{ url('dashboard/daftar-dokumen') }}/${this.hapusForm.id}`;
                const res = await fetch(url, {
                    method:  'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept':       'application/json'
                    }
                });

                if (res.ok) {
                    const json = await res.json();
                    this.showHapus = false;
                    this.showAlertMsg(
                        'success',
                        json.message || 'Dokumen berhasil dihapus.'
                    );
                    setTimeout(() => location.reload(), 900);
                } else {
                    const { errors } = await this.parseErrors(res);
                    this.hapusForm.error =
                        errors[0] || 'Gagal menghapus dokumen.';
                }

            } catch (_) {
                this.hapusForm.error =
                    'Gagal terhubung ke server. Periksa koneksi Anda.';
            } finally {
                this.hapusForm.loading = false;
            }
        },

        // ════════════════════════════════
        // INIT
        // ════════════════════════════════

        init() {
            // Client-side live search
            const input = document.getElementById('searchInput');
            if (input) {
                input.addEventListener('input', function () {
                    const kw   = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.dokumen-row');
                    rows.forEach(row => {
                        const nama = row.dataset.nama || '';
                        row.style.display =
                            nama.includes(kw) ? '' : 'none';
                    });
                });
            }

            // ESC untuk menutup modal
            document.addEventListener('keydown', (e) => {
                if (e.key !== 'Escape') return;
                if (this.showTambah) { this.showTambah = false; return; }
                if (this.showEdit)   { this.showEdit   = false; return; }
                if (this.showHapus)  { this.showHapus  = false; }
            });
        }

    };
}
</script>
@endsection