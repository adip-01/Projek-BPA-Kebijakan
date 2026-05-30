<?php

namespace App\Http\Controllers;

use App\Models\DaftarDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DaftarDokumenController extends Controller
{
    /**
     * Tampilkan halaman dashboard daftar dokumen kebijakan.
     * Menghitung jumlah dokumen per BPA untuk ditampilkan di stat cards.
     */
    public function index()
    {
        // Data tabel dengan pagination
        $dokumens = DaftarDokumen::latest()->paginate(4);

        // Hitung per BPA untuk stat cards
        $countBpa1 = DaftarDokumen::where('jenis_bpa', 'BPA 1')->count();
        $countBpa2 = DaftarDokumen::where('jenis_bpa', 'BPA 2')->count();
        $countBpa3 = DaftarDokumen::where('jenis_bpa', 'BPA 3')->count();
        $countBpa4 = DaftarDokumen::where('jenis_bpa', 'BPA 4')->count();

        return view('admin.dashboard', compact(
            'dokumens',
            'countBpa1',
            'countBpa2',
            'countBpa3',
            'countBpa4'
        ));
    }

    /**
     * Simpan dokumen baru ke database.
     * Wajib return JSON karena frontend menggunakan fetch (AJAX).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'jenis_bpa'    => 'required|in:BPA 1,BPA 2,BPA 3,BPA 4',
            'file_dokumen' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'nama_dokumen.required' => 'Nama dokumen wajib diisi.',
            'jenis_bpa.required'    => 'Jenis dokumen BPA wajib dipilih.',
            'jenis_bpa.in'          => 'Jenis BPA tidak valid.',
            'file_dokumen.mimes'    => 'File harus berformat PDF.',
            'file_dokumen.max'      => 'Ukuran file tidak boleh melebihi 10 MB.',
        ]);

        $pathDokumen = null;

        if ($request->hasFile('file_dokumen')) {
            $pathDokumen = $request->file('file_dokumen')
                ->store('daftar_dokumen', 'public');
        }

        DaftarDokumen::create([
            'nama_dokumen' => $request->nama_dokumen,
            'jenis_bpa'    => $request->jenis_bpa,
            'path_dokumen' => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil ditambahkan.',
        ], 201);
    }

    /**
     * Update dokumen yang sudah ada.
     * Menggunakan POST (bukan PUT/PATCH) agar FormData multipart
     * bekerja dengan benar dari Alpine.js fetch.
     */
    public function update(Request $request, DaftarDokumen $daftarDokumen)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'jenis_bpa'    => 'required|in:BPA 1,BPA 2,BPA 3,BPA 4',
            'file_dokumen' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'nama_dokumen.required' => 'Nama dokumen wajib diisi.',
            'jenis_bpa.required'    => 'Jenis dokumen BPA wajib dipilih.',
            'jenis_bpa.in'          => 'Jenis BPA tidak valid.',
            'file_dokumen.mimes'    => 'File harus berformat PDF.',
            'file_dokumen.max'      => 'Ukuran file tidak boleh melebihi 10 MB.',
        ]);

        $pathDokumen = $daftarDokumen->path_dokumen; // Pertahankan file lama

        // Jika ada file baru: hapus lama, simpan baru
        if ($request->hasFile('file_dokumen')) {
            if ($daftarDokumen->path_dokumen &&
                Storage::disk('public')->exists($daftarDokumen->path_dokumen)) {
                Storage::disk('public')->delete($daftarDokumen->path_dokumen);
            }

            $pathDokumen = $request->file('file_dokumen')
                ->store('daftar_dokumen', 'public');
        }

        $daftarDokumen->update([
            'nama_dokumen' => $request->nama_dokumen,
            'jenis_bpa'    => $request->jenis_bpa,
            'path_dokumen' => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diperbarui.',
        ]);
    }

    /**
     * Hapus dokumen beserta file PDF-nya dari storage.
     */
    public function destroy(DaftarDokumen $daftarDokumen)
    {
        if ($daftarDokumen->path_dokumen &&
            Storage::disk('public')->exists($daftarDokumen->path_dokumen)) {
            Storage::disk('public')->delete($daftarDokumen->path_dokumen);
        }

        $daftarDokumen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus.',
        ]);
    }
}