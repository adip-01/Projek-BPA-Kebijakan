<?php $__env->startSection('title', 'Kelola Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="px-4 py-6 md:px-8 md:py-8">
    <div class="mx-auto max-w-6xl">

        
        <div class="mb-1">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Admin</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola hak akses pengguna dan persetujuan pendaftaran admin baru.</p>
        </div>

        
        <div class="mb-6 mt-6 flex flex-wrap items-center justify-between gap-3">
            <form method="GET" action="<?php echo e(route('admin.index')); ?>" class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                    <input type="search" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Cari nama atau email..."
                           class="w-64 rounded-lg border border-gray-300 bg-white py-2 pl-9 pr-3 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-800 focus:ring-2 focus:ring-red-800/20">
                </div>
                <div class="relative">
                    <select name="status"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 outline-none transition-colors focus:border-red-800 focus:ring-2 focus:ring-red-800/20">
                        <option value="">Semua Status</option>
                        <option value="Aktif"   <?php echo e(request('status') === 'Aktif'   ? 'selected' : ''); ?>>Aktif</option>
                        <option value="Pending" <?php echo e(request('status') === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                    </select>
                </div>
                <button type="submit" class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Filter</button>
            </form>

            <button type="button" onclick="document.getElementById('modal-add-admin').classList.remove('hidden')"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-900">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Tambah Admin
            </button>
        </div>

        
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            <th class="px-6 py-3">Nama Lengkap</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Peran</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Tanggal Bergabung</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transition-colors hover:bg-gray-50/60">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-red-800 text-xs font-semibold text-white">
                                            <?php echo e($admin->initials); ?>

                                        </span>
                                        <span class="font-semibold text-gray-800"><?php echo e($admin->name); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?php echo e($admin->email); ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                        <?php echo e($admin->role); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($admin->status === 'Aktif'): ?>
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">Aktif</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?php echo e($admin->formatted_joined); ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <?php if($admin->status === 'Pending'): ?>
                                            <form action="<?php echo e(route('admin.approve', $admin)); ?>" method="POST">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                <button type="submit"
                                                        title="Setujui admin"
                                                        class="grid h-8 w-8 place-items-center rounded-md bg-green-600 text-white transition-colors hover:bg-green-700">
                                                    <i data-lucide="check" class="h-4 w-4"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <button type="button"
                                                onclick="openEditAdminModal(<?php echo e($admin->id); ?>, '<?php echo e(addslashes($admin->name)); ?>', '<?php echo e($admin->email); ?>', '<?php echo e($admin->role); ?>', '<?php echo e($admin->status); ?>')"
                                                class="grid h-8 w-8 cursor-pointer place-items-center rounded-md text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700">
                                            <i data-lucide="pencil" class="h-4 w-4"></i>
                                        </button>
                                        <form action="<?php echo e(route('admin.destroy', $admin)); ?>" method="POST"
                                              onsubmit="return confirm('Hapus admin ini?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="grid h-8 w-8 place-items-center rounded-md text-red-500 transition-colors hover:bg-red-50 hover:text-red-700">
                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                    Tidak ada admin ditemukan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<div id="modal-add-admin" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"
         onclick="document.getElementById('modal-add-admin').classList.add('hidden')"></div>
    <div class="relative z-10 w-full max-w-md rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">Tambah Admin Baru</h2>
            <button type="button" onclick="document.getElementById('modal-add-admin').classList.add('hidden')"
                    class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        <form action="<?php echo e(route('admin.store')); ?>" method="POST" class="px-6 py-5 space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label for="add-name" class="mb-1.5 block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-600">*</span></label>
                <input id="add-name" name="name" type="text" placeholder="Contoh: Budi Santoso"
                       class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
            </div>
            <div>
                <label for="add-email" class="mb-1.5 block text-sm font-medium text-gray-700">Email <span class="text-red-600">*</span></label>
                <input id="add-email" name="email" type="email" placeholder="budi@univ.edu"
                       class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
            </div>
            <div>
                <label for="add-role" class="mb-1.5 block text-sm font-medium text-gray-700">Peran <span class="text-red-600">*</span></label>
                <div class="relative">
                    <select id="add-role" name="role"
                            class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
                        <option value="Admin BPA">Admin BPA</option>
                        <option value="Admin Fakultas">Admin Fakultas</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                    <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label for="add-status" class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                <div class="relative">
                    <select id="add-status" name="status"
                            class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
                        <option value="Aktif">Aktif</option>
                        <option value="Pending">Pending</option>
                    </select>
                    <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-add-admin').classList.add('hidden')"
                        class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit"
                        class="rounded-lg bg-red-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-900">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div id="modal-edit-admin" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"
         onclick="document.getElementById('modal-edit-admin').classList.add('hidden')"></div>
    <div class="relative z-10 w-full max-w-md rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">Edit Admin</h2>
            <button type="button" onclick="document.getElementById('modal-edit-admin').classList.add('hidden')"
                    class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        <form id="edit-admin-form" action="" method="POST" class="px-6 py-5 space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div>
                <label for="edit-name" class="mb-1.5 block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input id="edit-name" name="name" type="text"
                       class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
            </div>
            <div>
                <label for="edit-email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                <input id="edit-email" name="email" type="email"
                       class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
            </div>
            <div>
                <label for="edit-role" class="mb-1.5 block text-sm font-medium text-gray-700">Peran</label>
                <div class="relative">
                    <select id="edit-role" name="role"
                            class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
                        <option value="Admin BPA">Admin BPA</option>
                        <option value="Admin Fakultas">Admin Fakultas</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                    <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label for="edit-status" class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                <div class="relative">
                    <select id="edit-status" name="status"
                            class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
                        <option value="Aktif">Aktif</option>
                        <option value="Pending">Pending</option>
                    </select>
                    <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-edit-admin').classList.add('hidden')"
                        class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit"
                        class="rounded-lg bg-red-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-900">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function openEditAdminModal(id, name, email, role, status) {
        document.getElementById('edit-name').value   = name;
        document.getElementById('edit-email').value  = email;
        document.getElementById('edit-role').value   = role;
        document.getElementById('edit-status').value = status;
        document.getElementById('edit-admin-form').action = '/admin/' + id;
        document.getElementById('modal-edit-admin').classList.remove('hidden');
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (3)\SIMKEB\resources\views/admin/index.blade.php ENDPATH**/ ?>