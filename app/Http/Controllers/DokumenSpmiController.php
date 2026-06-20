<?php

namespace App\Http\Controllers;

use App\Models\DokumenSpmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenSpmiController extends Controller
{
    // ════════════════════════════════════════════════════════════════
    // INDEX
    // ════════════════════════════════════════════════════════════════

    /**
     * Tampilkan halaman Dokumen SPMI.
     * Mengirimkan 4 variabel statistik untuk kartu + data tabel paginated.
     */
    public function index()
    {
        // ── Stat cards ───────────────────────────────────────────
        $totalStandar   = DokumenSpmi::where('jenis_dokumen', 'STANDAR')->count();
        $totalKebijakan = DokumenSpmi::where('jenis_dokumen', 'KEBIJAKAN')->count();
        $totalManual    = DokumenSpmi::where('jenis_dokumen', 'MANUAL')->count();
        $totalFormulir  = DokumenSpmi::where('jenis_dokumen', 'FORMULIR')->count();

        // ── Tabel (10 per halaman, terbaru duluan) ───────────────
        $dokumens = DokumenSpmi::latest()->paginate(10);

        return view('admin.dokumen_spmi.index', compact(
            'totalStandar',
            'totalKebijakan',
            'totalManual',
            'totalFormulir',
            'dokumens'
        ));
    }

    // ════════════════════════════════════════════════════════════════
    // STORE — Tambah dokumen baru (AJAX / fetch)
    // ════════════════════════════════════════════════════════════════

    /**
     * Validasi, upload PDF (opsional), simpan ke DB, return JSON.
     */
    public function store(Request $request)
    {
        $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $pathDokumen = null;

        if ($request->hasFile('file_dokumen')) {
            $pathDokumen = $request->file('file_dokumen')
                ->store('dokumen_spmi', 'public');
        }

        DokumenSpmi::create([
            'nama_dokumen'  => $request->nama_dokumen,
            'nomor_dokumen' => $request->nomor_dokumen,
            'jenis_dokumen' => $request->jenis_dokumen,
            'path_dokumen'  => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen SPMI berhasil ditambahkan.',
        ], 201);
    }

    // ════════════════════════════════════════════════════════════════
    // UPDATE — Edit dokumen (AJAX / fetch, method POST)
    // ════════════════════════════════════════════════════════════════

    /**
     * Validasi, ganti file lama jika ada upload baru, update DB.
     * Menggunakan POST (bukan PUT/PATCH) agar FormData multipart
     * bekerja benar dari Alpine.js fetch.
     */
    public function update(Request $request, DokumenSpmi $dokumenSpmi)
    {
        $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        $pathDokumen = $dokumenSpmi->path_dokumen; // Pertahankan file lama

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama sebelum simpan yang baru
            if ($pathDokumen && Storage::disk('public')->exists($pathDokumen)) {
                Storage::disk('public')->delete($pathDokumen);
            }

            $pathDokumen = $request->file('file_dokumen')
                ->store('dokumen_spmi', 'public');
        }

        $dokumenSpmi->update([
            'nama_dokumen'  => $request->nama_dokumen,
            'nomor_dokumen' => $request->nomor_dokumen,
            'jenis_dokumen' => $request->jenis_dokumen,
            'path_dokumen'  => $pathDokumen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen SPMI berhasil diperbarui.',
        ]);
    }

    // ════════════════════════════════════════════════════════════════
    // DESTROY — Hapus dokumen (AJAX / fetch, method DELETE)
    // ════════════════════════════════════════════════════════════════

    /**
     * Hapus file PDF dari storage (jika ada), lalu hapus record DB.
     */
    public function destroy(DokumenSpmi $dokumenSpmi)
    {
        if ($dokumenSpmi->path_dokumen &&
            Storage::disk('public')->exists($dokumenSpmi->path_dokumen)) {
            Storage::disk('public')->delete($dokumenSpmi->path_dokumen);
        }

        $dokumenSpmi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen SPMI berhasil dihapus.',
        ]);
    }

    // ════════════════════════════════════════════════════════════════
    // PRIVATE HELPERS — Validasi terpusat (dipakai store & update)
    // ════════════════════════════════════════════════════════════════

    /**
     * Aturan validasi untuk store dan update.
     *
     * @return array<string, mixed>
     */
    private function validationRules(): array
    {
        $jenisOptions = implode(',', DokumenSpmi::JENIS_OPTIONS);

        return [
            'nama_dokumen'  => 'required|string|max:255',
            'nomor_dokumen' => 'required|string|max:255',
            'jenis_dokumen' => "required|in:{$jenisOptions}",
            'file_dokumen'  => 'nullable|file|mimes:pdf|max:10240',
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
            'nama_dokumen.required'  => 'Nama dokumen wajib diisi.',
            'nomor_dokumen.required' => 'Nomor dokumen wajib diisi.',
            'jenis_dokumen.required' => 'Jenis dokumen wajib dipilih.',
            'jenis_dokumen.in'       => 'Jenis dokumen tidak valid. Pilih: STANDAR, KEBIJAKAN, MANUAL, atau FORMULIR.',
            'file_dokumen.mimes'     => 'File harus berformat PDF.',
            'file_dokumen.max'       => 'Ukuran file tidak boleh melebihi 10 MB.',
        ];
    }
}