<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BisnisProses extends Model
{
    protected $table = 'bisnis_proses';

    protected $fillable = [
        'judul_proses',
        'path_gambar',
        'path_dokumen',
    ];

    /**
     * Accessor: URL gambar lengkap.
     * Mengembalikan URL storage jika ada file, null jika tidak.
     */
    public function getGambarUrlAttribute(): ?string
    {
        return $this->path_gambar
            ? Storage::url($this->path_gambar)
            : null;
    }

    /**
     * Accessor: URL dokumen PDF lengkap.
     */
    public function getDokumenUrlAttribute(): ?string
    {
        return $this->path_dokumen
            ? Storage::url($this->path_dokumen)
            : null;
    }
}