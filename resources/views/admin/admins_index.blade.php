@extends('layouts.admin-base')

@section('title', 'Daftar Admin')

@section('content')
<!-- FULL PAGE CONTENT -->
<div class="flex-1 ml-64 flex flex-col">
    <!-- HEADER ATAS -->
    <div class="bg-white border-b border-gray-200 px-8 py-4 sticky top-0 z-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                </svg>
                <span class="text-gray-700 font-medium">Admin</span>
            </div>
        </div>
    </div>

    <!-- PAGE CONTENT -->
    <div class="flex-1 overflow-auto">
        <div class="p-8">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Admin</h1>
                <p class="text-gray-600">Kelola seluruh Admin di sini.</p>
            </div>

            <!-- Statistik Card -->
            <div class="mb-8">
                <div class="w-64 bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm font-medium uppercase tracking-wide">Total Admin</p>
                            <p class="text-4xl font-bold text-gray-900 mt-2">{{ str_pad($totalAdmins, 2, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 19H9a6 6 0 016-6h0a6 6 0 016 6v1a6 6 0 01-6 6H9a6 6 0 01-6-6v-1a6 6 0 016-6h0a6 6 0 016 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="flex items-center justify-between mb-8">
                <!-- Search & Filter -->
                <div class="flex items-center gap-3">
                    <div class="relative flex-1">
                        <input type="text" id="searchInput" placeholder="Cari Nama Admin..." class="w-64 px-4 py-2 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent">
                    </div>
                    <button class="px-4 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 transition text-sm font-medium">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </button>
                </div>

                <!-- Add Button -->
                <button @click="openAddModal = true" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 transition font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    TAMBAH ADMIN
                </button>
            </div>

            <!-- Pesan Alert -->
            @if ($message = Session::get('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    {{ $message }}
                </div>
            @endif

            <!-- Data Tabel -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold text-sm">
                                            {{ substr($admin->name, 0, 1) }}
                                        </div>
                                        <span class="text-gray-900 text-sm font-medium">{{ $admin->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="mailto:{{ $admin->email }}" class="text-gray-600 text-sm underline hover:text-gray-900">{{ $admin->email }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 bg-red-800 text-white text-xs font-bold rounded">ADMIN</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button @click="editAdmin({{ json_encode($admin) }})" class="text-blue-600 hover:text-blue-900 text-sm font-medium transition">Edit</button>
                                        <button @click="openDeleteModal = true; deleteAdminId = {{ $admin->id }}" class="text-red-600 hover:text-red-900 text-sm font-medium transition">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-sm">
                                    Tidak ada admin yang ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Menampilkan {{ $admins->count() }} dari {{ $totalAdmins }} Admin
                    </p>
                    <div class="flex items-center gap-2">
                        @if ($admins->lastPage() > 1)
                            <p class="text-sm text-gray-600">
                                Halaman {{ $admins->currentPage() }} dari {{ $admins->lastPage() }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH ADMIN -->
<div x-show="openAddModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" @click.self="openAddModal = false" style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Tambah Admin</h2>
            <button @click="openAddModal = false" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Nama Lengkap" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                    @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" placeholder="email@example.com" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                    @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent @error('password') border-red-500 @enderror" required>
                    @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent" required>
                        <option value="admin" selected>Admin</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" @click="openAddModal = false" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">BATAL</button>
                <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 transition font-medium">KONFIRMASI</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT ADMIN -->
<div x-show="openEditModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" @click.self="openEditModal = false" style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Edit Admin</h2>
            <button @click="openEditModal = false" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="editName" placeholder="Nama Lengkap" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="editEmail" placeholder="email@example.com" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password (Kosongkan jika tidak ingin ubah)</label>
                    <input type="password" name="password" id="editPassword" placeholder="Minimal 8 karakter" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="editPasswordConfirmation" placeholder="Konfirmasi Password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" id="editRole" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-transparent" required>
                        <option value="admin" selected>Admin</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" @click="openEditModal = false" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">BATAL</button>
                <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 transition font-medium">KONFIRMASI</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS ADMIN -->
<div x-show="openDeleteModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" @click.self="openDeleteModal = false" style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-8 text-center">
        <div class="mb-6 flex justify-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
        </div>

        <h2 class="text-xl font-bold text-gray-900 mb-4">Anda yakin ingin menghapus admin?</h2>
        <p class="text-gray-600 text-sm mb-8">Tindakan ini tidak dapat dibatalkan. Data admin akan dihapus secara permanen.</p>

        <div class="flex items-center justify-center gap-3">
            <button @click="openDeleteModal = false" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">BATAL</button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 transition font-medium">KONFIRMASI</button>
            </form>
        </div>
    </div>
</div>

<script>
    function adminPage() {
        return {
            openAddModal: false,
            openEditModal: false,
            openDeleteModal: false,
            deleteAdminId: null,

            editAdmin(admin) {
                document.getElementById('editName').value = admin.name;
                document.getElementById('editEmail').value = admin.email;
                document.getElementById('editRole').value = admin.role;
                document.getElementById('editForm').action = `/admin/admins/${admin.id}`;
                this.openEditModal = true;
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                const dataEl = document.querySelector('[x-data="adminPage()"]');
                if (dataEl && dataEl.__x && dataEl.__x.data) {
                    const data = dataEl.__x.data();
                    if (data && data.deleteAdminId) {
                        this.action = `/admin/admins/${data.deleteAdminId}`;
                    }
                }
            });
        }
    });
</script>
@endsection
