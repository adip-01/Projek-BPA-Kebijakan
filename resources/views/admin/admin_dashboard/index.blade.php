@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dasbord')

@section('content')
<div x-data="dashboardAdmin()">

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
            Daftar Dokumen Kebijakan
        </h1>
        <p class="text-gray-500 mt-1 text-sm">
            Kelola seluruh dokumen kebijakan akademik Anda di sini.
        </p>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 2: STAT CARDS (BPA 1–4)
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        {{-- BPA 1 — Merah --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm
                    px-5 py-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center
                        justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0
                             002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6
                             20V4h5v7h7v9H6z"/>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase
                          tracking-wider">BPA 1</p>
                <p class="text-3xl font-extrabold text-gray-900 leading-tight">
                    {{ str_pad($countBpa1 ?? 0, 2, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </div>

        {{-- BPA 2 — Biru --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm
                    px-5 py-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center
                        justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0
                             002-2V9a2 2 0 00-2-2zm0 12H4V9h16v10zM16 1H8v2h8V1z"/>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase
                          tracking-wider">BPA 2</p>
                <p class="text-3xl font-extrabold text-gray-900 leading-tight">
                    {{ str_pad($countBpa2 ?? 0, 2, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </div>

        {{-- BPA 3 — Hijau --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm
                    px-5 py-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center
                        justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-500" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0
                             001.946-.806 3.42 3.42 0 014.438 0 3.42
                             3.42 0 001.946.806 3.42 3.42 0 013.138
                             3.138 3.42 3.42 0 00.806 1.946 3.42 3.42
                             0 010 4.438 3.42 3.42 0 00-.806 1.946
                             3.42 3.42 0 01-3.138 3.138 3.42 3.42 0
                             00-1.946.806 3.42 3.42 0 01-4.438 0 3.42
                             3.42 0 00-1.946-.806 3.42 3.42 0
                             01-3.138-3.138 3.42 3.42 0 00-.806-1.946
                             3.42 3.42 0 010-4.438 3.42 3.42 0
                             00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase
                          tracking-wider">BPA 3</p>
                <p class="text-3xl font-extrabold text-gray-900 leading-tight">
                    {{ str_pad($countBpa3 ?? 0, 2, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </div>

        {{-- BPA 4 — Kuning --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm
                    px-5 py-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center
                        justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-amber-500" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0
                             002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6
                             20V4h5v7h7v9H6z"/>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase
                          tracking-wider">BPA 4</p>
                <p class="text-3xl font-extrabold text-gray-900 leading-tight">
                    {{ str_pad($countBpa4 ?? 0, 2, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════
         SECTION 3: ACTION BAR
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
            + TAMBAH DOKUMEN
        </button>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 4: TABEL
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

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3 text-[11px] font-bold
                                   text-gray-400 uppercase tracking-wider">
                            Nama / Judul Dokumen
                        </th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold
                                   text-gray-400 uppercase tracking-wider">
                            Jenis Dokumen BPA
                        </th>
                        <th class="text-left px-4 py-3 text-[11px] font-bold
                                   text-gray-400 uppercase tracking-wider">
                            Tanggal Diunggah
                        </th>
                        <th class="text-center px-4 py-3 text-[11px] font-bold
                                   text-gray-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50" id="dokumenTableBody">

                    @forelse($dokumens as $dok)
                    @php
                        $bpaColors = [
                            'BPA 1' => ['bg'=>'bg-red-100',   'text'=>'text-red-700',   'dot'=>'bg-red-500',   'icon'=>'text-red-500'],
                            'BPA 2' => ['bg'=>'bg-blue-100',  'text'=>'text-blue-700',  'dot'=>'bg-blue-500',  'icon'=>'text-blue-500'],
                            'BPA 3' => ['bg'=>'bg-green-100', 'text'=>'text-green-700', 'dot'=>'bg-green-500', 'icon'=>'text-green-500'],
                            'BPA 4' => ['bg'=>'bg-amber-100', 'text'=>'text-amber-700', 'dot'=>'bg-amber-500', 'icon'=>'text-amber-500'],
                        ];
                        $c = $bpaColors[$dok->jenis_bpa] ?? [
                            'bg'=>'bg-gray-100','text'=>'text-gray-700',
                            'dot'=>'bg-gray-400','icon'=>'text-gray-400'
                        ];
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors dokumen-row"
                        data-nama="{{ strtolower($dok->nama_dokumen) }}">

                        {{-- Nama --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg
                                            {{ $c['bg'] }} flex items-center
                                            justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ $c['icon'] }}"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0
                                                 002 2h12a2 2 0 002-2V8l-6-6zm-1
                                                 1.5L18.5 9H13V3.5zM6
                                                 20V4h5v7h7v9H6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800
                                              dokumen-nama">
                                        {{ $dok->nama_dokumen }}
                                    </p>
                                    @if($dok->path_dokumen)
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        PDF ·
                                        @php
                                            try {
                                                echo number_format(
                                                    Storage::disk('public')
                                                        ->size($dok->path_dokumen)
                                                    / 1048576, 1) . ' MB';
                                            } catch(\Exception $e) { echo '—'; }
                                        @endphp
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Badge Jenis BPA --}}
                        <td class="px-4 py-3.5">
                            <span class="inline-flex items-center gap-1.5
                                         px-2.5 py-1 rounded-md text-[11px]
                                         font-bold uppercase tracking-wide
                                         {{ $c['bg'] }} {{ $c['text'] }}">
                                {{ $dok->jenis_bpa ?? '—' }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-4 py-3.5 text-gray-600 text-sm">
                            {{ $dok->created_at
                                ? $dok->created_at->translatedFormat('j F Y')
                                : '—' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    @click="openEdit(
                                        {{ $dok->id }},
                                        @js($dok->nama_dokumen),
                                        @js($dok->jenis_bpa ?? 'BPA 1')
                                    )"
                                    class="px-3.5 py-1.5 text-xs font-semibold
                                           text-blue-600 bg-white border
                                           border-gray-200 rounded-lg
                                           hover:bg-blue-50
                                           hover:border-blue-200 transition">
                                    Edit
                                </button>
                                <button
                                    @click="openHapus(
                                        {{ $dok->id }},
                                        @js($dok->nama_dokumen)
                                    )"
                                    class="px-3.5 py-1.5 text-xs font-semibold
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
                        <td colspan="4"
                            class="px-5 py-14 text-center text-sm text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-gray-300" fill="none"
                                    stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2
                                           V5a2 2 0 012-2h5.586a1 1 0 01.707.293
                                           l5.414 5.414A1 1 0 0119 9.414V19
                                           a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="font-medium">Belum ada dokumen.</p>
                                <p class="text-xs text-gray-400">
                                    Klik "+ Tambah Dokumen" untuk memulai.
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
                <span class="font-semibold">{{ $dokumens->lastPage() }}</span>
            </p>

            <div class="flex items-center gap-1">

                {{-- Prev --}}
                @if($dokumens->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center
                                 text-gray-300 text-sm">‹</span>
                @else
                    <a href="{{ $dokumens->previousPageUrl() }}"
                        class="w-8 h-8 flex items-center justify-center
                               rounded-lg border border-gray-200 text-gray-600
                               hover:bg-gray-50 text-sm transition">‹</a>
                @endif

                {{-- Page numbers --}}
                @foreach($dokumens->getUrlRange(1, $dokumens->lastPage())
                         as $page => $url)
                    @if($page == $dokumens->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center
                                     rounded-lg bg-brand-800 text-white
                                     text-xs font-bold shadow-sm">
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

                {{-- Next --}}
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

    </div>{{-- end tabel --}}


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
                    z-10 max-h-[90vh] overflow-y-auto"
            x-show="showTambah"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 pt-6 pb-5">
                <h2 class="text-xl font-bold text-gray-900">
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

            <div class="px-6 pb-4 space-y-4">

                {{-- Error bag --}}
                <template x-if="tambahForm.errors.length > 0">
                    <div class="bg-red-50 border border-red-200 rounded-xl
                                px-4 py-3">
                        <ul class="space-y-1">
                            <template x-for="err in tambahForm.errors"
                                :key="err">
                                <li class="text-xs text-red-700 flex
                                           items-start gap-2">
                                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000
                                               16zM8.707 7.293a1 1 0 00-1.414
                                               1.414L8.586 10l-1.293 1.293a1 1 0
                                               101.414 1.414L10 11.414l1.293
                                               1.293a1 1 0 001.414-1.414L11.414
                                               10l1.293-1.293a1 1 0 00-1.414
                                               -1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="err"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

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

                {{-- Jenis Dokumen BPA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Jenis Dokumen BPA <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="tambahForm.jenis_bpa"
                            class="w-full px-3.5 py-2.5 text-sm border
                                   rounded-xl focus:outline-none focus:ring-2
                                   focus:ring-brand-200 focus:border-brand-500
                                   bg-white appearance-none text-gray-700
                                   transition"
                            :class="tambahForm.fieldErrors.jenis_bpa
                                ? 'border-red-400' : 'border-gray-300'">
                            <option value="BPA 1">BPA 1</option>
                            <option value="BPA 2">BPA 2</option>
                            <option value="BPA 3">BPA 3</option>
                            <option value="BPA 4">BPA 4</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2
                                    w-4 h-4 text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p x-show="tambahForm.fieldErrors.jenis_bpa"
                       x-text="tambahForm.fieldErrors.jenis_bpa"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Upload Dokumen --}}
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
                               w-full py-10 border-2 border-dashed rounded-xl
                               cursor-pointer hover:border-brand-400
                               hover:bg-brand-50/30 transition group"
                        :class="tambahForm.fieldErrors.file_dokumen
                            ? 'border-red-400 bg-red-50/20' : 'border-gray-300'"
                        @dragover.prevent
                        @drop.prevent="
                            const f = $event.dataTransfer.files[0];
                            if (f) {
                                tambahForm.file    = f;
                                tambahForm.namaFile = f.name;
                                tambahForm.fieldErrors.file_dokumen = '';
                            }
                        ">
                        <svg class="w-14 h-14 text-gray-300
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

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 flex items-center justify-end gap-3
                        border-t border-gray-100">
                <button type="button" @click="showTambah = false"
                    class="px-5 py-2.5 text-sm font-bold text-gray-700
                           bg-white border-2 border-gray-300 rounded-xl
                           hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="button" @click="submitTambah()"
                    :disabled="tambahForm.loading"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm
                           font-bold text-white bg-brand-800
                           hover:bg-brand-900 rounded-xl shadow-sm transition
                           uppercase tracking-wide
                           disabled:opacity-60 disabled:cursor-not-allowed">
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
                    z-10 max-h-[90vh] overflow-y-auto"
            x-show="showEdit"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            <div class="flex items-center justify-between px-6 pt-6 pb-5">
                <h2 class="text-xl font-bold text-gray-900">Edit Dokumen</h2>
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

            <div class="px-6 pb-4 space-y-4">

                {{-- Error bag --}}
                <template x-if="editForm.errors.length > 0">
                    <div class="bg-red-50 border border-red-200 rounded-xl
                                px-4 py-3">
                        <ul class="space-y-1">
                            <template x-for="err in editForm.errors" :key="err">
                                <li class="text-xs text-red-700 flex
                                           items-start gap-2">
                                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000
                                               16zM8.707 7.293a1 1 0 00-1.414
                                               1.414L8.586 10l-1.293 1.293a1 1 0
                                               101.414 1.414L10 11.414l1.293
                                               1.293a1 1 0 001.414-1.414L11.414
                                               10l1.293-1.293a1 1 0 00-1.414
                                               -1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="err"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

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

                {{-- Jenis Dokumen BPA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700
                                  mb-1.5">
                        Jenis Dokumen BPA <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="editForm.jenis_bpa"
                            class="w-full px-3.5 py-2.5 text-sm border
                                   rounded-xl focus:outline-none focus:ring-2
                                   focus:ring-brand-200 focus:border-brand-500
                                   bg-white appearance-none text-gray-700
                                   transition"
                            :class="editForm.fieldErrors.jenis_bpa
                                ? 'border-red-400' : 'border-gray-300'">
                            <option value="BPA 1">BPA 1</option>
                            <option value="BPA 2">BPA 2</option>
                            <option value="BPA 3">BPA 3</option>
                            <option value="BPA 4">BPA 4</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2
                                    w-4 h-4 text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p x-show="editForm.fieldErrors.jenis_bpa"
                       x-text="editForm.fieldErrors.jenis_bpa"
                       class="mt-1 text-xs text-red-600"></p>
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
                               w-full py-10 border-2 border-dashed
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
                        <svg class="w-14 h-14 text-gray-300
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

            </div>

            <div class="px-6 py-4 flex items-center justify-end gap-3
                        border-t border-gray-100">
                <button type="button" @click="showEdit = false"
                    class="px-5 py-2.5 text-sm font-bold text-gray-700
                           bg-white border-2 border-gray-300 rounded-xl
                           hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="button" @click="submitEdit()"
                    :disabled="editForm.loading"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm
                           font-bold text-white bg-brand-800
                           hover:bg-brand-900 rounded-xl shadow-sm transition
                           uppercase tracking-wide
                           disabled:opacity-60 disabled:cursor-not-allowed">
                    <svg x-show="editForm.loading" x-cloak
                        class="w-4 h-4 animate-spin" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    <span x-text="editForm.loading
                        ? 'Menyimpan...' : 'KONFIRMASI'"></span>
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
                    Anda yakin ingin menghapus dokumen?
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
                               py-2.5 text-sm font-bold text-white bg-brand-800
                               hover:bg-brand-900 rounded-xl shadow-sm
                               transition uppercase tracking-wide
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
function dashboardAdmin() {
    return {

        // ════════════════════════════════════════
        // STATE
        // ════════════════════════════════════════

        alert: {
            show:    false,
            type:    'success',
            message: ''
        },

        showTambah: false,
        showEdit:   false,
        showHapus:  false,

        tambahForm: {
            nama_dokumen: '',
            jenis_bpa:    'BPA 1',
            file:         null,
            namaFile:     '',
            loading:      false,
            errors:       [],
            fieldErrors:  {}
        },

        editForm: {
            id:           null,
            nama_dokumen: '',
            jenis_bpa:    'BPA 1',
            file:         null,
            namaFile:     '',
            loading:      false,
            errors:       [],
            fieldErrors:  {}
        },

        hapusForm: {
            id:      null,
            nama:    '',
            loading: false,
            error:   ''
        },

        // ════════════════════════════════════════
        // HELPERS
        // ════════════════════════════════════════

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
                nama_dokumen: '',
                jenis_bpa:    'BPA 1',
                file:         null,
                namaFile:     '',
                loading:      false,
                errors:       [],
                fieldErrors:  {}
            };
        },

        resetEditForm() {
            this.editForm = {
                id:           null,
                nama_dokumen: '',
                jenis_bpa:    'BPA 1',
                file:         null,
                namaFile:     '',
                loading:      false,
                errors:       [],
                fieldErrors:  {}
            };
        },

        // ════════════════════════════════════════
        // OPEN HANDLERS
        // ════════════════════════════════════════

        openTambah() {
            this.resetTambahForm();
            this.showTambah = true;
        },

        openEdit(id, namaDokumen, jenisBpa) {
            this.resetEditForm();
            this.editForm.id           = id;
            this.editForm.nama_dokumen = namaDokumen || '';
            this.editForm.jenis_bpa    = jenisBpa    || 'BPA 1';
            this.showEdit = true;
        },

        openHapus(id, nama) {
            this.hapusForm = { id, nama, loading: false, error: '' };
            this.showHapus = true;
        },

        // ════════════════════════════════════════
        // SUBMIT: TAMBAH
        // ════════════════════════════════════════

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
            fd.append('_token',       '{{ csrf_token() }}');
            fd.append('nama_dokumen', this.tambahForm.nama_dokumen.trim());
            fd.append('jenis_bpa',    this.tambahForm.jenis_bpa);
            if (this.tambahForm.file) {
                fd.append('file_dokumen', this.tambahForm.file);
            }

            try {
                const res = await fetch('{{ route("admin_dashboard.store") }}', {
                    method: 'POST',
                    body:   fd
                });

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

        // ════════════════════════════════════════
        // SUBMIT: EDIT
        // ════════════════════════════════════════

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
            fd.append('_token',       '{{ csrf_token() }}');
            fd.append('_method',      'POST');
            fd.append('nama_dokumen', this.editForm.nama_dokumen.trim());
            fd.append('jenis_bpa',    this.editForm.jenis_bpa);
            if (this.editForm.file) {
                fd.append('file_dokumen', this.editForm.file);
            }

            try {
                const url = `{{ url('dashboard/admin_dashboard') }}/${this.editForm.id}`;
                const res = await fetch(url, {
                    method: 'POST',
                    body:   fd
                });

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

        // ════════════════════════════════════════
        // SUBMIT: HAPUS
        // ════════════════════════════════════════

        async submitHapus() {
            if (this.hapusForm.loading) return;

            if (!this.hapusForm.id) {
                this.hapusForm.error = 'ID dokumen tidak valid.';
                return;
            }

            this.hapusForm.loading = true;
            this.hapusForm.error   = '';

            try {
                const url = `{{ url('dashboard/admin_dashboard') }}/${this.hapusForm.id}`;
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
                    this.hapusForm.error = errors[0] || 'Gagal menghapus dokumen.';
                }

            } catch (_) {
                this.hapusForm.error =
                    'Gagal terhubung ke server. Periksa koneksi Anda.';
            } finally {
                this.hapusForm.loading = false;
            }
        },

        // ════════════════════════════════════════
        // CLIENT-SIDE SEARCH
        // ════════════════════════════════════════

        initSearch() {
            const input = document.getElementById('searchInput');
            if (!input) return;
            input.addEventListener('input', function () {
                const kw   = this.value.toLowerCase();
                const rows = document.querySelectorAll('.dokumen-row');
                rows.forEach(row => {
                    const nama = row.dataset.nama || '';
                    row.style.display = nama.includes(kw) ? '' : 'none';
                });
            });
        },

        // ════════════════════════════════════════
        // INIT (dipanggil Alpine otomatis)
        // ════════════════════════════════════════

        init() {
            this.initSearch();
        }

    };
}
</script>
@endsection