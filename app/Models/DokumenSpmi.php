<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DokumenSpmi extends Model
{
    use HasFactory;

    /**
     * Eksplisit agar tidak salah tebak ke "dokumen_spmi" (singular).
     *
     * @var string
     */
    protected $table = 'dokumen_spmis';

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_dokumen',
        'nomor_dokumen',
        'jenis_dokumen',
        'path_dokumen',
    ];

    /**
     * Sertakan accessor file_url di setiap respons JSON / array.
     *
     * @var array<int, string>
     */
    protected $appends = ['file_url'];

    /**
     * Pilihan jenis dokumen yang valid.
     * Dipakai untuk validasi 'in:' dan dropdown Blade/Alpine.
     *
     * @var array<int, string>
     */
    public const JENIS_OPTIONS = [
        'STANDAR',
        'KEBIJAKAN',
        'MANUAL',
        'FORMULIR',
    ];

    // ──────────────────────────────────────────────────────────────
    // ACCESSOR
    // ──────────────────────────────────────────────────────────────

    /**
     * URL publik file PDF.
     * Mengembalikan null jika belum ada file tersimpan.
     *
     * Contoh di Blade  : <a href="{{ $dok->file_url }}">Download</a>
     * Contoh di JS     : response.data.file_url
     *
     * @return string|null
     */
    public function getFileUrlAttribute(): ?string
    {
        if (! $this->path_dokumen) {
            return null;
        }

        return Storage::url($this->path_dokumen);
    }
}