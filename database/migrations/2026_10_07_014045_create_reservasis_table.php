<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id('id_reservasi');
            $table->foreignId('id_ruang')->constrained('ruangs', 'id_ruang')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_pengaju');
            $table->string('asal_unit_divisi');
            $table->integer('jumlah_peserta');
            $table->boolean('hubungi_leader_cs')->default(false);
            $table->date('tanggal_pinjam');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status_reservasi', ['berhasil', 'terbatal_otomatis', 'selesai'])->default('berhasil');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};