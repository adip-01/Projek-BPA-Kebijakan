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
        Schema::create('dokumen_spmis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');                              // wajib
            $table->string('nomor_dokumen');                             // wajib
            $table->enum('jenis_dokumen', [                              // wajib
                'STANDAR',
                'KEBIJAKAN',
                'MANUAL',
                'FORMULIR',
            ]);
            $table->string('path_dokumen')->nullable();                  // path PDF
            $table->timestamps(); // created_at = Tanggal Diunggah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_spmis');
    }
};