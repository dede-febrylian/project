<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruangs', function (Blueprint $table) {
            $table->id('id_ruang');
            $table->string('nama_ruang');
            $table->integer('kapasitas_maksimal');
            $table->text('deskripsi')->nullable();
            $table->enum('status_ruang', ['tersedia', 'digunakan'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruangs');
    }
};