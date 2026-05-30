<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarDokumen extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini.
     * Eksplisit karena Laravel akan menebak "daftar_dokumen" (singular).
     *
     * @var string
     */
    protected $table = 'daftar_dokumens';

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
     * Nilai BPA yang valid — digunakan untuk validasi & dropdown.
     *
     * @var array<int, string>
     */
    public const BPA_OPTIONS = ['BPA 1', 'BPA 2', 'BPA 3', 'BPA 4'];
}