@extends('layouts.admin')

@section('title', 'Bisnis Proses')
@section('breadcrumb', 'Bisnis Proses')

@section('content')

<div
    x-data="{
        showTambah:       false,
        showEdit:         false,
        showHapus:        false,
        showKonfirmasiEdit: false,

        editId:           null,
        editJudul:        '',
        editFormRef:      null,

        hapusId:          null,
        hapusJudul:       '',

        /* preview gambar saat user pilih file */
        previewGambarTambah: null,
        previewGambarEdit:   null,

        /* nama file PDF */
        namaFileTambah: '',
        namaFileEdit:   '',

        openEdit(id, judul) {
            this.editId    = id;
            this.editJudul = judul;
            this.previewGambarEdit = null;
            this.namaFileEdit      = '';
            this.showEdit  = true;
        },
        openHapus(id, judul) {
            this.hapusId    = id;
            this.hapusJudul = judul;
            this.showHapus  = true;
        },
        submitEditForm() {
            this.showKonfirmasiEdit = false;
            this.$nextTick(() => {
                document.getElementById('formEdit_' + this.editId)?.submit();
            });
        }
    }"
>

{{-- ── Flash Messages ── --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
    class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-xl">
    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
    </svg>
    {{ session('error') }}
</div>
@endif

{{-- ── Page Title ── --}}
<div class="mb-6">
    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Bisnis Proses</h1>
    <p class="text-gray-500 mt-1 text-sm">Kelola seluruh dokumen kebijakan akademik Anda di sini.</p>
</div>

{{-- ── Action Bar ── --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-5">
    {{-- Search --}}
    <div class="relative max-w-xs w-full sm:w-72">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
            fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Cari Nama Kebijakan..."
            class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-gray-200 rounded-xl
                   focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500
                   transition placeholder-gray-400"/>
    </div>

    {{-- Filter --}}
    <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600
                   bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
        Filter
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 8h10M11 12h2M9 16h6"/>
        </svg>
    </button>

    <div class="flex-1"></div>

    {{-- Tambah --}}
    <button @click="showTambah = true; previewGambarTambah = null; namaFileTambah = ''"
        class="flex items-center gap-2 bg-brand-800 hover:bg-brand-900 text-white
               text-sm font-semibold px-5 py-2 rounded-xl shadow-sm transition whitespace-nowrap">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Proses
    </button>
</div>

{{-- ── Count Info ── --}}
<p class="text-sm text-gray-600 mb-4">
    Menampilkan <span class="font-semibold">{{ $total }}</span>
    dari <span class="font-semibold">{{ $total }}</span> bisnis proses
</p>

{{-- ══════════════════════════════════════════
     CARD GRID
══════════════════════════════════════════ --}}
@if($proseses->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-gray-400">
        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
        </svg>
        <p class="text-sm font-medium">Belum ada bisnis proses.</p>
        <p class="text-xs mt-1">Klik "+ Tambah Proses" untuk menambahkan data baru.</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="cardGrid">

        @foreach($proseses as $proses)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden
                    hover:shadow-md transition-shadow group proses-card"
             data-judul="{{ strtolower($proses->judul_proses) }}">

            {{-- Gambar / Thumbnail --}}
            <div class="relative">
                @if($proses->gambar_url)
                    <img src="{{ $proses->gambar_url }}"
                        alt="{{ $proses->judul_proses }}"
                        class="w-full h-44 object-cover"/>
                @else
                    <div class="w-full h-44 bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                            stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14
                                   m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="absolute text-sm font-medium text-gray-500 mt-14">Gambar</span>
                    </div>
                @endif

                {{-- Action icons di sudut kanan atas --}}
                <div class="absolute top-2 right-2 flex gap-1.5
                            opacity-0 group-hover:opacity-100 transition-opacity">
                    {{-- Edit --}}
                    <button @click="openEdit({{ $proses->id }}, '{{ addslashes($proses->judul_proses) }}')"
                        class="w-8 h-8 rounded-lg bg-brand-50 hover:bg-brand-100 text-brand-700
                               flex items-center justify-center shadow-sm transition"
                        title="Edit">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                   m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>

                    {{-- Hapus --}}
                    <button @click="openHapus({{ $proses->id }}, '{{ addslashes($proses->judul_proses) }}')"
                        class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600
                               flex items-center justify-center shadow-sm transition"
                        title="Hapus">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7
                                   m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="px-4 py-3">
                <p class="text-sm font-semibold text-gray-800 truncate">
                    {{ $proses->judul_proses }}
                </p>

                @if($proses->dokumen_url)
                <div class="flex items-center gap-2 mt-2">
                    <div class="w-6 h-6 rounded bg-red-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1
                                     1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                        </svg>
                    </div>
                    <a href="{{ $proses->dokumen_url }}" target="_blank"
                        class="text-xs text-brand-700 hover:underline truncate max-w-[160px]">
                        Lihat Dokumen PDF
                    </a>
                </div>
                @else
                <p class="text-xs text-gray-400 mt-2 italic">Belum ada dokumen PDF</p>
                @endif
            </div>
        </div>
        @endforeach

    </div>
@endif


{{-- ══════════════════════════════════════════
     HIDDEN EDIT FORMS (satu per item)
     Disubmit oleh modal konfirmasi edit
══════════════════════════════════════════ --}}
@foreach($proseses as $proses)
<form id="formEdit_{{ $proses->id }}"
      method="POST"
      action="{{ route('bisnis-proses.update', $proses) }}"
      enctype="multipart/form-data"
      class="hidden">
    @csrf
    @method('PUT')
    {{-- Nilai diisi oleh Alpine saat modal submit --}}
    <input type="hidden" name="judul_proses"  :value="editJudul"/>
    <input type="file"   name="file_gambar"   id="hiddenGambar_{{ $proses->id }}"/>
    <input type="file"   name="file_dokumen"  id="hiddenDokumen_{{ $proses->id }}"/>
</form>
@endforeach


{{-- ══════════════════════════════════════════
     MODAL 1: TAMBAH PROSES BARU
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

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10"
        x-show="showTambah"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-0">
            <h2 class="text-lg font-bold text-gray-900">Tambah Proses Baru</h2>
            <button @click="showTambah = false"
                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST"
              action="{{ route('bisnis-proses.store') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="px-6 pt-4 pb-2 space-y-4">

                {{-- Nama Proses --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Nama Proses
                    </label>
                    <input type="text" name="judul_proses" placeholder="Nama Proses" required
                        class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500
                               transition placeholder-gray-400"/>
                    @error('judul_proses')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Gambar --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Unggah Gambar
                        <span class="font-normal text-gray-400">(opsional, jpg/png maks 5MB)</span>
                    </label>
                    <label
                        class="flex flex-col items-center justify-center gap-1 w-full py-4 border
                               border-dashed border-gray-300 rounded-xl cursor-pointer
                               hover:border-brand-400 hover:bg-brand-50/30 transition group"
                        x-show="!previewGambarTambah">
                        <svg class="w-8 h-8 text-gray-300 group-hover:text-brand-400 transition"
                            fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586
                                   a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6
                                   a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs text-gray-400 group-hover:text-brand-600 transition">
                            Klik untuk pilih gambar
                        </span>
                        <input type="file" name="file_gambar" accept="image/*" class="hidden"
                            @change="
                                const f = $event.target.files[0];
                                if(f) previewGambarTambah = URL.createObjectURL(f);
                            "/>
                    </label>

                    {{-- Preview gambar --}}
                    <div x-show="previewGambarTambah" class="relative mt-1">
                        <img :src="previewGambarTambah"
                            class="w-full h-36 object-cover rounded-xl border border-gray-200"/>
                        <button type="button"
                            @click="previewGambarTambah = null; $el.closest('div').previousElementSibling.querySelector('input').value=''"
                            class="absolute top-2 right-2 w-6 h-6 rounded-full bg-red-500 text-white
                                   flex items-center justify-center text-xs shadow">✕</button>
                    </div>

                    @error('file_gambar')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Dokumen PDF --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Unggah Dokumen
                    </label>

                    {{-- Drop zone --}}
                    <label
                        class="flex flex-col items-center justify-center gap-2 w-full py-8 border
                               border-dashed border-gray-300 rounded-xl cursor-pointer
                               hover:border-brand-400 hover:bg-brand-50/30 transition group"
                        x-show="!namaFileTambah">

                        {{-- Icon dokumen upload --}}
                        <svg class="w-12 h-12 text-gray-300 group-hover:text-gray-400 transition"
                            fill="none" viewBox="0 0 24 24">
                            <rect x="4" y="2" width="12" height="16" rx="1.5"
                                  stroke="currentColor" stroke-width="1.5" fill="none"
                                  class="text-gray-300"/>
                            <path d="M12 2v5h5" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" fill="none"/>
                            <path d="M8 13l3-3 3 3" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11 10v5" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round"/>
                        </svg>

                        <span class="text-sm text-gray-500">Tarik &amp; Lepas File Disini</span>

                        <span class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white
                                     border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Pilih File Lokal
                        </span>
                        <span class="text-xs text-gray-400">File Max 10MB</span>

                        <input type="file" name="file_dokumen" accept=".pdf" class="hidden"
                            @change="namaFileTambah = $event.target.files[0]?.name || ''"/>
                    </label>

                    {{-- Nama file terpilih --}}
                    <div x-show="namaFileTambah"
                        class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-100 rounded-xl mt-1">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1
                                     1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                        </svg>
                        <span class="text-xs text-gray-700 truncate flex-1" x-text="namaFileTambah"></span>
                        <button type="button" @click="namaFileTambah = ''"
                            class="text-gray-400 hover:text-red-500 transition text-sm">✕</button>
                    </div>

                    @error('file_dokumen')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <button type="button" @click="showTambah = false"
                    class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border-2
                           border-gray-300 rounded-xl hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-bold text-white bg-brand-800
                           hover:bg-brand-900 rounded-xl shadow-sm transition uppercase tracking-wide">
                    TAMBAH DOKUMEN
                </button>
            </div>
        </form>

    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL 2: EDIT PROSES
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

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10"
        x-show="showEdit"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-0">
            <h2 class="text-lg font-bold text-gray-900">Edit Proses</h2>
            <button @click="showEdit = false"
                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 pt-4 pb-2 space-y-4">

            {{-- Nama Proses --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Proses</label>
                <input type="text" x-model="editJudul" placeholder="Nama Proses"
                    class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500
                           transition placeholder-gray-400"/>
            </div>

            {{-- Upload Dokumen PDF --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                    Unggah Dokumen
                    <span class="font-normal text-gray-400">(biarkan kosong jika tidak ingin mengganti)</span>
                </label>

                <label
                    class="flex flex-col items-center justify-center gap-2 w-full py-8 border
                           border-dashed border-gray-300 rounded-xl cursor-pointer
                           hover:border-brand-400 hover:bg-brand-50/30 transition group"
                    x-show="!namaFileEdit">

                    <svg class="w-12 h-12 text-gray-300 group-hover:text-gray-400 transition"
                        fill="none" viewBox="0 0 24 24">
                        <rect x="4" y="2" width="12" height="16" rx="1.5"
                              stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path d="M12 2v5h5" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" fill="none"/>
                        <path d="M8 13l3-3 3 3" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11 10v5" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round"/>
                    </svg>

                    <span class="text-sm text-gray-500">Tarik &amp; Lepas File Disini</span>
                    <span class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white
                                 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Pilih File Lokal
                    </span>
                    <span class="text-xs text-gray-400">File Max 10MB</span>

                    <input type="file" id="editDokumenInput" accept=".pdf" class="hidden"
                        @change="namaFileEdit = $event.target.files[0]?.name || ''"/>
                </label>

                <div x-show="namaFileEdit"
                    class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-100 rounded-xl mt-1">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1
                                 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                    </svg>
                    <span class="text-xs text-gray-700 truncate flex-1" x-text="namaFileEdit"></span>
                    <button type="button" @click="namaFileEdit = ''; document.getElementById('editDokumenInput').value = ''"
                        class="text-gray-400 hover:text-red-500 transition text-sm">✕</button>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-100">
            <button type="button" @click="showEdit = false"
                class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border-2
                       border-gray-300 rounded-xl hover:bg-gray-50 transition uppercase tracking-wide">
                BATAL
            </button>
            {{-- Trigger modal konfirmasi edit --}}
            <button type="button"
                @click="
                    if(!editJudul.trim()) return;
                    showEdit = false;
                    showKonfirmasiEdit = true;
                "
                class="px-5 py-2.5 text-sm font-bold text-white bg-brand-800
                       hover:bg-brand-900 rounded-xl shadow-sm transition uppercase tracking-wide">
                TAMBAH DOKUMEN
            </button>
        </div>

    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL 3: KONFIRMASI EDIT
══════════════════════════════════════════ --}}
<div x-show="showKonfirmasiEdit" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"
         @click="showKonfirmasiEdit = false; showEdit = true"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 text-center"
        x-show="showKonfirmasiEdit"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100">

        <div class="px-8 py-8">
            <p class="text-base font-semibold text-gray-800 mb-6">
                Anda yakin ingin mengubah proses?
            </p>
            <div class="flex items-center justify-center gap-3">
                <button type="button"
                    @click="showKonfirmasiEdit = false; showEdit = true"
                    class="flex-1 py-2.5 text-sm font-bold text-gray-700 bg-white border-2
                           border-gray-300 rounded-xl hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="button" @click="submitEditForm()"
                    class="flex-1 py-2.5 text-sm font-bold text-white bg-brand-800
                           hover:bg-brand-900 rounded-xl shadow-sm transition uppercase tracking-wide">
                    KONFIRMASI
                </button>
            </div>
        </div>

    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL 4: KONFIRMASI HAPUS
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

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 text-center"
        x-show="showHapus"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100">

        <div class="px-8 py-8">
            <p class="text-base font-semibold text-gray-800 mb-6">
                Anda yakin ingin menghapus proses?
            </p>

            <div class="flex items-center justify-center gap-3">
                <button type="button" @click="showHapus = false"
                    class="flex-1 py-2.5 text-sm font-bold text-gray-700 bg-white border-2
                           border-gray-300 rounded-xl hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>

                <form method="POST"
                      :action="`{{ url('dashboard/bisnis-proses') }}/${hapusId}`"
                      class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full py-2.5 text-sm font-bold text-white bg-brand-800
                               hover:bg-brand-900 rounded-xl shadow-sm transition uppercase tracking-wide">
                        KONFIRMASI
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>


{{-- ── Client-side search ── --}}
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const kw    = this.value.toLowerCase();
        const cards = document.querySelectorAll('.proses-card');
        cards.forEach(card => {
            const judul = card.dataset.judul || '';
            card.style.display = judul.includes(kw) ? '' : 'none';
        });
    });
</script>

</div>{{-- end x-data --}}
@endsection