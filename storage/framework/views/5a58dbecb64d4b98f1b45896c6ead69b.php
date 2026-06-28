<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="pb-8">

    
    <section class="relative bg-gradient-to-b from-red-900 to-red-700 rounded-b-3xl px-4 pt-12 pb-12 text-center">
        <h1 class="text-3xl font-bold text-white">Halo, Raguel! 👋</h1>
        <p class="mt-2 text-red-100">Mau cari kebijakan apa hari ini?</p>
    </section>

    
    <section class="relative z-10 -mt-8 px-4">
        <div class="mx-auto grid max-w-5xl grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl bg-white py-6 text-center shadow-lg">
                <p class="text-3xl font-bold text-red-800"><?php echo e($totalActive); ?></p>
                <p class="mt-1 text-sm text-gray-500">Total Dokumen Aktif</p>
            </div>
            <div class="rounded-xl bg-white py-6 text-center shadow-lg">
                <p class="text-3xl font-bold text-red-800"><?php echo e($totalCategories); ?></p>
                <p class="mt-1 text-sm text-gray-500">Kategori Kebijakan</p>
            </div>
            <div class="rounded-xl bg-white py-6 text-center shadow-lg">
                <p class="text-3xl font-bold text-orange-500"><?php echo e($pendingAdmins); ?></p>
                <p class="mt-1 text-sm text-gray-500">Admin Pending</p>
            </div>
        </div>
    </section>

    
    <section class="mx-auto max-w-5xl px-4 py-10">
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Kategori Kebijakan</h2>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <?php
                $categoryConfig = [
                    ['title' => 'Panduan',         'icon' => 'book-open',    'desc' => 'Panduan dan acuan resmi untuk pelaksanaan tugas.'],
                    ['title' => 'SOP',             'icon' => 'layers',       'desc' => 'Standar Prosedur Operasional untuk kegiatan operasional.'],
                    ['title' => 'Petunjuk Teknis', 'icon' => 'book-marked',  'desc' => 'Panduan teknis pelaksanaan kegiatan khusus.'],
                    ['title' => 'Peraturan Univ',  'icon' => 'scale',        'desc' => 'Peraturan dan ketentuan universitas yang berlaku.'],
                ];
            ?>

            <?php $__currentLoopData = $categoryConfig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex flex-col rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-red-50 text-red-800">
                        <i data-lucide="<?php echo e($cat['icon']); ?>" class="h-6 w-6"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900"><?php echo e($cat['title']); ?></h3>
                    <p class="mt-1 flex-1 text-sm leading-relaxed text-gray-500"><?php echo e($cat['desc']); ?></p>
                    <div class="mt-4 flex items-center border-t border-gray-100 pt-4">
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            <?php echo e($categoryCounts[$cat['title']] ?? 0); ?> Dokumen
                        </span>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="mx-auto max-w-5xl px-4 pb-12">
        <div class="relative mb-6 w-full max-w-3xl">
            <i data-lucide="search" class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"></i>
            <input type="search"
                   placeholder="Cari nama dokumen, nomor kebijakan, atau klausul..."
                   class="w-full rounded-xl border border-gray-200 bg-white p-3.5 pl-11 text-sm text-gray-900 placeholder:text-gray-400 transition-colors focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
        </div>

        <div class="mb-5 flex items-center justify-between gap-4 flex-wrap">
            <h2 class="text-xl font-bold text-gray-900">Dokumen Terbaru Diunggah</h2>
            <div class="flex gap-3 flex-wrap">
                <select class="appearance-none rounded-lg border border-red-200 bg-white py-1.5 pl-3 pr-8 text-sm font-medium text-gray-700 transition-colors hover:border-red-400 hover:bg-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Tidak Aktif</option>
                </select>
                <select class="appearance-none rounded-lg border border-red-200 bg-white py-1.5 pl-3 pr-8 text-sm font-medium text-gray-700 transition-colors hover:border-red-400 hover:bg-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    <option>Semua Versi</option>
                    <option>Latest Only</option>
                </select>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/60">
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Nama Dokumen</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Kategori</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Versi</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Tanggal</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $recentDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transition-colors hover:bg-gray-50/60">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-800">
                                            <i data-lucide="file-text" class="h-5 w-5"></i>
                                        </span>
                                        <div>
                                            <p class="font-medium text-gray-900"><?php echo e($doc->title); ?></p>
                                            <p class="text-xs text-gray-400"><?php echo e($doc->number ?? '—'); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-800">
                                        <?php echo e($doc->category); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-md bg-gray-100 px-2 py-1 font-mono text-xs font-medium text-gray-600">
                                        <?php echo e($doc->version); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                        <?php echo e($doc->status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'); ?>">
                                        <?php echo e($doc->status); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo e($doc->created_at->translatedFormat('d M Y')); ?>

                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <?php if($doc->file_path): ?>
                                            <a href="<?php echo e(route('dokumen.download', $doc)); ?>"
                                               class="flex h-8 w-8 items-center justify-center rounded-md text-blue-600 transition-colors hover:bg-blue-50">
                                                <i data-lucide="download" class="h-4 w-4"></i>
                                            </a>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('dokumen.destroy', $doc)); ?>" method="POST"
                                              onsubmit="return confirm('Hapus dokumen ini?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="flex h-8 w-8 items-center justify-center rounded-md text-red-600 transition-colors hover:bg-red-50">
                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                    Belum ada dokumen.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    
    <section class="px-4 pt-6 pb-8">
        <div class="mx-auto max-w-5xl grid gap-4 lg:grid-cols-3">

            
            <div class="border border-gray-100 bg-white shadow-sm rounded-xl lg:col-span-2 p-6">
                <h3 class="text-base font-semibold text-gray-900">Statistik Dokumen</h3>
                <p class="text-sm text-gray-500 mb-4">Jumlah dokumen per kategori</p>
                <div class="h-64 flex items-end gap-3">
                    <?php
                        $maxCount = !empty($statsPerCategory) ? max($statsPerCategory) : 1;
                        $redShades = ['#991b1b','#b91c1c','#dc2626','#ef4444','#fca5a5','#fecaca','#fee2e2'];
                    ?>
                    <?php $__currentLoopData = $statsPerCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $heightPct = round(($count / $maxCount) * 100); $i = $loop->index; ?>
                        <div class="flex flex-1 flex-col items-center gap-1">
                            <span class="text-xs font-semibold text-gray-700"><?php echo e($count); ?></span>
                            <div class="w-full rounded-t-md transition-all"
                                 style="height:<?php echo e($heightPct); ?>%; background:<?php echo e($redShades[$i % count($redShades)]); ?>; min-height:8px;"></div>
                            <span class="text-[10px] text-gray-500 text-center leading-tight">
    <?php echo e(\Illuminate\Support\Str::limit($cat, 10)); ?>

</span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="border border-gray-100 bg-white shadow-sm rounded-xl p-6 flex flex-col items-center justify-center">
                <h3 class="text-base font-semibold text-gray-900 self-start">Status Dokumen</h3>
                <p class="text-sm text-gray-500 mb-6 self-start">Dokumen aktif keseluruhan saat ini</p>

                
                <div class="relative flex items-center justify-center" style="width:160px;height:160px;">
                    <svg viewBox="0 0 36 36" class="w-full h-full -rotate-90">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#fee2e2" stroke-width="3.2"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#991b1b" stroke-width="3.2"
                                stroke-dasharray="<?php echo e($healthScore); ?> <?php echo e(100 - $healthScore); ?>"
                                stroke-linecap="round"/>
                    </svg>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-3xl font-extrabold text-red-800"><?php echo e($healthScore); ?>%</span>
                        <span class="text-xs font-medium text-gray-500">Aktif</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (3)\SIMKEB\resources\views/dashboard.blade.php ENDPATH**/ ?>