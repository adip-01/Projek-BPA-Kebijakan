<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesBisnis extends Model
{
    protected $table = 'proses_bisnis';

    protected $fillable = [
        'title',
        'description',
        'image_path',
    ];
}
