@extends('layouts.admin')

@section('title', 'Daftar Admin')
@section('breadcrumb', 'Admin')

@section('content')

{{-- ════════════════════════════════════════
     ALPINE STATE untuk semua modal
════════════════════════════════════════ --}}
<div
    x-data="{
        showTambah: false,
        showEdit:   false,
        showHapus:  false,

        editId:    null,
        editName:  '',
        editEmail: '',
        editRole:  'admin',

        hapusId:   null,
        hapusName: '',

        openEdit(id, name, email, role) {
            this.editId    = id;
            this.editName  = name;
            this.editEmail = email;
            this.editRole  = role;
            this.showEdit  = true;
        },
        openHapus(id, name) {
            this.hapusId   = id;
            this.hapusName = name;
            this.showHapus = true;
        }
    }"
>

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-xl">
        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-xl">
        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
@endif

{{-- ── Page Title ── --}}
<div class="mb-6">
    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Daftar Admin</h1>
    <p class="text-gray-500 mt-1 text-sm">Kelola seluruh Admin di sini.</p>
</div>

{{-- ── Stat Card ── --}}
<div class="mb-6">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm inline-flex items-center gap-4 px-6 py-4 min-w-[200px]">
        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Admin</p>
            <p class="text-3xl font-extrabold text-gray-900 leading-tight">
                {{ str_pad($totalAdmin, 2, '0', STR_PAD_LEFT) }}
            </p>
        </div>
    </div>
</div>

