<?php

namespace App\Http\Controllers;

use App\Models\DaftarDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DaftarDokumenController extends Controller
{
    // ════════════════════════════════════════════════════════════════
    // INDEX
    // ════════════════════════════════════════════════════════════════

    /**
     * Tampilkan halaman daftar dokumen dengan pagination.
     */
    public function index()
    {
        $dokumens = DaftarDokumen::latest()->paginate(10);

        return view('admin.daftar-dokumen.index', compact('dokumens'));
    }


    public function store(Request $request)
    {
        $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $pathDokumen = null;

        if ($request->hasFile('file_dokumen')) {
            $pathDokumen = $request->file('file_dokumen')
                ->store('daftar_dokumen', 'public');
        }

        DaftarDokumen::create([
            // Step 1
            'standard'        => $request->standard,
            'klasul'          => $request->klasul,
            'jenis_dokumen'   => $request->jenis_dokumen,
            'nama_dokumen'    => $request->nama_dokumen,
            'pemilik_dokumen' => $request->pemilik_dokumen,
            'data_pendukung'  => $request->data_pendukung,
            // Step 2
            'link_aplikasi'   => $request->link_aplikasi,
            'revisi_dokumen'  => $request->revisi_dokumen,
            'tanggal_efektif' => $request->tanggal_efektif ?: null,
            'path_dokumen'    => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil ditambahkan.',
        ], 201);
    }

    public function update(Request $request, DaftarDokumen $daftarDokumen)
    {
        $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $pathDokumen = $daftarDokumen->path_dokumen; // Pertahankan file lama

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama dari storage sebelum menyimpan yang baru
            if ($pathDokumen && Storage::disk('public')->exists($pathDokumen)) {
                Storage::disk('public')->delete($pathDokumen);
            }

            $pathDokumen = $request->file('file_dokumen')
                ->store('daftar_dokumen', 'public');
        }

        $daftarDokumen->update([
            // Step 1
            'standard'        => $request->standard,
            'klasul'          => $request->klasul,
            'jenis_dokumen'   => $request->jenis_dokumen,
            'nama_dokumen'    => $request->nama_dokumen,
            'pemilik_dokumen' => $request->pemilik_dokumen,
            'data_pendukung'  => $request->data_pendukung,
            // Step 2
            'link_aplikasi'   => $request->link_aplikasi,
            'revisi_dokumen'  => $request->revisi_dokumen,
            'tanggal_efektif' => $request->tanggal_efektif ?: null,
            'path_dokumen'    => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diperbarui.',
        ]);
    }

    // ════════════════════════════════════════════════════════════════
    // DESTROY — Hapus dokumen (AJAX / fetch, method DELETE)
    // ════════════════════════════════════════════════════════════════

    /**
     * Hapus file PDF dari storage (jika ada), lalu hapus record DB.
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

    // ════════════════════════════════════════════════════════════════
    // PRIVATE HELPERS — Validasi terpusat (dipakai store & update)
    // ════════════════════════════════════════════════════════════════

    /**
     * Aturan validasi yang sama untuk store dan update.
     *
     * @return array<string, mixed>
     */
    private function validationRules(): array
    {
        return [
            // Step 1 — wajib
            'jenis_dokumen'   => 'required|string|max:255',
            'nama_dokumen'    => 'required|string|max:255',
            // Step 1 — opsional
            'standard'        => 'nullable|string|max:255',
            'klasul'          => 'nullable|string|max:255',
            'pemilik_dokumen' => 'nullable|string|max:255',
            'data_pendukung'  => 'nullable|string|max:2000',
            // Step 2 — opsional
            'link_aplikasi'   => 'nullable|string|max:500',
            'revisi_dokumen'  => 'nullable|string|max:255',
            'tanggal_efektif' => 'nullable|date',
            'file_dokumen'    => 'nullable|file|mimes:pdf|max:10240',
        ];
    }

    /**
     * Pesan error validasi dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    private function validationMessages(): array
    {
        return [
            'jenis_dokumen.required' => 'Jenis dokumen wajib dipilih.',
            'nama_dokumen.required'  => 'Nama dokumen wajib diisi.',
            'tanggal_efektif.date'   => 'Format tanggal efektif tidak valid.',
            'file_dokumen.mimes'     => 'File harus berformat PDF.',
            'file_dokumen.max'       => 'Ukuran file tidak boleh melebihi 10 MB.',
        ];
    }
}