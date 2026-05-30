<?php

namespace App\Http\Controllers;

use App\Models\InformasiTambahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiTambahanController extends Controller
{
    /**
     * Tampilkan halaman daftar informasi tambahan.
     * Data diambil tanpa pagination karena halaman ini hanya
     * menampilkan card grid (bukan tabel besar).
     * Tambahkan paginate() jika nantinya butuh pagination.
     */
    public function index()
    {
        $informasis = InformasiTambahan::latest()->get();

        return view('admin.informasi_tambahan.index', compact('informasis'));
    }

    /**
     * Simpan informasi tambahan baru ke database.
     * WAJIB return JSON karena frontend menggunakan fetch (AJAX).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_informasi' => 'required|string|max:255',
            'file_dokumen'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4|max:10240',
        ], [
            'nama_informasi.required' => 'Nama informasi wajib diisi.',
            'file_dokumen.mimes'      => 'File harus berformat PDF, JPG, PNG, atau MP4.',
            'file_dokumen.max'        => 'Ukuran file tidak boleh melebihi 10 MB.',
        ]);

        $pathDokumen = null;

        // Upload file jika ada
        if ($request->hasFile('file_dokumen')) {
            $pathDokumen = $request->file('file_dokumen')
                ->store('informasi_tambahan', 'public');
        }

        InformasiTambahan::create([
            'nama_informasi' => $request->nama_informasi,
            'path_dokumen'   => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Informasi tambahan berhasil ditambahkan.',
        ], 201);
    }

    /**
     * Update informasi tambahan yang sudah ada.
     * Menggunakan POST (bukan PUT/PATCH) agar FormData multipart
     * dari Alpine.js fetch tidak bermasalah.
     */
    public function update(Request $request, InformasiTambahan $informasiTambahan)
    {
        $request->validate([
            'nama_informasi' => 'required|string|max:255',
            'file_dokumen'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4|max:10240',
        ], [
            'nama_informasi.required' => 'Nama informasi wajib diisi.',
            'file_dokumen.mimes'      => 'File harus berformat PDF, JPG, PNG, atau MP4.',
            'file_dokumen.max'        => 'Ukuran file tidak boleh melebihi 10 MB.',
        ]);

        $pathDokumen = $informasiTambahan->path_dokumen; // Pertahankan file lama

        // Jika ada file baru: hapus file lama, simpan yang baru
        if ($request->hasFile('file_dokumen')) {
            if ($informasiTambahan->path_dokumen &&
                Storage::disk('public')->exists($informasiTambahan->path_dokumen)) {
                Storage::disk('public')->delete($informasiTambahan->path_dokumen);
            }

            $pathDokumen = $request->file('file_dokumen')
                ->store('informasi_tambahan', 'public');
        }

        $informasiTambahan->update([
            'nama_informasi' => $request->nama_informasi,
            'path_dokumen'   => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Informasi tambahan berhasil diperbarui.',
        ]);
    }

    /**
     * Hapus informasi tambahan beserta file-nya dari storage.
     */
    public function destroy(InformasiTambahan $informasiTambahan)
    {
        // Hapus file dari storage jika ada
        if ($informasiTambahan->path_dokumen &&
            Storage::disk('public')->exists($informasiTambahan->path_dokumen)) {
            Storage::disk('public')->delete($informasiTambahan->path_dokumen);
        }

        $informasiTambahan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Informasi tambahan berhasil dihapus.',
        ]);
    }
}