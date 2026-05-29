@extends('layouts.admin')

@section('title', 'Tentang Dokumen Unit')
@section('breadcrumb', 'Tentang Dokumen Unit')

@section('content')
<div x-data="dokumenUnit()">

    {{-- ══ FLASH ALERT ══ --}}
    <div x-show="alert.show" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        :class="alert.type==='success'
            ? 'bg-green-50 border-green-200 text-green-800'
            : 'bg-red-50 border-red-200 text-red-800'"
        class="mb-5 flex items-center gap-3 border text-sm px-4 py-3 rounded-xl">
        <svg x-show="alert.type==='success'"
            class="w-4 h-4 text-green-500 flex-shrink-0"
            fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0
                   00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414
                   1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <svg x-show="alert.type==='error'" x-cloak
            class="w-4 h-4 text-red-500 flex-shrink-0"
            fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0
                   00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414
                   1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414
                   10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586
                   8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <span x-text="alert.message"></span>
    </div>

    {{-- ══ PAGE HEADER ══ --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                Tentang Dokumen Unit
            </h1>
            <p class="text-gray-500 mt-1 text-sm">
                Kelola seluruh dokumen kebijakan akademik Anda di sini.
            </p>
        </div>
        <button @click="openTambah()"
            class="flex items-center gap-2 bg-brand-800 hover:bg-brand-900
                   text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                   shadow-sm transition whitespace-nowrap flex-shrink-0 mt-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4v16m8-8H4"/>
            </svg>
            TAMBAH INFORMASI
        </button>
    </div>

    {{-- ══ CARD GRID ══ --}}
    @if($unitList->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-gray-400">
            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none"
                stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                       a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19
                       a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm font-medium">Belum ada data dokumen unit.</p>
            <p class="text-xs mt-1">Klik "+ Tambah Informasi" untuk menambahkan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @foreach($unitList as $unit)
            @php
                $milik      = $stats[$unit]['Dokumen Milik']      ?? [];
                $distribusi = $stats[$unit]['Dokumen Distribusi'] ?? [];
                $dokTerbaru = \App\Models\DokumenUnit::where('unit_bpa', $unit)
                                ->latest()->first();
                $statCols = [
                    ['key' => 'Prosedur',         'label' => 'PROSEDUR'],
                    ['key' => 'Instruksi Kerja',   'label' => 'INSTRUKSI<br>KERJA'],
                    ['key' => 'Formulir SPMI',     'label' => 'FORMULIR<br>SPMI'],
                    ['key' => 'Dokumen Internal',  'label' => 'DOKUMEN<br>INTERNAL'],
                ];
            @endphp

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm
                        overflow-hidden hover:shadow-md transition-shadow">

                {{-- Card Header merah --}}
                <div class="relative bg-brand-800 px-4 py-3">
                    <h3 class="text-white font-bold text-sm truncate pr-20">
                        {{ $unit }}
                    </h3>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2
                                flex items-center gap-1.5">
                        {{-- Tombol Edit --}}
                        <button
                            @click="openEdit(
                                {{ $dokTerbaru?->id ?? 'null' }},
                                @js($unit),
                                @js($dokTerbaru?->jenis_dokumen ?? 'Dokumen Milik'),
                                @js($dokTerbaru?->jenis_spesifik ?? 'Prosedur')
                            )"
                            class="w-7 h-7 rounded-lg bg-white/20 hover:bg-white/40
                                   flex items-center justify-center text-white transition"
                            title="Edit">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11
                                       a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828
                                       2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        {{-- Tombol Hapus --}}
                        <button
                            @click="openHapus(
                                {{ $dokTerbaru?->id ?? 'null' }},
                                @js($unit)
                            )"
                            class="w-7 h-7 rounded-lg bg-white/20 hover:bg-red-500/70
                                   flex items-center justify-center text-white transition"
                            title="Hapus">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                       a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                       m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="px-4 pb-4 pt-3 space-y-3">

                    {{-- Dokumen Milik --}}
                    <div>
                        <p class="text-xs font-bold text-gray-800 mb-2">Dokumen Milik</p>
                        <div class="grid grid-cols-4 gap-1 text-center">
                            @foreach($statCols as $col)
                            <div>
                                <p class="text-2xl font-bold text-gray-900 leading-none">
                                    {{ $milik[$col['key']] ?? 0 }}
                                </p>
                                <p class="text-[9px] font-semibold text-gray-400
                                          uppercase tracking-wide mt-1 leading-tight">
                                    {!! $col['label'] !!}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Dokumen Distribusi --}}
                    <div>
                        <p class="text-xs font-bold text-gray-800 mb-2">
                            Dokumen Distribusi
                        </p>
                        <div class="grid grid-cols-4 gap-1 text-center">
                            @foreach($statCols as $col)
                            <div>
                                <p class="text-2xl font-bold text-gray-900 leading-none">
                                    {{ $distribusi[$col['key']] ?? 0 }}
                                </p>
                                <p class="text-[9px] font-semibold text-gray-400
                                          uppercase tracking-wide mt-1 leading-tight">
                                    {!! $col['label'] !!}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Tombol bawah --}}
                    <div class="space-y-2 pt-1">
                        <a href="{{ route('dokumen-unit.index') }}?unit={{ urlencode($unit) }}&detail=1"
                            class="block w-full py-2 text-sm font-semibold text-center
                                   text-white bg-brand-800 hover:bg-brand-900
                                   rounded-xl shadow-sm transition">
                            Lihat Detail
                        </a>
                        <a href="{{ route('dokumen-unit.index') }}?unit={{ urlencode($unit) }}&direktorat=1"
                            class="block w-full py-2 text-sm font-semibold text-center
                                   text-white bg-brand-800 hover:bg-brand-900
                                   rounded-xl shadow-sm transition">
                            Lihat Direktorat
                        </a>
                    </div>

                </div>
            </div>
            @endforeach

        </div>
    @endif


    {{-- ══════════════════════════════════════════
         MODAL: TAMBAH DOKUMEN BARU
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

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10
                    max-h-[90vh] overflow-y-auto"
            x-show="showTambah"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            {{-- Header sticky --}}
            <div class="flex items-center justify-between px-6 pt-6 pb-4
                        sticky top-0 bg-white border-b border-gray-100 z-10">
                <h2 class="text-lg font-bold text-gray-900">Tambah Dokumen Baru</h2>
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

            {{-- Body --}}
            <div class="px-6 py-4 space-y-4">

                {{-- Error bag --}}
                <template x-if="tambahForm.errors.length > 0">
                    <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                        <ul class="space-y-1">
                            <template x-for="err in tambahForm.errors" :key="err">
                                <li class="flex items-start gap-2 text-xs text-red-700">
                                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000
                                               16zM8.707 7.293a1 1 0 00-1.414
                                               1.414L8.586 10l-1.293 1.293a1 1 0
                                               101.414 1.414L10 11.414l1.293 1.293
                                               a1 1 0 001.414-1.414L11.414 10l1.293
                                               -1.293a1 1 0 00-1.414-1.414L10
                                               8.586 8.707 7.293z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="err"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

                {{-- Dropdown: Unit BPA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Unit Bpa <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="tambahForm.unit_bpa"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-brand-200
                                   focus:border-brand-500 bg-white appearance-none
                                   text-gray-700 transition"
                            :class="tambahForm.fieldErrors.unit_bpa
                                ? 'border-red-400' : 'border-gray-300'">
                            <option value="">-- Pilih Unit BPA --</option>
                            @foreach($unitList as $u)
                                <option value="{{ $u }}">{{ $u }}</option>
                            @endforeach
                            <option value="__new__">+ Tambah Unit Baru...</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4
                                    text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="tambahForm.unit_bpa === '__new__'" class="mt-2">
                        <input type="text" x-model="tambahForm.unit_bpa_baru"
                            placeholder="Ketik nama unit baru..."
                            class="w-full px-3.5 py-2.5 text-sm border border-brand-300
                                   rounded-xl focus:outline-none focus:ring-2
                                   focus:ring-brand-200 focus:border-brand-500
                                   transition placeholder-gray-400"/>
                    </div>
                    <p x-show="tambahForm.fieldErrors.unit_bpa"
                       x-text="tambahForm.fieldErrors.unit_bpa"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Dropdown: Jenis Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Jenis Dokumen <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="tambahForm.jenis_dokumen"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-brand-200
                                   focus:border-brand-500 bg-white appearance-none
                                   text-gray-700 transition"
                            :class="tambahForm.fieldErrors.jenis_dokumen
                                ? 'border-red-400' : 'border-gray-300'">
                            <option value="Dokumen Milik">Dokumen Milik</option>
                            <option value="Dokumen Distribusi">Dokumen Distribusi</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4
                                    text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p x-show="tambahForm.fieldErrors.jenis_dokumen"
                       x-text="tambahForm.fieldErrors.jenis_dokumen"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Dropdown: Jenis Spesifik --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Jenis Spesifik Dokumen <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="tambahForm.jenis_spesifik"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-brand-200
                                   focus:border-brand-500 bg-white appearance-none
                                   text-gray-700 transition"
                            :class="tambahForm.fieldErrors.jenis_spesifik
                                ? 'border-red-400' : 'border-gray-300'">
                            <option value="Prosedur">Prosedur</option>
                            <option value="Instruksi Kerja">Instruksi Kerja</option>
                            <option value="Formulir SPMI">Formulir SPMI</option>
                            <option value="Dokumen Internal">Dokumen Internal</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4
                                    text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p x-show="tambahForm.fieldErrors.jenis_spesifik"
                       x-text="tambahForm.fieldErrors.jenis_spesifik"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- File Upload Drag & Drop --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Unggah Dokumen
                        <span class="font-normal text-gray-400">(PDF, maks 10MB)</span>
                    </label>
                    <label x-show="!tambahForm.namaFile"
                        class="flex flex-col items-center justify-center gap-2 w-full
                               py-8 border-2 border-dashed rounded-xl cursor-pointer
                               hover:border-brand-400 hover:bg-brand-50/30 transition group"
                        :class="tambahForm.fieldErrors.file_dokumen
                            ? 'border-red-400 bg-red-50/20' : 'border-gray-300'"
                        @dragover.prevent
                        @drop.prevent="
                            const f = $event.dataTransfer.files[0];
                            if (f && f.type === 'application/pdf') {
                                tambahForm.file = f;
                                tambahForm.namaFile = f.name;
                                tambahForm.fieldErrors.file_dokumen = '';
                            }
                        ">
                        <svg class="w-12 h-12 text-gray-300 group-hover:text-gray-400"
                            fill="none" viewBox="0 0 48 48">
                            <rect x="8" y="4" width="24" height="36" rx="3"
                                stroke="currentColor" stroke-width="2.5" fill="none"/>
                            <path d="M26 4v12h12" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" fill="none"/>
                            <path d="M20 30l4-4 4 4" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round"/>
                            <path d="M24 26v8" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        <span class="text-sm text-gray-500">
                            Tarik &amp; Lepas File Disini
                        </span>
                        <span class="px-4 py-1.5 text-xs font-medium text-gray-700
                                     bg-white border border-gray-300 rounded-lg
                                     hover:bg-gray-50 transition">
                            Pilih File Lokal
                        </span>
                        <span class="text-xs text-gray-400">File Max 10MB</span>
                        <input type="file" accept=".pdf" class="hidden"
                            @change="
                                const f = $event.target.files[0];
                                if (f) {
                                    tambahForm.file = f;
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
                            @click="tambahForm.file = null; tambahForm.namaFile = ''"
                            class="text-gray-400 hover:text-red-500 font-bold
                                   transition">✕</button>
                    </div>
                    <p x-show="tambahForm.fieldErrors.file_dokumen"
                       x-text="tambahForm.fieldErrors.file_dokumen"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

            </div>

            {{-- Footer sticky --}}
            <div class="px-6 py-4 flex items-center justify-end gap-3
                        border-t border-gray-100 sticky bottom-0 bg-white">
                <button type="button" @click="showTambah = false"
                    class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-white
                           border-2 border-gray-300 rounded-xl hover:bg-gray-50
                           transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="button" @click="submitTambah()"
                    :disabled="tambahForm.loading"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold
                           text-white bg-brand-800 hover:bg-brand-900 rounded-xl
                           shadow-sm transition uppercase tracking-wide
                           disabled:opacity-60 disabled:cursor-not-allowed">
                    <svg x-show="tambahForm.loading" x-cloak
                        class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
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
         MODAL: EDIT DOKUMEN
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

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10
                    max-h-[90vh] overflow-y-auto"
            x-show="showEdit"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            <div class="flex items-center justify-between px-6 pt-6 pb-4
                        sticky top-0 bg-white border-b border-gray-100 z-10">
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

            <div class="px-6 py-4 space-y-4">

                {{-- Error bag --}}
                <template x-if="editForm.errors.length > 0">
                    <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                        <ul class="space-y-1">
                            <template x-for="err in editForm.errors" :key="err">
                                <li class="flex items-start gap-2 text-xs text-red-700">
                                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000
                                               16zM8.707 7.293a1 1 0 00-1.414
                                               1.414L8.586 10l-1.293 1.293a1 1 0
                                               101.414 1.414L10 11.414l1.293 1.293
                                               a1 1 0 001.414-1.414L11.414 10l1.293
                                               -1.293a1 1 0 00-1.414-1.414L10
                                               8.586 8.707 7.293z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="err"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

                {{-- Dropdown: Unit BPA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Unit Bpa <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="editForm.unit_bpa"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-brand-200
                                   focus:border-brand-500 bg-white appearance-none
                                   text-gray-700 transition"
                            :class="editForm.fieldErrors.unit_bpa
                                ? 'border-red-400' : 'border-gray-300'">
                            @foreach($unitList as $u)
                                <option value="{{ $u }}">{{ $u }}</option>
                            @endforeach
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4
                                    text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p x-show="editForm.fieldErrors.unit_bpa"
                       x-text="editForm.fieldErrors.unit_bpa"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Dropdown: Jenis Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Jenis Dokumen <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="editForm.jenis_dokumen"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-brand-200
                                   focus:border-brand-500 bg-white appearance-none
                                   text-gray-700 transition"
                            :class="editForm.fieldErrors.jenis_dokumen
                                ? 'border-red-400' : 'border-gray-300'">
                            <option value="Dokumen Milik">Dokumen Milik</option>
                            <option value="Dokumen Distribusi">Dokumen Distribusi</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4
                                    text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p x-show="editForm.fieldErrors.jenis_dokumen"
                       x-text="editForm.fieldErrors.jenis_dokumen"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Dropdown: Jenis Spesifik --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Jenis Spesifik Dokumen <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select x-model="editForm.jenis_spesifik"
                            class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-brand-200
                                   focus:border-brand-500 bg-white appearance-none
                                   text-gray-700 transition"
                            :class="editForm.fieldErrors.jenis_spesifik
                                ? 'border-red-400' : 'border-gray-300'">
                            <option value="Prosedur">Prosedur</option>
                            <option value="Instruksi Kerja">Instruksi Kerja</option>
                            <option value="Formulir SPMI">Formulir SPMI</option>
                            <option value="Dokumen Internal">Dokumen Internal</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4
                                    text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p x-show="editForm.fieldErrors.jenis_spesifik"
                       x-text="editForm.fieldErrors.jenis_spesifik"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- File Upload --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Unggah Dokumen
                        <span class="font-normal text-gray-400">
                            (kosongkan jika tidak ingin mengganti)
                        </span>
                    </label>
                    <label x-show="!editForm.namaFile"
                        class="flex flex-col items-center justify-center gap-2 w-full
                               py-8 border-2 border-dashed border-gray-300 rounded-xl
                               cursor-pointer hover:border-brand-400
                               hover:bg-brand-50/30 transition group"
                        @dragover.prevent
                        @drop.prevent="
                            const f = $event.dataTransfer.files[0];
                            if (f && f.type === 'application/pdf') {
                                editForm.file = f;
                                editForm.namaFile = f.name;
                            }
                        ">
                        <svg class="w-12 h-12 text-gray-300 group-hover:text-gray-400"
                            fill="none" viewBox="0 0 48 48">
                            <rect x="8" y="4" width="24" height="36" rx="3"
                                stroke="currentColor" stroke-width="2.5" fill="none"/>
                            <path d="M26 4v12h12" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" fill="none"/>
                            <path d="M20 30l4-4 4 4" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round"/>
                            <path d="M24 26v8" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        <span class="text-sm text-gray-500">
                            Tarik &amp; Lepas File Disini
                        </span>
                        <span class="px-4 py-1.5 text-xs font-medium text-gray-700
                                     bg-white border border-gray-300 rounded-lg
                                     hover:bg-gray-50 transition">
                            Pilih File Lokal
                        </span>
                        <span class="text-xs text-gray-400">File Max 10MB</span>
                        <input type="file" accept=".pdf" class="hidden"
                            @change="
                                const f = $event.target.files[0];
                                if (f) {
                                    editForm.file = f;
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
                            @click="editForm.file = null; editForm.namaFile = ''"
                            class="text-gray-400 hover:text-red-500 font-bold
                                   transition">✕</button>
                    </div>
                    <p x-show="editForm.fieldErrors.file_dokumen"
                       x-text="editForm.fieldErrors.file_dokumen"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

            </div>

            <div class="px-6 py-4 flex items-center justify-end gap-3
                        border-t border-gray-100 sticky bottom-0 bg-white">
                <button type="button" @click="showEdit = false"
                    class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-white
                           border-2 border-gray-300 rounded-xl hover:bg-gray-50
                           transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="button" @click="submitEdit()"
                    :disabled="editForm.loading"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold
                           text-white bg-brand-800 hover:bg-brand-900 rounded-xl
                           shadow-sm transition uppercase tracking-wide
                           disabled:opacity-60 disabled:cursor-not-allowed">
                    <svg x-show="editForm.loading" x-cloak
                        class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
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
         MODAL: KONFIRMASI HAPUS
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

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10
                    text-center"
            x-show="showHapus"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            <div class="px-8 py-8">
                <p class="text-base font-semibold text-gray-800 mb-6">
                    Anda yakin ingin menghapus dokumen ?
                </p>

                <template x-if="hapusForm.error">
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700
                                text-xs px-3 py-2 rounded-lg text-left">
                        <span x-text="hapusForm.error"></span>
                    </div>
                </template>

                <div class="flex items-center justify-center gap-3">
                    <button type="button" @click="showHapus = false"
                        class="flex-1 py-2.5 text-sm font-bold text-gray-700
                               bg-white border-2 border-gray-300 rounded-xl
                               hover:bg-gray-50 transition uppercase tracking-wide">
                        BATAL
                    </button>
                    <button type="button" @click="submitHapus()"
                        :disabled="hapusForm.loading"
                        class="flex-1 flex items-center justify-center gap-2 py-2.5
                               text-sm font-bold text-white bg-brand-800
                               hover:bg-brand-900 rounded-xl shadow-sm transition
                               uppercase tracking-wide
                               disabled:opacity-60 disabled:cursor-not-allowed">
                        <svg x-show="hapusForm.loading" x-cloak
                            class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
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
function dokumenUnit() {
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
            unit_bpa:       '',
            unit_bpa_baru:  '',
            jenis_dokumen:  'Dokumen Milik',
            jenis_spesifik: 'Prosedur',
            file:           null,
            namaFile:       '',
            loading:        false,
            errors:         [],
            fieldErrors:    {}
        },

        editForm: {
            id:             null,
            unit_bpa:       '',
            jenis_dokumen:  'Dokumen Milik',
            jenis_spesifik: 'Prosedur',
            file:           null,
            namaFile:       '',
            loading:        false,
            errors:         [],
            fieldErrors:    {}
        },

        hapusForm: {
            id:      null,
            unit_bpa:'',
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

        /**
         * Parse error response dari Laravel.
         * Handle 422 validation errors maupun error umum.
         */
        async parseErrors(response) {
            const errors      = [];
            const fieldErrors = {};

            try {
                // Clone response agar bisa dibaca ulang jika perlu
                const json = await response.json();

                if (response.status === 422 && json.errors) {
                    // Laravel validation: { errors: { field: ['msg1', 'msg2'] } }
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
                unit_bpa:       '',
                unit_bpa_baru:  '',
                jenis_dokumen:  'Dokumen Milik',
                jenis_spesifik: 'Prosedur',
                file:           null,
                namaFile:       '',
                loading:        false,
                errors:         [],
                fieldErrors:    {}
            };
        },

        resetEditForm() {
            this.editForm = {
                id:             null,
                unit_bpa:       '',
                jenis_dokumen:  'Dokumen Milik',
                jenis_spesifik: 'Prosedur',
                file:           null,
                namaFile:       '',
                loading:        false,
                errors:         [],
                fieldErrors:    {}
            };
        },

        // ════════════════════════════════
        // OPEN HANDLERS
        // ════════════════════════════════

        openTambah() {
            this.resetTambahForm();
            this.showTambah = true;
        },

        openEdit(id, unitBpa, jenisDokumen, jenisSpesifik) {
            this.resetEditForm();
            this.editForm.id             = id;
            this.editForm.unit_bpa       = unitBpa;
            this.editForm.jenis_dokumen  = jenisDokumen  || 'Dokumen Milik';
            this.editForm.jenis_spesifik = jenisSpesifik || 'Prosedur';
            this.showEdit = true;
        },

        openHapus(id, unitBpa) {
            this.hapusForm = {
                id,
                unit_bpa: unitBpa,
                loading:  false,
                error:    ''
            };
            this.showHapus = true;
        },

        // ════════════════════════════════
        // SUBMIT: TAMBAH
        // ════════════════════════════════

        async submitTambah() {
            if (this.tambahForm.loading) return;

            // Tentukan nilai unit_bpa final
            const unitFinal = this.tambahForm.unit_bpa === '__new__'
                ? this.tambahForm.unit_bpa_baru.trim()
                : this.tambahForm.unit_bpa.trim();

            // Validasi sisi client sebelum kirim
            if (!unitFinal) {
                this.tambahForm.errors      = ['Unit BPA wajib diisi.'];
                this.tambahForm.fieldErrors = { unit_bpa: 'Unit BPA wajib diisi.' };
                return;
            }

            this.tambahForm.loading     = true;
            this.tambahForm.errors      = [];
            this.tambahForm.fieldErrors = {};

            const fd = new FormData();
            fd.append('_token',         '{{ csrf_token() }}');
            fd.append('unit_bpa',       unitFinal);
            fd.append('jenis_dokumen',  this.tambahForm.jenis_dokumen);
            fd.append('jenis_spesifik', this.tambahForm.jenis_spesifik);
            if (this.tambahForm.file) {
                fd.append('file_dokumen', this.tambahForm.file);
            }

            try {
                const res = await fetch('{{ route("dokumen-unit.store") }}', {
                    method: 'POST',
                    body:   fd
                });

                if (res.ok) {
                    const json = await res.json();
                    this.showTambah = false;
                    this.showAlertMsg('success', json.message || 'Dokumen berhasil ditambahkan.');
                    // Reload setelah alert sempat terbaca
                    setTimeout(() => location.reload(), 900);
                } else {
                    const { errors, fieldErrors } = await this.parseErrors(res);
                    this.tambahForm.errors      = errors;
                    this.tambahForm.fieldErrors = fieldErrors;
                }

            } catch (_) {
                this.tambahForm.errors = ['Gagal terhubung ke server. Periksa koneksi Anda.'];
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

            this.editForm.loading     = true;
            this.editForm.errors      = [];
            this.editForm.fieldErrors = {};

            const fd = new FormData();
            fd.append('_token',         '{{ csrf_token() }}');
            fd.append('_method',        'POST');   // spoofing untuk route POST/{id}
            fd.append('unit_bpa',       this.editForm.unit_bpa);
            fd.append('jenis_dokumen',  this.editForm.jenis_dokumen);
            fd.append('jenis_spesifik', this.editForm.jenis_spesifik);
            if (this.editForm.file) {
                fd.append('file_dokumen', this.editForm.file);
            }

            try {
                const url = `{{ url("dashboard/dokumen-unit") }}/${this.editForm.id}`;
                const res = await fetch(url, {
                    method: 'POST',
                    body:   fd
                });

                if (res.ok) {
                    const json = await res.json();
                    this.showEdit = false;
                    this.showAlertMsg('success', json.message || 'Dokumen berhasil diperbarui.');
                    setTimeout(() => location.reload(), 900);
                } else {
                    const { errors, fieldErrors } = await this.parseErrors(res);
                    this.editForm.errors      = errors;
                    this.editForm.fieldErrors = fieldErrors;
                }

            } catch (_) {
                this.editForm.errors = ['Gagal terhubung ke server. Periksa koneksi Anda.'];
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
                const url = `{{ url("dashboard/dokumen-unit") }}/${this.hapusForm.id}`;
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
                    this.showAlertMsg('success', json.message || 'Dokumen berhasil dihapus.');
                    setTimeout(() => location.reload(), 900);
                } else {
                    const { errors } = await this.parseErrors(res);
                    this.hapusForm.error = errors[0] || 'Gagal menghapus dokumen.';
                }

            } catch (_) {
                this.hapusForm.error = 'Gagal terhubung ke server. Periksa koneksi Anda.';
            } finally {
                this.hapusForm.loading = false;
            }
        }

    };
}
</script>
@endsection