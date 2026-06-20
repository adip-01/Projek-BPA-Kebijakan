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
        Schema::create('daftar_dokumens', function (Blueprint $table) {
            $table->id();

            // ── Step 1 fields ───────────────────────────────────
            $table->string('standard')->nullable();
            $table->string('klasul')->nullable();
            $table->string('jenis_dokumen');           // wajib
            $table->string('nama_dokumen');             // wajib
            $table->string('pemilik_dokumen')->nullable();
            $table->text('data_pendukung')->nullable(); // bisa panjang

            // ── Step 2 fields ───────────────────────────────────
            $table->string('link_aplikasi')->nullable();
            $table->string('revisi_dokumen')->nullable();
            $table->date('tanggal_efektif')->nullable();
            $table->string('path_dokumen')->nullable();  // path file PDF

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_dokumens');
    }
};