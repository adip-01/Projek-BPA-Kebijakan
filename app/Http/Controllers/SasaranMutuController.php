<?php

namespace App\Http\Controllers;

use App\Models\Sasaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SasaranMutuController extends Controller
{
    /**
     * Tampilkan daftar sasaran mutu dengan pagination.
     */
    public function index()
    {
        $sasarans = Sasaran::latest()->paginate(10);

        return view('admin.sasaran_mutu.index', compact('sasarans'));
    }

    /**
     * Simpan sasaran mutu baru ke database.
     * Wajib return JSON karena frontend menggunakan fetch (AJAX).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sasaran'  => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:255',
            'jenis_dokumen' => 'required|string|max:255',
            'tahun_berlaku' => 'nullable|string|max:50',
            'file_dokumen'  => 'nullable|file|mimes:pdf|max:10240', // maks 10 MB
        ], [
            'nama_sasaran.required'  => 'Nama sasaran mutu wajib diisi.',
            'jenis_dokumen.required' => 'Jenis dokumen wajib dipilih.',
            'file_dokumen.mimes'     => 'File harus berformat PDF.',
            'file_dokumen.max'       => 'Ukuran file tidak boleh melebihi 10 MB.',
        ]);

        $pathDokumen = null;

        // Upload PDF jika ada
        if ($request->hasFile('file_dokumen')) {
            $pathDokumen = $request->file('file_dokumen')
                ->store('sasaran_mutu', 'public');
        }

        Sasaran::create([
            'nama_sasaran'  => $validated['nama_sasaran'],
            'nomor_dokumen' => $validated['nomor_dokumen'] ?? null,
            'jenis_dokumen' => $validated['jenis_dokumen'],
            'tahun_berlaku' => $validated['tahun_berlaku'] ?? null,
            'path_dokumen'  => $pathDokumen,
            'path_gambar'   => null, // Bisa dikembangkan di iterasi selanjutnya
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sasaran mutu berhasil ditambahkan.',
        ], 201);
    }

    /**
     * Update sasaran mutu yang sudah ada.
     * Menggunakan POST (bukan PUT/PATCH) karena frontend mengirim FormData
     * dengan field "_method" = "POST" untuk kompatibilitas multipart upload.
     */
    public function update(Request $request, Sasaran $sasaran)
    {
        $validated = $request->validate([
            'nama_sasaran'  => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:255',
            'jenis_dokumen' => 'required|string|max:255',
            'tahun_berlaku' => 'nullable|string|max:50',
            'file_dokumen'  => 'nullable|file|mimes:pdf|max:10240', // maks 10 MB
        ], [
            'nama_sasaran.required'  => 'Nama sasaran mutu wajib diisi.',
            'jenis_dokumen.required' => 'Jenis dokumen wajib dipilih.',
            'file_dokumen.mimes'     => 'File harus berformat PDF.',
            'file_dokumen.max'       => 'Ukuran file tidak boleh melebihi 10 MB.',
        ]);

        $pathDokumen = $sasaran->path_dokumen; // Pertahankan file lama secara default

        // Jika ada file baru, hapus file lama lalu simpan yang baru
        if ($request->hasFile('file_dokumen')) {
            if ($sasaran->path_dokumen && Storage::disk('public')->exists($sasaran->path_dokumen)) {
                Storage::disk('public')->delete($sasaran->path_dokumen);
            }

            $pathDokumen = $request->file('file_dokumen')
                ->store('sasaran_mutu', 'public');
        }

        $sasaran->update([
            'nama_sasaran'  => $validated['nama_sasaran'],
            'nomor_dokumen' => $validated['nomor_dokumen'] ?? null,
            'jenis_dokumen' => $validated['jenis_dokumen'],
            'tahun_berlaku' => $validated['tahun_berlaku'] ?? null,
            'path_dokumen'  => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sasaran mutu berhasil diperbarui.',
        ]);
    }

    /**
     * Hapus sasaran mutu beserta file-nya dari storage.
     */
    public function destroy(Sasaran $sasaran)
    {
        // Hapus file PDF dari storage jika ada
        if ($sasaran->path_dokumen && Storage::disk('public')->exists($sasaran->path_dokumen)) {
            Storage::disk('public')->delete($sasaran->path_dokumen);
        }

        // Hapus file gambar/thumbnail dari storage jika ada
        if ($sasaran->path_gambar && Storage::disk('public')->exists($sasaran->path_gambar)) {
            Storage::disk('public')->delete($sasaran->path_gambar);
        }

        $sasaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sasaran mutu berhasil dihapus.',
        ]);
    }
}