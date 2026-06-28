<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('number')->nullable();
            $table->string('category');
            $table->string('owner')->nullable();
            $table->date('effective_date')->nullable();
            $table->string('version')->default('v1.0');
            $table->string('status')->default('Aktif');
            $table->text('description')->nullable();
            $table->text('klausul')->nullable();
            $table->string('link')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
