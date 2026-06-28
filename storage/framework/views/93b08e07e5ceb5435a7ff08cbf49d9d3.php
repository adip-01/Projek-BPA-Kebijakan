<?php $__env->startSection('title', 'Proses Bisnis'); ?>

<?php $__env->startSection('content'); ?>
<div class="px-4 py-6 md:px-8 md:py-8">
    <div class="mx-auto max-w-6xl">

        
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-bold text-gray-800">Proses Bisnis</h1>
            <button type="button" onclick="document.getElementById('modal-add-process').classList.remove('hidden')"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-900">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Tambah Proses
            </button>
        </div>

        
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__empty_1 = true; $__currentLoopData = $processes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $process): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    
                    <div class="flex h-48 items-center justify-center bg-gray-100 overflow-hidden">
                        <?php if($process->image_path): ?>
                            <img src="<?php echo e(Storage::url($process->image_path)); ?>"
                                 alt="<?php echo e($process->title); ?>"
                                 class="h-full w-full object-cover">
                        <?php else: ?>
                            <i data-lucide="image" class="h-12 w-12 text-gray-300" stroke-width="1.5"></i>
                        <?php endif; ?>
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-gray-800"><?php echo e($process->title); ?></h3>
                        <?php if($process->description): ?>
                            <p class="mt-1 text-sm text-gray-500 line-clamp-2"><?php echo e($process->description); ?></p>
                        <?php endif; ?>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs text-gray-400">Diperbarui <?php echo e($process->updated_at->diffForHumans()); ?></span>
                            <div class="flex items-center gap-1">
                                <button type="button"
                                        onclick="openEditModal(<?php echo e($process->id); ?>, '<?php echo e(addslashes($process->title)); ?>', '<?php echo e(addslashes($process->description ?? '')); ?>')"
                                        class="grid h-8 w-8 cursor-pointer place-items-center rounded-md text-gray-500 transition-colors hover:bg-gray-50 hover:text-red-800">
                                    <i data-lucide="pencil" class="h-4 w-4"></i>
                                </button>
                                <form action="<?php echo e(route('proses-bisnis.destroy', $process)); ?>" method="POST"
                                      onsubmit="return confirm('Hapus proses bisnis ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="grid h-8 w-8 place-items-center rounded-md text-gray-500 transition-colors hover:bg-gray-50 hover:text-red-800">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 flex flex-col items-center justify-center rounded-xl border border-dashed border-gray-300 bg-white py-20 text-center">
                    <i data-lucide="workflow" class="h-12 w-12 text-gray-300 mb-3"></i>
                    <p class="text-sm text-gray-500 font-medium">Belum ada proses bisnis.</p>
                    <button type="button" onclick="document.getElementById('modal-add-process').classList.remove('hidden')"
                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-red-800 px-4 py-2 text-sm font-medium text-white hover:bg-red-900 transition-colors">
                        <i data-lucide="plus" class="h-4 w-4"></i> Tambah Proses
                    </button>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>


<div id="modal-add-process" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"
         onclick="document.getElementById('modal-add-process').classList.add('hidden')"></div>
    <div class="relative z-10 w-full max-w-lg rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">Tambah Proses Bisnis</h2>
            <button type="button" onclick="document.getElementById('modal-add-process').classList.add('hidden')"
                    class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        <form action="<?php echo e(route('proses-bisnis.store')); ?>" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label for="add-title" class="mb-1.5 block text-sm font-medium text-gray-700">Nama Proses <span class="text-red-600">*</span></label>
                <input id="add-title" name="title" type="text" placeholder="Contoh: Penerimaan Mahasiswa Baru"
                       class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
            </div>
            <div>
                <label for="add-description" class="mb-1.5 block text-sm font-medium text-gray-700">Deskripsi <span class="font-normal text-gray-400">(Opsional)</span></label>
                <textarea id="add-description" name="description" rows="3"
                          class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 resize-none"></textarea>
            </div>
            <div>
                <label for="add-image" class="mb-1.5 block text-sm font-medium text-gray-700">Gambar <span class="font-normal text-gray-400">(JPG/PNG, maks. 5MB)</span></label>
                <input id="add-image" name="image" type="file" accept="image/*"
                       class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-red-50 file:px-3 file:py-1 file:text-sm file:font-medium file:text-red-800 hover:file:bg-red-100">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-add-process').classList.add('hidden')"
                        class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit"
                        class="rounded-lg bg-red-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-900">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div id="modal-edit-process" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"
         onclick="document.getElementById('modal-edit-process').classList.add('hidden')"></div>
    <div class="relative z-10 w-full max-w-lg rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">Edit Proses Bisnis</h2>
            <button type="button" onclick="document.getElementById('modal-edit-process').classList.add('hidden')"
                    class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        <form id="edit-process-form" action="" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div>
                <label for="edit-title" class="mb-1.5 block text-sm font-medium text-gray-700">Nama Proses <span class="text-red-600">*</span></label>
                <input id="edit-title" name="title" type="text"
                       class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100">
            </div>
            <div>
                <label for="edit-description" class="mb-1.5 block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="edit-description" name="description" rows="3"
                          class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 resize-none"></textarea>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700">Ganti Gambar</label>
                <input name="image" type="file" accept="image/*"
                       class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-red-50 file:px-3 file:py-1 file:text-sm file:font-medium file:text-red-800 hover:file:bg-red-100">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-edit-process').classList.add('hidden')"
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
    function openEditModal(id, title, description) {
        document.getElementById('edit-title').value       = title;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-process-form').action = '/proses-bisnis/' + id;
        document.getElementById('modal-edit-process').classList.remove('hidden');
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (3)\SIMKEB\resources\views/proses-bisnis/index.blade.php ENDPATH**/ ?>