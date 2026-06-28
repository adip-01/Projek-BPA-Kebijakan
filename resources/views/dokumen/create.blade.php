@extends('layouts.app')

@section('title', 'Tambah Dokumen Baru')

@section('content')
<div class="px-4 py-6 md:px-8">
    <div class="mx-auto max-w-3xl">

        {{-- Breadcrumb --}}
        <nav class="mb-4 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('dokumen.index') }}" class="hover:text-red-800 transition-colors">Dokumen</a>
            <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            <span class="text-gray-900 font-medium">Tambah Dokumen Baru</span>
        </nav>

        {{-- Form Card --}}
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-800">
                        <i data-lucide="file-plus" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Tambah Dokumen Baru</h2>
                        <p class="text-xs text-gray-500">Isi semua kolom yang diperlukan dengan benar</p>
                    </div>
                </div>
            </div>

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mx-6 mt-5 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 shrink-0 text-red-600"></i>
                        <div>
                            <p class="text-sm font-semibold text-red-800 mb-1">Terdapat kesalahan pada form:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm text-red-700">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-x-5 gap-y-4 px-6 py-6 sm:grid-cols-2">

                    {{-- Judul Dokumen - full width --}}
                    <div class="sm:col-span-2">
                        <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Judul Dokumen <span class="text-red-600">*</span>
                        </label>
                        <input id="title" name="title" type="text"
                               value="{{ old('title') }}"
                               placeholder="Masukkan judul dokumen"
                               class="w-full rounded-lg border {{ $errors->has('title') ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200' }} px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                    </div>

                    {{-- Nomor Dokumen --}}
                    <div>
                        <label for="number" class="mb-1.5 block text-sm font-medium text-gray-700">Nomor Dokumen</label>
                        <input id="number" name="number" type="text"
                               value="{{ old('number') }}"
                               placeholder="BPA/PND/2026/001"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="category" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Kategori <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <select id="category" name="category"
                                    class="w-full appearance-none rounded-lg border {{ $errors->has('category') ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200' }} bg-white px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- Pemilik --}}
                    <div>
                        <label for="owner" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Pemilik Dokumen <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <select id="owner" name="owner"
                                    class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                                <option value="" disabled {{ old('owner') ? '' : 'selected' }}>Pilih pemilik</option>
                                <option value="Internal BPA"  {{ old('owner') === 'Internal BPA'  ? 'selected' : '' }}>Internal BPA</option>
                                <option value="Eksternal BPA" {{ old('owner') === 'Eksternal BPA' ? 'selected' : '' }}>Eksternal BPA</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- Tanggal Efektif --}}
                    <div>
                        <label for="effective_date" class="mb-1.5 block text-sm font-medium text-gray-700">Tanggal Efektif</label>
                        <input id="effective_date" name="effective_date" type="date"
                               value="{{ old('effective_date') }}"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                    </div>

                    {{-- Versi --}}
                    <div>
                        <label for="version" class="mb-1.5 block text-sm font-medium text-gray-700">Versi Dokumen</label>
                        <input id="version" name="version" type="text"
                               value="{{ old('version', 'v1.0') }}"
                               placeholder="v1.0"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                        <div class="relative">
                            <select id="status" name="status"
                                    class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                                <option value="Aktif"       {{ old('status', 'Aktif') === 'Aktif'       ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status') === 'Tidak Aktif'           ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- Deskripsi / Ringkasan - full width --}}
                    <div class="sm:col-span-2">
                        <label for="description" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Deskripsi / Ringkasan
                            <span class="font-normal text-gray-400">(Opsional)</span>
                        </label>
                        <textarea id="description" name="description" rows="3"
                                  placeholder="Tuliskan ringkasan singkat tentang dokumen ini..."
                                  class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100 resize-none">{{ old('description') }}</textarea>
                    </div>

                    {{-- Klausul - full width --}}
                    <div class="sm:col-span-2">
                        <label for="klausul" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Klausul
                            <span class="font-normal text-gray-400">(Opsional)</span>
                        </label>
                        <textarea id="klausul" name="klausul" rows="3"
                                  placeholder="Tuliskan klausul terkait dokumen..."
                                  class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100 resize-none">{{ old('klausul') }}</textarea>
                    </div>

                    {{-- Link Dokumen - full width --}}
                    <div class="sm:col-span-2">
                        <label for="link" class="mb-1.5 block text-sm font-medium text-gray-700">Link Dokumen</label>
                        <div class="relative">
                            <i data-lucide="link-2" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                            <input id="link" name="link" type="url"
                                   value="{{ old('link') }}"
                                   placeholder="https://drive.example.com/dokumen"
                                   class="w-full rounded-lg border border-gray-200 pl-9 pr-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                        </div>
                    </div>

                    {{-- ===== FILE UPLOAD - full width ===== --}}
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Upload File Dokumen
                            <span class="font-normal text-gray-400">(PDF, Word, Excel, PPT — maks. 20 MB)</span>
                        </label>

                        {{-- Drop Zone --}}
                        <label for="document_file"
                               id="drop-zone"
                               class="group relative flex w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center transition-colors hover:border-red-400 hover:bg-red-50">

                            {{-- Upload Icon --}}
                            <div id="upload-icon-wrapper"
                                 class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-gray-200 group-hover:ring-red-200 transition-all">
                                <i data-lucide="upload-cloud" class="h-7 w-7 text-gray-400 group-hover:text-red-700 transition-colors"></i>
                            </div>

                            <p id="upload-label-main" class="text-sm font-semibold text-gray-700 group-hover:text-red-800">
                                Klik untuk memilih file
                            </p>
                            <p id="upload-label-sub" class="mt-1 text-xs text-gray-400">
                                atau drag &amp; drop file ke sini
                            </p>

                            {{-- Accepted formats badge --}}
                            <div class="mt-4 flex flex-wrap justify-center gap-2">
                                @foreach(['PDF', 'DOC', 'DOCX', 'XLS', 'XLSX', 'PPT', 'PPTX'] as $ext)
                                    <span class="rounded-full bg-white px-2.5 py-1 text-xs font-medium text-gray-500 ring-1 ring-gray-200">
                                        .{{ strtolower($ext) }}
                                    </span>
                                @endforeach
                            </div>

                            {{-- Hidden file input --}}
                            <input id="document_file" name="document_file" type="file"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                                   class="sr-only">
                        </label>

                        {{-- File Preview (shown after selection) --}}
                        <div id="file-preview" class="hidden mt-3 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-700">
                                <i data-lucide="file-check" class="h-5 w-5"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p id="file-name" class="text-sm font-semibold text-green-800 truncate"></p>
                                <p id="file-size" class="text-xs text-green-600"></p>
                            </div>
                            <button type="button" id="remove-file"
                                    class="rounded-md p-1 text-green-600 hover:bg-green-100 transition-colors">
                                <i data-lucide="x" class="h-4 w-4"></i>
                            </button>
                        </div>

                        @error('document_file')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="h-3.5 w-3.5"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- ===== FORM FOOTER ===== --}}
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 bg-gray-50/60 px-6 py-4">
                    <a href="{{ route('dokumen.index') }}"
                       class="rounded-lg border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-red-800 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-700 focus:ring-offset-2">
                        <i data-lucide="save" class="h-4 w-4"></i>
                        Simpan Dokumen
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const fileInput   = document.getElementById('document_file');
    const dropZone    = document.getElementById('drop-zone');
    const filePreview = document.getElementById('file-preview');
    const fileName    = document.getElementById('file-name');
    const fileSize    = document.getElementById('file-size');
    const removeBtn   = document.getElementById('remove-file');

    function formatBytes(bytes) {
        if (bytes < 1024)       return bytes + ' B';
        if (bytes < 1048576)    return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function showPreview(file) {
        fileName.textContent    = file.name;
        fileSize.textContent    = formatBytes(file.size);
        filePreview.classList.remove('hidden');
        filePreview.classList.add('flex');
        dropZone.classList.add('border-green-400', 'bg-green-50');
        dropZone.classList.remove('border-gray-300', 'bg-gray-50');
    }

    function clearFile() {
        fileInput.value         = '';
        filePreview.classList.add('hidden');
        filePreview.classList.remove('flex');
        dropZone.classList.remove('border-green-400', 'bg-green-50');
        dropZone.classList.add('border-gray-300', 'bg-gray-50');
    }

    fileInput.addEventListener('change', (e) => {
        if (e.target.files[0]) showPreview(e.target.files[0]);
    });

    removeBtn.addEventListener('click', (e) => {
        e.preventDefault();
        clearFile();
    });

    // Drag & drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-red-500', 'bg-red-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-red-500', 'bg-red-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-red-500', 'bg-red-50');
        const dt   = e.dataTransfer;
        const file = dt.files[0];
        if (file) {
            // Attach to input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            showPreview(file);
        }
    });
</script>
@endpush
