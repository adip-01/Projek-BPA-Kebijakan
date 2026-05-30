@extends('layouts.admin')

@section('title', 'Informasi Tambahan')
@section('breadcrumb', 'Informasi Tambahan')

@section('content')
<div x-data="informasiTambahan()">

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
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                Informasi Tambahan
            </h1>
            <p class="text-gray-500 mt-1 text-sm">
                Kelola seluruh dokumen kebijakan akademik Anda di sini.
            </p>
        </div>

        <div class="flex items-center gap-3 mt-1">
            {{-- Label keterangan --}}
            <span class="text-xs text-gray-400 italic">insert pdf/video/jpg</span>

            {{-- Tombol Tambah --}}
            <button @click="openTambah()"
                class="flex items-center gap-2 bg-brand-800 hover:bg-brand-900
                       text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                       shadow-sm transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                    stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4v16m8-8H4"/>
                </svg>
                TAMBAH INFORMASI
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 2: GRID ASIMETRIS
         Kiri  : 1 kartu tinggi penuh (row-span-2)
         Kanan : 2 kartu ditumpuk atas-bawah
    ══════════════════════════════════════════ --}}
    @if($informasis->isEmpty())
        {{-- Empty state --}}
        <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200
                    p-16 flex flex-col items-center justify-center text-gray-400">
            <svg class="w-14 h-14 mb-4 text-gray-300" fill="none"
                stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                       a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19
                       a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm font-medium">Belum ada informasi tambahan.</p>
            <p class="text-xs mt-1">
            </p>
        </div>

    @else
        {{-- Wrapper dengan padding & background putih --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

            {{-- Grid asimetris: 2 kolom, kolom kiri row-span-2 --}}
            <div class="grid grid-cols-2 gap-4"
                 style="grid-template-rows: auto auto;">

                @php $items = $informasis->values(); @endphp

                {{-- ── KARTU KIRI (besar, row-span-2) ── --}}
                @if($items->count() >= 1)
                @php $kiri = $items[0]; @endphp
                <div class="relative bg-brand-800 rounded-xl overflow-hidden
                            group row-span-2 min-h-[420px]">

                    {{-- Thumbnail --}}
                    @if($kiri->path_file)
                        @php $ext = strtolower(pathinfo($kiri->path_file, PATHINFO_EXTENSION)); @endphp
                        @if(in_array($ext, ['jpg','jpeg','png','webp','gif']))
                            <img src="{{ Storage::url($kiri->path_file) }}"
                                alt="{{ $kiri->nama_informasi }}"
                                class="absolute inset-0 w-full h-full
                                       object-cover opacity-70"/>
                        @endif
                    @endif

                    {{-- Overlay gradient --}}
                    <div class="absolute inset-0 bg-gradient-to-t
                                from-brand-900/80 via-transparent to-transparent">
                    </div>

                    {{-- Action buttons --}}
                    <div class="absolute top-3 right-3 flex items-center gap-2
                                opacity-0 group-hover:opacity-100
                                transition-opacity duration-200 z-10">
                        <button
                            @click="openEdit(
                                {{ $kiri->id }},
                                @js($kiri->nama_informasi)
                            )"
                            class="w-9 h-9 rounded-full bg-white/90 hover:bg-white
                                   flex items-center justify-center text-brand-700
                                   shadow-md transition"
                            title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11
                                       a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828
                                       2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button
                            @click="openHapus(
                                {{ $kiri->id }},
                                @js($kiri->nama_informasi)
                            )"
                            class="w-9 h-9 rounded-full bg-white/90 hover:bg-red-100
                                   flex items-center justify-center text-red-600
                                   shadow-md transition"
                            title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                       a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                       m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3
                                       M4 7h16"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Label nama --}}
                    <div class="absolute bottom-0 left-0 right-0 px-4 py-4 z-10">
                        <p class="text-white text-sm font-semibold drop-shadow
                                  truncate">
                            {{ $kiri->nama_informasi }}
                        </p>
                    </div>
                </div>
                @else
                {{-- Placeholder kiri --}}
                <div class="row-span-2 min-h-[420px] bg-brand-800/10 border-2
                            border-dashed border-brand-200 rounded-xl
                            flex items-center justify-center">
                    <p class="text-brand-300 text-xs">Slot kosong</p>
                </div>
                @endif

                {{-- ── KARTU KANAN ATAS ── --}}
                @if($items->count() >= 2)
                @php $kananAtas = $items[1]; @endphp
                <div class="relative bg-brand-800 rounded-xl overflow-hidden
                            group min-h-[200px]">

                    @if($kananAtas->path_file)
                        @php $ext2 = strtolower(pathinfo($kananAtas->path_file, PATHINFO_EXTENSION)); @endphp
                        @if(in_array($ext2, ['jpg','jpeg','png','webp','gif']))
                            <img src="{{ Storage::url($kananAtas->path_file) }}"
                                alt="{{ $kananAtas->nama_informasi }}"
                                class="absolute inset-0 w-full h-full
                                       object-cover opacity-70"/>
                        @endif
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t
                                from-brand-900/80 via-transparent to-transparent">
                    </div>

                    <div class="absolute top-3 right-3 flex items-center gap-2
                                opacity-0 group-hover:opacity-100
                                transition-opacity duration-200 z-10">
                        <button
                            @click="openEdit(
                                {{ $kananAtas->id }},
                                @js($kananAtas->nama_informasi)
                            )"
                            class="w-9 h-9 rounded-full bg-white/90 hover:bg-white
                                   flex items-center justify-center text-brand-700
                                   shadow-md transition"
                            title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11
                                       a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828
                                       2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button
                            @click="openHapus(
                                {{ $kananAtas->id }},
                                @js($kananAtas->nama_informasi)
                            )"
                            class="w-9 h-9 rounded-full bg-white/90 hover:bg-red-100
                                   flex items-center justify-center text-red-600
                                   shadow-md transition"
                            title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                       a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                       m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3
                                       M4 7h16"/>
                            </svg>
                        </button>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 px-4 py-4 z-10">
                        <p class="text-white text-sm font-semibold drop-shadow
                                  truncate">
                            {{ $kananAtas->nama_informasi }}
                        </p>
                    </div>
                </div>
                @else
                <div class="min-h-[200px] bg-brand-800/10 border-2 border-dashed
                            border-brand-200 rounded-xl flex items-center
                            justify-center">
                    <p class="text-brand-300 text-xs">Slot kosong</p>
                </div>
                @endif

                {{-- ── KARTU KANAN BAWAH ── --}}
                @if($items->count() >= 3)
                @php $kananBawah = $items[2]; @endphp
                <div class="relative bg-brand-800 rounded-xl overflow-hidden
                            group min-h-[200px]">

                    @if($kananBawah->path_file)
                        @php $ext3 = strtolower(pathinfo($kananBawah->path_file, PATHINFO_EXTENSION)); @endphp
                        @if(in_array($ext3, ['jpg','jpeg','png','webp','gif']))
                            <img src="{{ Storage::url($kananBawah->path_file) }}"
                                alt="{{ $kananBawah->nama_informasi }}"
                                class="absolute inset-0 w-full h-full
                                       object-cover opacity-70"/>
                        @endif
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t
                                from-brand-900/80 via-transparent to-transparent">
                    </div>

                    <div class="absolute top-3 right-3 flex items-center gap-2
                                opacity-0 group-hover:opacity-100
                                transition-opacity duration-200 z-10">
                        <button
                            @click="openEdit(
                                {{ $kananBawah->id }},
                                @js($kananBawah->nama_informasi)
                            )"
                            class="w-9 h-9 rounded-full bg-white/90 hover:bg-white
                                   flex items-center justify-center text-brand-700
                                   shadow-md transition"
                            title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11
                                       a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828
                                       2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button
                            @click="openHapus(
                                {{ $kananBawah->id }},
                                @js($kananBawah->nama_informasi)
                            )"
                            class="w-9 h-9 rounded-full bg-white/90 hover:bg-red-100
                                   flex items-center justify-center text-red-600
                                   shadow-md transition"
                            title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                       a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                       m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3
                                       M4 7h16"/>
                            </svg>
                        </button>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 px-4 py-4 z-10">
                        <p class="text-white text-sm font-semibold drop-shadow
                                  truncate">
                            {{ $kananBawah->nama_informasi }}
                        </p>
                    </div>
                </div>
                @else
                <div class="min-h-[200px] bg-brand-800/10 border-2 border-dashed
                            border-brand-200 rounded-xl flex items-center
                            justify-center">
                    <p class="text-brand-300 text-xs">Slot kosong</p>
                </div>
                @endif

            </div>{{-- end grid --}}

            {{-- Item ke-4 dst: grid biasa 2 kolom di bawah --}}
            @if($items->count() > 3)
            <div class="grid grid-cols-2 gap-4 mt-4">
                @foreach($items->slice(3) as $item)
                <div class="relative bg-brand-800 rounded-xl overflow-hidden
                            group min-h-[200px]">

                    @if($item->path_file)
                        @php $extN = strtolower(pathinfo($item->path_file, PATHINFO_EXTENSION)); @endphp
                        @if(in_array($extN, ['jpg','jpeg','png','webp','gif']))
                            <img src="{{ Storage::url($item->path_file) }}"
                                alt="{{ $item->nama_informasi }}"
                                class="absolute inset-0 w-full h-full
                                       object-cover opacity-70"/>
                        @endif
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t
                                from-brand-900/80 via-transparent to-transparent">
                    </div>

                    <div class="absolute top-3 right-3 flex items-center gap-2
                                opacity-0 group-hover:opacity-100
                                transition-opacity duration-200 z-10">
                        <button
                            @click="openEdit({{ $item->id }}, @js($item->nama_informasi))"
                            class="w-9 h-9 rounded-full bg-white/90 hover:bg-white
                                   flex items-center justify-center text-brand-700
                                   shadow-md transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11
                                       a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828
                                       2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button
                            @click="openHapus({{ $item->id }}, @js($item->nama_informasi))"
                            class="w-9 h-9 rounded-full bg-white/90 hover:bg-red-100
                                   flex items-center justify-center text-red-600
                                   shadow-md transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                       a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                       m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3
                                       M4 7h16"/>
                            </svg>
                        </button>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 px-4 py-4 z-10">
                        <p class="text-white text-sm font-semibold drop-shadow
                                  truncate">
                            {{ $item->nama_informasi }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>{{-- end white wrapper --}}
    @endif


    {{-- ══════════════════════════════════════════
         MODAL 1: TAMBAH INFORMASI
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

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 pt-6 pb-5">
                <h2 class="text-lg font-bold text-gray-900">Tambah Informasi</h2>
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
            <div class="px-6 pb-4 space-y-4">

                {{-- Error bag --}}
                <template x-if="tambahForm.errors.length > 0">
                    <div class="bg-red-50 border border-red-200 rounded-xl
                                px-4 py-3">
                        <ul class="space-y-1">
                            <template x-for="err in tambahForm.errors" :key="err">
                                <li class="text-xs text-red-700 flex items-start gap-2">
                                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707
                                               7.293a1 1 0 00-1.414 1.414L8.586 10
                                               l-1.293 1.293a1 1 0 101.414 1.414L10
                                               11.414l1.293 1.293a1 1 0 001.414-1.414
                                               L11.414 10l1.293-1.293a1 1 0
                                               00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="err"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

                {{-- Nama Informasi --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Nama Informasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="tambahForm.nama_informasi"
                        placeholder="Nama Informasi"
                        class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition placeholder-gray-400"
                        :class="tambahForm.fieldErrors.nama_informasi
                            ? 'border-red-400' : 'border-gray-300'"/>
                    <p x-show="tambahForm.fieldErrors.nama_informasi"
                       x-text="tambahForm.fieldErrors.nama_informasi"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Unggah Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Unggah Dokumen
                    </label>

                    {{-- Drop zone --}}
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
                        {{-- Ikon dokumen upload --}}
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
                        <span class="px-4 py-1.5 text-xs font-medium text-gray-700
                                     bg-white border border-gray-300 rounded-lg
                                     hover:bg-gray-50 transition">
                            Pilih File Lokal
                        </span>
                        <span class="text-xs text-gray-400">File Max 10MB</span>

                        <input type="file"
                            accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov"
                            class="hidden"
                            @change="
                                const f = $event.target.files[0];
                                if (f) {
                                    tambahForm.file    = f;
                                    tambahForm.namaFile = f.name;
                                    tambahForm.fieldErrors.file_dokumen = '';
                                }
                            "/>
                    </label>

                    {{-- File terpilih --}}
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
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold
                           text-white bg-brand-800 hover:bg-brand-900 rounded-xl
                           shadow-sm transition uppercase tracking-wide
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
         MODAL 2: UBAH INFORMASI
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

            <div class="flex items-center justify-between px-6 pt-6 pb-5">
                <h2 class="text-lg font-bold text-gray-900">Ubah Informasi</h2>
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
                                <li class="text-xs text-red-700 flex items-start gap-2">
                                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707
                                               7.293a1 1 0 00-1.414 1.414L8.586 10
                                               l-1.293 1.293a1 1 0 101.414 1.414L10
                                               11.414l1.293 1.293a1 1 0 001.414-1.414
                                               L11.414 10l1.293-1.293a1 1 0
                                               00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <span x-text="err"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

                {{-- Nama Informasi --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Nama Informasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="editForm.nama_informasi"
                        placeholder="Nama Informasi"
                        class="w-full px-3.5 py-2.5 text-sm border rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-brand-200
                               focus:border-brand-500 transition placeholder-gray-400"
                        :class="editForm.fieldErrors.nama_informasi
                            ? 'border-red-400' : 'border-gray-300'"/>
                    <p x-show="editForm.fieldErrors.nama_informasi"
                       x-text="editForm.fieldErrors.nama_informasi"
                       class="mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Unggah Dokumen --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Unggah Dokumen
                        <span class="font-normal text-gray-400">
                            (kosongkan jika tidak ingin mengganti)
                        </span>
                    </label>

                    <label x-show="!editForm.namaFile"
                        class="flex flex-col items-center justify-center gap-2
                               w-full py-10 border-2 border-dashed border-gray-300
                               rounded-xl cursor-pointer hover:border-brand-400
                               hover:bg-brand-50/30 transition group"
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
                        <span class="px-4 py-1.5 text-xs font-medium text-gray-700
                                     bg-white border border-gray-300 rounded-lg
                                     hover:bg-gray-50 transition">
                            Pilih File Lokal
                        </span>
                        <span class="text-xs text-gray-400">File Max 10MB</span>
                        <input type="file"
                            accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov"
                            class="hidden"
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
                            @click="editForm.file = null; editForm.namaFile = ''"
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
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold
                           text-white bg-brand-800 hover:bg-brand-900 rounded-xl
                           shadow-sm transition uppercase tracking-wide
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
                        ? 'Menyimpan...' : 'UBAH DOKUMEN'"></span>
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

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10
                    text-center"
            x-show="showHapus"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            <div class="px-8 py-8">
                <p class="text-base font-semibold text-gray-800 mb-6">
                    Anda yakin ingin menghapus informasi?
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
                               hover:bg-gray-50 transition uppercase tracking-wide">
                        BATAL
                    </button>
                    <button type="button" @click="submitHapus()"
                        :disabled="hapusForm.loading"
                        class="flex-1 flex items-center justify-center gap-2
                               py-2.5 text-sm font-bold text-white bg-brand-800
                               hover:bg-brand-900 rounded-xl shadow-sm transition
                               uppercase tracking-wide
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
function informasiTambahan() {
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
            nama_informasi: '',
            file:           null,
            namaFile:       '',
            loading:        false,
            errors:         [],
            fieldErrors:    {}
        },

        editForm: {
            id:             null,
            nama_informasi: '',
            file:           null,
            namaFile:       '',
            loading:        false,
            errors:         [],
            fieldErrors:    {}
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
                nama_informasi: '',
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
                nama_informasi: '',
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

        openEdit(id, namaInformasi) {
            this.resetEditForm();
            this.editForm.id             = id;
            this.editForm.nama_informasi = namaInformasi || '';
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
            if (!this.tambahForm.nama_informasi.trim()) {
                this.tambahForm.errors      = ['Nama informasi wajib diisi.'];
                this.tambahForm.fieldErrors = {
                    nama_informasi: 'Nama informasi wajib diisi.'
                };
                return;
            }

            this.tambahForm.loading     = true;
            this.tambahForm.errors      = [];
            this.tambahForm.fieldErrors = {};

            const fd = new FormData();
            fd.append('_token',         '{{ csrf_token() }}');
            fd.append('nama_informasi', this.tambahForm.nama_informasi.trim());
            if (this.tambahForm.file) {
                fd.append('file_dokumen', this.tambahForm.file);
            }

            try {
                const res = await fetch(
                    '{{ route("informasi-tambahan.store") }}',
                    { method: 'POST', body: fd }
                );

                if (res.ok) {
                    const json = await res.json();
                    this.showTambah = false;
                    this.showAlertMsg(
                        'success',
                        json.message || 'Informasi berhasil ditambahkan.'
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
                this.editForm.errors = ['ID informasi tidak valid.'];
                return;
            }

            if (!this.editForm.nama_informasi.trim()) {
                this.editForm.errors      = ['Nama informasi wajib diisi.'];
                this.editForm.fieldErrors = {
                    nama_informasi: 'Nama informasi wajib diisi.'
                };
                return;
            }

            this.editForm.loading     = true;
            this.editForm.errors      = [];
            this.editForm.fieldErrors = {};

            const fd = new FormData();
            fd.append('_token',         '{{ csrf_token() }}');
            fd.append('_method',        'POST');
            fd.append('nama_informasi', this.editForm.nama_informasi.trim());
            if (this.editForm.file) {
                fd.append('file_dokumen', this.editForm.file);
            }

            try {
                const url = `{{ url('dashboard/informasi-tambahan') }}/${this.editForm.id}`;
                const res = await fetch(url, { method: 'POST', body: fd });

                if (res.ok) {
                    const json = await res.json();
                    this.showEdit = false;
                    this.showAlertMsg(
                        'success',
                        json.message || 'Informasi berhasil diperbarui.'
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
                this.hapusForm.error = 'ID informasi tidak valid.';
                return;
            }

            this.hapusForm.loading = true;
            this.hapusForm.error   = '';

            try {
                const url = `{{ url('dashboard/informasi-tambahan') }}/${this.hapusForm.id}`;
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
                        json.message || 'Informasi berhasil dihapus.'
                    );
                    setTimeout(() => location.reload(), 900);
                } else {
                    const { errors } = await this.parseErrors(res);
                    this.hapusForm.error = errors[0] || 'Gagal menghapus informasi.';
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
            // ESC untuk menutup modal yang sedang terbuka
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