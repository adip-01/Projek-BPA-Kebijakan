<?php

namespace App\Http\Controllers;

use App\Models\DokumenUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DokumenUnitController extends Controller
{
    // Opsi tetap untuk dropdown
    private const JENIS_DOKUMEN   = ['Dokumen Milik', 'Dokumen Distribusi'];
    private const JENIS_SPESIFIK  = ['Prosedur', 'Instruksi Kerja', 'Formulir SPMI', 'Dokumen Internal'];

    /**
     * Tampilkan halaman utama.
     * Data dikelompokkan per unit_bpa untuk ditampilkan sebagai card.
     */
    public function index()
    {
        // Ambil semua unit BPA unik
        $unitList = DokumenUnit::select('unit_bpa')
            ->distinct()
            ->orderBy('unit_bpa')
            ->pluck('unit_bpa');

        // Statistik per unit: hitung dokumen per jenis_spesifik & jenis_dokumen
        $stats = [];
        foreach ($unitList as $unit) {
            foreach (self::JENIS_DOKUMEN as $jenis) {
                foreach (self::JENIS_SPESIFIK as $spesifik) {
                    $stats[$unit][$jenis][$spesifik] = DokumenUnit::where('unit_bpa', $unit)
                        ->where('jenis_dokumen', $jenis)
                        ->where('jenis_spesifik', $spesifik)
                        ->count();
                }
            }
        }

        return view('admin.dokumen-unit.index', [
            'unitList'      => $unitList,
            'stats'         => $stats,
            'jenisDokumen'  => self::JENIS_DOKUMEN,
            'jenisSpesifik' => self::JENIS_SPESIFIK,
            'totalUnit'     => $unitList->count(),
        ]);
    }

    /**
     * Simpan dokumen baru — return JSON.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_bpa'       => ['required', 'string', 'max:255'],
            'jenis_dokumen'  => ['required', Rule::in(self::JENIS_DOKUMEN)],
            'jenis_spesifik' => ['required', Rule::in(self::JENIS_SPESIFIK)],
            'file_dokumen'   => ['nullable', 'mimes:pdf', 'max:10240'],
        ], [
            'unit_bpa.required'       => 'Unit BPA wajib diisi.',
            'jenis_dokumen.required'  => 'Jenis dokumen wajib dipilih.',
            'jenis_dokumen.in'        => 'Jenis dokumen tidak valid.',
            'jenis_spesifik.required' => 'Jenis spesifik wajib dipilih.',
            'jenis_spesifik.in'       => 'Jenis spesifik tidak valid.',
            'file_dokumen.mimes'      => 'File harus berformat PDF.',
            'file_dokumen.max'        => 'Ukuran file maksimal 10 MB.',
        ]);

        $data = [
            'unit_bpa'       => $validated['unit_bpa'],
            'jenis_dokumen'  => $validated['jenis_dokumen'],
            'jenis_spesifik' => $validated['jenis_spesifik'],
        ];

        if ($request->hasFile('file_dokumen')) {
            $data['file_path'] = $this->uploadFile($request->file('file_dokumen'));
        }

        $dokumen = DokumenUnit::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil ditambahkan.',
            'data'    => $dokumen,
        ], 201);
    }

    /**
     * Update dokumen — return JSON.
     */
    public function update(Request $request, DokumenUnit $dokumenUnit)
    {
        $validated = $request->validate([
            'unit_bpa'       => ['required', 'string', 'max:255'],
            'jenis_dokumen'  => ['required', Rule::in(self::JENIS_DOKUMEN)],
            'jenis_spesifik' => ['required', Rule::in(self::JENIS_SPESIFIK)],
            'file_dokumen'   => ['nullable', 'mimes:pdf', 'max:10240'],
        ], [
            'unit_bpa.required'       => 'Unit BPA wajib diisi.',
            'jenis_dokumen.required'  => 'Jenis dokumen wajib dipilih.',
            'jenis_dokumen.in'        => 'Jenis dokumen tidak valid.',
            'jenis_spesifik.required' => 'Jenis spesifik wajib dipilih.',
            'jenis_spesifik.in'       => 'Jenis spesifik tidak valid.',
            'file_dokumen.mimes'      => 'File harus berformat PDF.',
            'file_dokumen.max'        => 'Ukuran file maksimal 10 MB.',
        ]);

        $data = [
            'unit_bpa'       => $validated['unit_bpa'],
            'jenis_dokumen'  => $validated['jenis_dokumen'],
            'jenis_spesifik' => $validated['jenis_spesifik'],
        ];

        // Ganti file jika ada yang baru diunggah
        if ($request->hasFile('file_dokumen')) {
            $this->deleteFile($dokumenUnit->file_path);
            $data['file_path'] = $this->uploadFile($request->file('file_dokumen'));
        }

        $dokumenUnit->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diperbarui.',
            'data'    => $dokumenUnit->fresh(),
        ]);
    }

    /**
     * Hapus dokumen beserta file-nya — return JSON.
     */
    public function destroy(DokumenUnit $dokumenUnit)
    {
        $this->deleteFile($dokumenUnit->file_path);
        $dokumenUnit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus.',
        ]);
    }

    // ─────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────

    /**
     * Upload file PDF ke storage/app/public/dokumen_unit/
     * dan kembalikan path relatifnya.
     */
    private function uploadFile($file): string
    {
        $original  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext       = $file->getClientOriginalExtension();
        $filename  = Str::slug($original) . '_' . time() . '.' . $ext;

        return $file->storeAs('dokumen_unit', $filename, 'public');
    }

    /**
     * Hapus file dari storage jika ada.
     */
    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}