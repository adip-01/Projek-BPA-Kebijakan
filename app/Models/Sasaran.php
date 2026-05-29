<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

class Sasaran extends Model
{
    use HasFactory;

    protected $table = 'sasarans';

    protected $fillable = [
        'nama_sasaran',
        'nomor_dokumen',
        'jenis_dokumen',
        'tahun_berlaku',
        'path_dokumen',
        'path_gambar',
    ];

    // Tambahkan Accessor ini agar mudah ambil link file
    public function getFileUrlAttribute(): ?string
    {
        return $this->path_dokumen ? Storage::url($this->path_dokumen) : null;
    }

    // Tambahkan Accessor ini agar mudah ambil link gambar
    public function getGambarUrlAttribute(): ?string
    {
        return $this->path_gambar ? Storage::url($this->path_gambar) : null;
    }
}