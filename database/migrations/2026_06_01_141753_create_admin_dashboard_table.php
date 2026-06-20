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
        Schema::create('admin_dashboards', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');                    // wajib
            $table->enum('jenis_bpa', [                        // wajib
                'BPA 1',
                'BPA 2',
                'BPA 3',
                'BPA 4',
            ]);
            $table->string('path_dokumen')->nullable();         // path PDF
            $table->timestamps(); // created_at = Tanggal Diunggah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_dashboards');
    }
};