{{-- ── Action Bar ── --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-5">
    {{-- Search --}}
    <div class="relative flex-1 max-w-xs">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Cari Nama Admin..."
            class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition placeholder-gray-400"/>
    </div>

    {{-- Filter button --}}
    <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
        Filter
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 8h10M11 12h2M9 16h6"/>
        </svg>
    </button>

    {{-- Spacer --}}
    <div class="flex-1"></div>

    {{-- Tambah Admin --}}
    <button @click="showTambah = true"
        class="flex items-center gap-2 bg-brand-800 hover:bg-brand-900 active:bg-brand-900 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        TAMBAH ADMIN
    </button>
</div>

{{-- ── Tabel ── --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

    {{-- Info count --}}
    <div class="px-5 py-3 border-b border-gray-100">
        <p class="text-sm text-gray-600">
            Menampilkan <span class="font-semibold">{{ $admins->count() }}</span> dari
            <span class="font-semibold">{{ $admins->total() }}</span> Admin
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="adminTable">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Nama</th>
                    <th class="text-left px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="text-left px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Role</th>
                    <th class="text-center px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="adminTableBody">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50 transition-colors admin-row">
                    {{-- Nama --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-gray-800 admin-name">{{ $admin->name }}</span>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-4 py-3.5">
                        <a href="mailto:{{ $admin->email }}" class="text-gray-600 underline underline-offset-2 hover:text-brand-700 transition admin-email">
                            {{ $admin->email }}
                        </a>
                    </td>

                    {{-- Role --}}
                    <td class="px-4 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-brand-800 text-white uppercase tracking-wide">
                            {{ strtoupper($admin->role ?? 'admin') }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Edit --}}
                            <button
                                @click="openEdit({{ $admin->id }}, '{{ addslashes($admin->name) }}', '{{ $admin->email }}', '{{ $admin->role ?? 'admin' }}')"
                                class="px-3.5 py-1.5 text-xs font-semibold text-blue-600 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition">
                                Edit
                            </button>

                            {{-- Hapus --}}
                            <button
                                @click="openHapus({{ $admin->id }}, '{{ addslashes($admin->name) }}')"
                                class="px-3.5 py-1.5 text-xs font-semibold text-red-600 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-gray-400 text-sm">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Belum ada data admin.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-xs text-gray-500">
            Halaman <span class="font-semibold">{{ $admins->currentPage() }}</span>
            dari <span class="font-semibold">{{ $admins->lastPage() }}</span>
        </p>
        {{-- Laravel pagination links --}}
        <div class="flex items-center gap-1">
            @if($admins->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center text-gray-300 text-sm">‹</span>
            @else
                <a href="{{ $admins->previousPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm transition">‹</a>
            @endif

            @foreach($admins->getUrlRange(1, $admins->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold transition
                       {{ $page == $admins->currentPage()
                           ? 'bg-brand-800 text-white shadow-sm'
                           : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                    {{ $page }}
                </a>
            @endforeach

            @if($admins->hasMorePages())
                <a href="{{ $admins->nextPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm transition">›</a>
            @else
                <span class="w-8 h-8 flex items-center justify-center text-gray-300 text-sm">›</span>
            @endif
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════
     MODAL 1: TAMBAH ADMIN
════════════════════════════════════════════════ --}}
<div x-show="showTambah" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px]" @click="showTambah = false"></div>

    {{-- Modal card --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md modal-enter z-10"
        x-show="showTambah"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Tambah Admin</h2>
            <button @click="showTambah = false"
                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('admins.store') }}">
            @csrf
            <div class="px-6 py-4 space-y-4">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="nama lengkap" required
                        class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition placeholder-gray-400"/>
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="email" required
                            class="w-full px-3.5 py-2.5 pr-10 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition placeholder-gray-400"/>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Password & Konfirmasi --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition"/>
                        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition"/>
                    </div>
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Role</label>
                    <div class="relative">
                        <select name="role"
                            class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition bg-white appearance-none text-gray-700">
                            <option value="admin">Admin</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 rounded-full bg-gray-300 pointer-events-none"></div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 pb-6 pt-2 flex items-center justify-end gap-3 border-t border-gray-100 mt-2">
                <button type="button" @click="showTambah = false"
                    class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-brand-800 hover:bg-brand-900 rounded-xl shadow-sm transition uppercase tracking-wide">
                    KONFIRMASI
                </button>
            </div>
        </form>

    </div>
</div>


{{-- ════════════════════════════════════════════════
     MODAL 2: EDIT ADMIN
════════════════════════════════════════════════ --}}
<div x-show="showEdit" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px]" @click="showEdit = false"></div>

    {{-- Modal card --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10"
        x-show="showEdit"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Edit Admin</h2>
            <button @click="showEdit = false"
                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" :action="`{{ url('dashboard/admins') }}/${editId}`">
            @csrf
            @method('PUT')
            <div class="px-6 py-4 space-y-4">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" :value="editName" required
                        class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition"/>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <input type="email" name="email" :value="editEmail" required
                            class="w-full px-3.5 py-2.5 pr-10 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition"/>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Password & Konfirmasi --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Password
                            <span class="font-normal text-gray-400">(kosongkan jika tidak diganti)</span>
                        </label>
                        <input type="password" name="password"
                            class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition"/>
                    </div>
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Role</label>
                    <div class="relative">
                        <select name="role" :value="editRole"
                            x-effect="$el.value = editRole"
                            class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-500 transition bg-white appearance-none text-gray-700">
                            <option value="admin">Admin</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 rounded-full bg-gray-300 pointer-events-none"></div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 pb-6 pt-2 flex items-center justify-end gap-3 border-t border-gray-100 mt-2">
                <button type="button" @click="showEdit = false"
                    class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-brand-800 hover:bg-brand-900 rounded-xl shadow-sm transition uppercase tracking-wide">
                    KONFIRMASI
                </button>
            </div>
        </form>

    </div>
</div>


{{-- ════════════════════════════════════════════════
     MODAL 3: HAPUS ADMIN
════════════════════════════════════════════════ --}}
<div x-show="showHapus" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px]" @click="showHapus = false"></div>

    {{-- Modal card --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 text-center"
        x-show="showHapus"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100">

        <div class="px-8 py-8">
            <p class="text-base font-semibold text-gray-800 mb-6">
                Anda yakin ingin menghapus admin
                <span class="text-brand-800" x-text="'&quot;' + hapusName + '&quot;'"></span>?
            </p>

            <div class="flex items-center justify-center gap-3">
                <button type="button" @click="showHapus = false"
                    class="flex-1 py-2.5 text-sm font-bold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 transition uppercase tracking-wide">
                    BATAL
                </button>

                {{-- Form hapus --}}
                <form method="POST" :action="`{{ url('dashboard/admins') }}/${hapusId}`" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full py-2.5 text-sm font-bold text-white bg-brand-800 hover:bg-brand-900 rounded-xl shadow-sm transition uppercase tracking-wide">
                        KONFIRMASI
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

</div>{{-- end x-data wrapper --}}


{{-- ── Client-side search (bonus) ── --}}
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const rows    = document.querySelectorAll('#adminTableBody .admin-row');
        rows.forEach(row => {
            const name  = row.querySelector('.admin-name')?.textContent.toLowerCase() || '';
            const email = row.querySelector('.admin-email')?.textContent.toLowerCase() || '';
            row.style.display = (name.includes(keyword) || email.includes(keyword)) ? '' : 'none';
        });
    });
</script>

@endsection