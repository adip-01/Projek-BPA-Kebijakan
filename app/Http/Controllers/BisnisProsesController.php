<?php

namespace App\Http\Controllers;

use App\Models\BisnisProses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BisnisProsesController extends Controller
{
    /**
     * Tampilkan semua data Bisnis Proses.
     */
    public function index()
    {
        $proseses = BisnisProses::latest()->get();
        $total    = $proseses->count();

        return view('admin.bisnis-proses.index', compact('proseses', 'total'));
    }

    /**
     * Simpan Bisnis Proses baru.
     * Menangani upload gambar dan PDF.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_proses'  => ['required', 'string', 'max:255'],
            'file_gambar'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],   // maks 5 MB
            'file_dokumen'  => ['nullable', 'mimes:pdf', 'max:10240'],                          // maks 10 MB
        ], [
            'judul_proses.required' => 'Nama proses wajib diisi.',
            'file_gambar.image'     => 'File gambar harus berupa gambar (jpg, png, webp).',
            'file_gambar.max'       => 'Ukuran gambar maksimal 5 MB.',
            'file_dokumen.mimes'    => 'File dokumen harus berformat PDF.',
            'file_dokumen.max'      => 'Ukuran dokumen PDF maksimal 10 MB.',
        ]);

        $data = ['judul_proses' => $validated['judul_proses']];

        // Upload gambar jika ada
        if ($request->hasFile('file_gambar')) {
            $data['path_gambar'] = $this->uploadFile(
                $request->file('file_gambar'),
                'bisnis-proses/gambar'
            );
        }

        // Upload PDF jika ada
        if ($request->hasFile('file_dokumen')) {
            $data['path_dokumen'] = $this->uploadFile(
                $request->file('file_dokumen'),
                'bisnis-proses/dokumen'
            );
        }

        BisnisProses::create($data);

        return redirect()->route('bisnis-proses.index')
            ->with('success', 'Bisnis proses berhasil ditambahkan.');
    }

    /**
     * Update data Bisnis Proses.
     * File lama dihapus dari storage jika diganti.
     */
    public function update(Request $request, BisnisProses $bisnisProse)
    {
        $validated = $request->validate([
            'judul_proses'  => ['required', 'string', 'max:255'],
            'file_gambar'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'file_dokumen'  => ['nullable', 'mimes:pdf', 'max:10240'],
        ], [
            'judul_proses.required' => 'Nama proses wajib diisi.',
            'file_gambar.image'     => 'File gambar harus berupa gambar (jpg, png, webp).',
            'file_gambar.max'       => 'Ukuran gambar maksimal 5 MB.',
            'file_dokumen.mimes'    => 'File dokumen harus berformat PDF.',
            'file_dokumen.max'      => 'Ukuran dokumen PDF maksimal 10 MB.',
        ]);

        $data = ['judul_proses' => $validated['judul_proses']];

        // Ganti gambar jika ada file baru diunggah
        if ($request->hasFile('file_gambar')) {
            // Hapus file lama dari storage
            $this->deleteFile($bisnisProse->path_gambar);

            $data['path_gambar'] = $this->uploadFile(
                $request->file('file_gambar'),
                'bisnis-proses/gambar'
            );
        }

        // Ganti PDF jika ada file baru diunggah
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama dari storage
            $this->deleteFile($bisnisProse->path_dokumen);

            $data['path_dokumen'] = $this->uploadFile(
                $request->file('file_dokumen'),
                'bisnis-proses/dokumen'
            );
        }

        $bisnisProse->update($data);

        return redirect()->route('bisnis-proses.index')
            ->with('success', 'Bisnis proses berhasil diperbarui.');
    }

    /**
     * Hapus Bisnis Proses beserta file-nya dari storage.
     */
    public function destroy(BisnisProses $bisnisProse)
    {
        // Hapus file gambar dari storage
        $this->deleteFile($bisnisProse->path_gambar);

        // Hapus file PDF dari storage
        $this->deleteFile($bisnisProse->path_dokumen);

        $bisnisProse->delete();

        return redirect()->route('bisnis-proses.index')
            ->with('success', 'Bisnis proses berhasil dihapus.');
    }

    // ─────────────────────────────────────────
    // PRIVATE HELPER METHODS
    // ─────────────────────────────────────────

    /**
     * Upload file ke storage dan kembalikan path-nya.
     * Nama file dibuat unik agar tidak bentrok.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $folder   Folder tujuan di dalam disk 'public'
     * @return string            Path relatif (disimpan di DB)
     */
    private function uploadFile($file, string $folder): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension    = $file->getClientOriginalExtension();
        $filename     = Str::slug($originalName) . '_' . time() . '.' . $extension;

        // Simpan ke storage/app/public/{folder}/{filename}
        // Agar bisa diakses publik, jalankan: php artisan storage:link
        return $file->storeAs($folder, $filename, 'public');
    }

    /**
     * Hapus file dari storage berdasarkan path relatif.
     * Aman jika path null atau file tidak ditemukan.
     *
     * @param  string|null  $path
     */
    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}