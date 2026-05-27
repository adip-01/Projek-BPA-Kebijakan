<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DokumenUnit extends Model
{
    protected $table = 'dokumen_units';

    protected $fillable = [
        'unit_bpa',
        'jenis_dokumen',
        'jenis_spesifik',
        'file_path',
    ];

    /**
     * Accessor: URL lengkap file PDF.
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path
            ? Storage::url($this->file_path)
            : null;
    }

    /**
     * Scope: Filter berdasarkan unit_bpa.
     */
    public function scopeByUnit($query, string $unit)
    {
        return $query->where('unit_bpa', $unit);
    }

    /**
     * Scope: Filter berdasarkan jenis_dokumen.
     */
    public function scopeByJenis($query, string $jenis)
    {
        return $query->where('jenis_dokumen', $jenis);
    }
}