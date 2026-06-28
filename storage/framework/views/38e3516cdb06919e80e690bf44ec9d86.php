<?php $__env->startSection('title', 'Edit Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div class="px-4 py-6 md:px-8">
    <div class="mx-auto max-w-3xl">

        
        <nav class="mb-4 flex items-center gap-2 text-sm text-gray-500">
            <a href="<?php echo e(route('dokumen.index')); ?>" class="hover:text-red-800 transition-colors">Dokumen</a>
            <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400"></i>
            <span class="text-gray-900 font-medium">Edit Dokumen</span>
        </nav>

        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

            <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-800">
                    <i data-lucide="file-edit" class="h-5 w-5"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Edit Dokumen</h2>
                    <p class="text-xs text-gray-500 truncate max-w-md"><?php echo e($dokumen->title); ?></p>
                </div>
            </div>

            <?php if($errors->any()): ?>
                <div class="mx-6 mt-5 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 shrink-0 text-red-600"></i>
                        <ul class="list-disc list-inside space-y-0.5">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="text-sm text-red-700"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('dokumen.update', $dokumen)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 gap-x-5 gap-y-4 px-6 py-6 sm:grid-cols-2">

                    <div class="sm:col-span-2">
                        <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700">Judul Dokumen <span class="text-red-600">*</span></label>
                        <input id="title" name="title" type="text"
                               value="<?php echo e(old('title', $dokumen->title)); ?>"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                    </div>

                    <div>
                        <label for="number" class="mb-1.5 block text-sm font-medium text-gray-700">Nomor Dokumen</label>
                        <input id="number" name="number" type="text"
                               value="<?php echo e(old('number', $dokumen->number)); ?>"
                               placeholder="BPA/PND/2026/001"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                    </div>

                    <div>
                        <label for="category" class="mb-1.5 block text-sm font-medium text-gray-700">Kategori <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <select id="category" name="category"
                                    class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat); ?>" <?php echo e(old('category', $dokumen->category) === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <div>
                        <label for="owner" class="mb-1.5 block text-sm font-medium text-gray-700">Pemilik Dokumen <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <select id="owner" name="owner"
                                    class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                                <option value="Internal BPA"  <?php echo e(old('owner', $dokumen->owner) === 'Internal BPA'  ? 'selected' : ''); ?>>Internal BPA</option>
                                <option value="Eksternal BPA" <?php echo e(old('owner', $dokumen->owner) === 'Eksternal BPA' ? 'selected' : ''); ?>>Eksternal BPA</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <div>
                        <label for="effective_date" class="mb-1.5 block text-sm font-medium text-gray-700">Tanggal Efektif</label>
                        <input id="effective_date" name="effective_date" type="date"
                               value="<?php echo e(old('effective_date', $dokumen->effective_date?->format('Y-m-d'))); ?>"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                    </div>

                    <div>
                        <label for="version" class="mb-1.5 block text-sm font-medium text-gray-700">Versi Dokumen</label>
                        <input id="version" name="version" type="text"
                               value="<?php echo e(old('version', $dokumen->version)); ?>"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                    </div>

                    <div>
                        <label for="status" class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                        <div class="relative">
                            <select id="status" name="status"
                                    class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100">
                                <option value="Aktif"       <?php echo e(old('status', $dokumen->status) === 'Aktif'       ? 'selected' : ''); ?>>Aktif</option>
                                <option value="Tidak Aktif" <?php echo e(old('status', $dokumen->status) === 'Tidak Aktif' ? 'selected' : ''); ?>>Tidak Aktif</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="mb-1.5 block text-sm font-medium text-gray-700">Deskripsi / Ringkasan</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100 resize-none"><?php echo e(old('description', $dokumen->description)); ?></textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="klausul" class="mb-1.5 block text-sm font-medium text-gray-700">Klausul <span class="font-normal text-gray-400">(Opsional)</span></label>
                        <textarea id="klausul" name="klausul" rows="3"
                                  class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-800 outline-none transition-colors focus:border-red-700 focus:ring-2 focus:ring-red-100 resize-none"><?php echo e(old('klausul', $dokumen->klausul)); ?></textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="link" class="mb-1.5 block text-sm font-medium text-gray-700">Link Dokumen</label>
                        <div class="relative">
                            <i data-lucide="link-2" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                            <input id="link" name="link" type="url"
                                   value="<?php echo e(old('link', $dokumen->link)); ?>"
                                   placeholder="https://drive.example.com/dokumen"
                                   class="w-full rounded-lg border border-gray-200 pl-9 pr-3 py-2.5 text-sm text-gray-800 outline-none transition-colors placeholder:text-gray-400 focus:border-red-700 focus:ring-2 focus:ring-red-100">
                        </div>
                    </div>

                    
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Ganti File Dokumen
                            <span class="font-normal text-gray-400">(Kosongkan jika tidak ingin mengganti)</span>
                        </label>

                        <?php if($dokumen->file_path): ?>
                            <div class="mb-3 flex items-center gap-3 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3">
                                <i data-lucide="file" class="h-5 w-5 shrink-0 text-blue-600"></i>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-blue-800 truncate"><?php echo e(basename($dokumen->file_path)); ?></p>
                                    <p class="text-xs text-blue-600">File saat ini</p>
                                </div>
                                <a href="<?php echo e(route('dokumen.download', $dokumen)); ?>"
                                   class="text-xs text-blue-700 hover:underline font-medium">Download</a>
                            </div>
                        <?php endif; ?>

                        <label for="document_file"
                               class="group flex w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center transition-colors hover:border-red-400 hover:bg-red-50">
                            <i data-lucide="upload-cloud" class="mb-3 h-8 w-8 text-gray-400 group-hover:text-red-700 transition-colors"></i>
                            <p class="text-sm font-semibold text-gray-700 group-hover:text-red-800">Klik untuk mengganti file</p>
                            <p class="mt-1 text-xs text-gray-400">PDF, Word, Excel, PPT — maks. 20 MB</p>
                            <input id="document_file" name="document_file" type="file"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                                   class="sr-only">
                        </label>

                        <div id="file-preview" class="hidden mt-3 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3">
                            <i data-lucide="file-check" class="h-5 w-5 shrink-0 text-green-700"></i>
                            <p id="file-name" class="flex-1 text-sm font-semibold text-green-800 truncate min-w-0"></p>
                            <p id="file-size" class="text-xs text-green-600 whitespace-nowrap"></p>
                        </div>
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 bg-gray-50/60 px-6 py-4">
                    <a href="<?php echo e(route('dokumen.index')); ?>"
                       class="rounded-lg border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-red-800 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-red-900">
                        <i data-lucide="save" class="h-4 w-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const fi = document.getElementById('document_file');
    fi.addEventListener('change', (e) => {
        const f = e.target.files[0];
        if (!f) return;
        document.getElementById('file-name').textContent = f.name;
        document.getElementById('file-size').textContent = (f.size / 1048576).toFixed(1) + ' MB';
        document.getElementById('file-preview').classList.remove('hidden');
        document.getElementById('file-preview').classList.add('flex');
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (3)\SIMKEB\resources\views/dokumen/edit.blade.php ENDPATH**/ ?>