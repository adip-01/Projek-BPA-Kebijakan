<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bisnis_proses', function (Blueprint $table) {
            $table->id();
            $table->string('judul_proses');
            $table->string('path_gambar')->nullable();   // path ke file gambar (jpg/png)
            $table->string('path_dokumen')->nullable();  // path ke file PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bisnis_proses');
    }
};