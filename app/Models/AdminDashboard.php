<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdminDashboard extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini.
     *
     * @var string
     */
    protected $table = 'admin_dashboards';

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_dokumen',
        'jenis_bpa',
        'path_dokumen',
    ];

    /**
     * Sertakan accessor file_url di setiap respons JSON / array.
     *
     * @var array<int, string>
     */
    protected $appends = ['file_url'];

    /**
     * Pilihan jenis BPA yang valid.
     * Dipakai untuk validasi 'in:' dan dropdown.
     *
     * @var array<int, string>
     */
    public const BPA_OPTIONS = [
        'BPA 1',
        'BPA 2',
        'BPA 3',
        'BPA 4',
    ];

    // ──────────────────────────────────────────────────────────────
    // ACCESSOR
    // ──────────────────────────────────────────────────────────────

    /**
     * URL publik file PDF.
     * Mengembalikan null jika belum ada file tersimpan.
     *
     * Contoh di Blade : <a href="{{ $dok->file_url }}">Download</a>
     * Contoh di JS    : response.data.file_url
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