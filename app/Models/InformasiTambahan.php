<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InformasiTambahan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini.
     *
     * @var string
     */
    protected $table = 'informasi_tambahans';

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_informasi',
        'path_dokumen',
    ];

    /**
     * Appended accessor agar bisa dipanggil langsung:
     * $informasi->file_url
     *
     * @var array<int, string>
     */
    protected $appends = ['file_url'];

    // ────────────────────────────────────────────────────────────
    // ACCESSOR
    // ────────────────────────────────────────────────────────────

    /**
     * Kembalikan URL publik file dokumen.
     * Mengembalikan null jika tidak ada file yang tersimpan.
     *
     * Contoh penggunaan di Blade:
     *   <a href="{{ $info->file_url }}">Download</a>
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