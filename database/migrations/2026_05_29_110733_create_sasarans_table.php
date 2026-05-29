<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sasarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sasaran');
            $table->string('nomor_dokumen')->nullable();
            $table->string('jenis_dokumen');
            $table->string('tahun_berlaku')->nullable();
            $table->string('path_dokumen')->nullable(); // Path file PDF
            $table->string('path_gambar')->nullable();  // Path thumbnail gambar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sasarans');
    }
};