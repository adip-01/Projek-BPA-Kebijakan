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
            $table->string('nama_dokumen');
            $table->enum('jenis_bpa', ['BPA 1', 'BPA 2', 'BPA 3', 'BPA 4'])
                  ->default('BPA 1');
            $table->string('path_dokumen')->nullable(); // Path file PDF
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