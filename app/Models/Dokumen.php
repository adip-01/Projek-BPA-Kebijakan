<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = [
        'title',
        'number',
        'category',
        'owner',
        'effective_date',
        'version',
        'status',
        'description',
        'klausul',
        'link',
        'file_path',
    ];

    protected $casts = [
        'effective_date' => 'date',
    ];

    // Dipakai di dokumen/index.blade.php -> {{ $doc->formatted_effective_date }}
    public function getFormattedEffectiveDateAttribute(): string
    {
        return $this->effective_date?->translatedFormat('d M Y') ?? '—';
    }
}
