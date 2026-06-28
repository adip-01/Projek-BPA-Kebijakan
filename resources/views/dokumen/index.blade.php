@extends('layouts.app')

@section('title', 'Pusat Arsip Dokumen')

@section('content')
<div class="px-4 py-6 md:px-8">
    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Page Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pusat Arsip Dokumen</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola semua kebijakan, pedoman, dan panduan akademik.</p>
        </div>

        {{-- ===== ACTION BAR ===== --}}
        <form method="GET" action="{{ route('dokumen.index') }}">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                    {{-- Search --}}
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari dokumen..."
                               class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-9 pr-3 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100 sm:w-64">
                    </div>

                    {{-- Filter Kategori --}}
                    <div class="relative">
                        <select name="category"
                                class="w-full cursor-pointer appearance-none rounded-lg border border-gray-200 bg-white py-2.5 pl-3.5 pr-9 text-sm font-medium text-gray-600 outline-none transition-colors hover:bg-gray-50 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                            <option value="">Kategori</option>
                            @foreach(['Panduan','Pedoman','Buletin','RPS','Petunjuk Teknis','Peraturan Univ','Template','SOP','Kebijakan'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                    </div>

                    {{-- Filter Pemilik --}}
                    <div class="relative">
                        <select name="owner"
                                class="w-full cursor-pointer appearance-none rounded-lg border border-gray-200 bg-white py-2.5 pl-3.5 pr-9 text-sm font-medium text-gray-600 outline-none transition-colors hover:bg-gray-50 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                            <option value="">Pemilik</option>
                            <option value="Internal BPA"  {{ request('owner') === 'Internal BPA'  ? 'selected' : '' }}>Internal BPA</option>
                            <option value="Eksternal BPA" {{ request('owner') === 'Eksternal BPA' ? 'selected' : '' }}>Eksternal BPA</option>
                        </select>
                        <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                    </div>

                    {{-- Filter Status --}}
                    <div class="relative">
                        <select name="status"
                                class="w-full cursor-pointer appearance-none rounded-lg border border-gray-200 bg-white py-2.5 pl-3.5 pr-9 text-sm font-medium text-gray-600 outline-none transition-colors hover:bg-gray-50 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                            <option value="">Status</option>
                            <option value="Aktif"       {{ request('status') === 'Aktif'       ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ request('status') === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                    </div>

                    <button type="submit"
                            class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                        Filter
                    </button>
                </div>

                <a href="{{ route('dokumen.create') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-800 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-red-900">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Tambah Dokumen
                </a>
            </div>
        </form>

        {{-- ===== DOCUMENT TABLE ===== --}}
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1080px] text-left">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/60">
                            @foreach(['Dokumen','Kategori & Pemilik','Tgl Efektif','Klausul','Versi & Status','Tautan & Aksi'] as $header)
                                <th class="whitespace-nowrap px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($documents as $doc)
                            <tr class="transition-colors hover:bg-gray-50/60">
                                {{-- Dokumen --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50">
                                            <i data-lucide="file-text" class="h-5 w-5 text-red-700"></i>
                                        </span>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $doc->title }}</p>
                                            <p class="text-xs text-gray-400">{{ $doc->number ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori & Pemilik --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">
                                        {{ $doc->category }}
                                    </span>
                                    <p class="mt-1.5 text-xs text-gray-500">{{ $doc->owner }}</p>
                                </td>

                                {{-- Tgl Efektif --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ $doc->formatted_effective_date }}
                                </td>

                                {{-- Klausul --}}
                                <td class="px-6 py-4">
                                    <p class="max-w-[200px] truncate text-sm text-gray-500" title="{{ $doc->klausul }}">
                                        {{ $doc->klausul ?? '—' }}
                                    </p>
                                </td>

                                {{-- Versi & Status --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-700">{{ $doc->version }}</span>
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium
                                            {{ $doc->status === 'Aktif' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $doc->status === 'Aktif' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                            {{ $doc->status }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Tautan & Aksi --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1 whitespace-nowrap">
                                        @if($doc->link)
                                            <a href="{{ $doc->link }}" target="_blank"
                                               class="rounded-md p-2 text-red-700 transition-colors hover:bg-red-50">
                                                <i data-lucide="link-2" class="h-4 w-4"></i>
                                            </a>
                                        @endif

                                        @if($doc->file_path)
                                            <a href="{{ route('dokumen.download', $doc) }}"
                                               class="rounded-md p-2 text-blue-600 transition-colors hover:bg-blue-50">
                                                <i data-lucide="download" class="h-4 w-4"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('dokumen.edit', $doc) }}"
                                           class="rounded-md p-2 text-gray-500 transition-colors hover:bg-gray-100">
                                            <i data-lucide="pencil" class="h-4 w-4"></i>
                                        </a>

                                        <form action="{{ route('dokumen.destroy', $doc) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-md p-2 text-red-600 transition-colors hover:bg-red-50">
                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400">
                                        <i data-lucide="file-x" class="h-12 w-12"></i>
                                        <p class="text-sm">Tidak ada dokumen ditemukan.</p>
                                        <a href="{{ route('dokumen.create') }}"
                                           class="mt-1 inline-flex items-center gap-2 rounded-lg bg-red-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-900">
                                            <i data-lucide="plus" class="h-4 w-4"></i> Tambah Dokumen
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===== PAGINATION ===== --}}
            @if($documents->hasPages())
                <div class="flex flex-col items-center justify-between gap-3 border-t border-gray-100 px-6 py-4 sm:flex-row">
                    <p class="text-sm text-gray-500">
                        Menampilkan
                        <span class="font-medium text-gray-700">{{ $documents->firstItem() }}–{{ $documents->lastItem() }}</span>
                        dari <span class="font-medium text-gray-700">{{ $documents->total() }}</span> dokumen
                    </p>
                    <div class="flex items-center gap-1">
                        {{-- Previous --}}
                        @if($documents->onFirstPage())
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed">
                                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                            </span>
                        @else
                            <a href="{{ $documents->previousPageUrl() }}"
                               class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-400 transition-colors hover:bg-gray-50">
                                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                            <a href="{{ $url }}"
                               class="flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium transition-colors
                                   {{ $page == $documents->currentPage() ? 'bg-red-800 text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                                {{ $page }}
                            </a>
                        @endforeach

                        {{-- Next --}}
                        @if($documents->hasMorePages())
                            <a href="{{ $documents->nextPageUrl() }}"
                               class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition-colors hover:bg-gray-50">
                                <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            </a>
                        @else
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed">
                                <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
