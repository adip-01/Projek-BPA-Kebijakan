<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_bpa');
            $table->enum('jenis_dokumen', ['Dokumen Milik', 'Dokumen Distribusi']);
            $table->enum('jenis_spesifik', ['Prosedur', 'Instruksi Kerja', 'Formulir SPMI', 'Dokumen Internal']);
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_units');
    }
};