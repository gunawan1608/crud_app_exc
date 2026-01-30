<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_soc', function (Blueprint $table) {
            $table->id();
            
            // Jadwal Pelaksanaan
            $table->date('hari_tanggal');
            $table->string('waktu')->nullable();
            
            // Penanggung Jawab
            $table->string('penanggung_jawab');
            
            // Pelaksana (multiple)
            $table->json('pelaksana')->comment('Array of pelaksana names');
            
            // To Do List
            $table->text('to_do_list');
            
            // Gambar
            $table->string('gambar')->nullable()->comment('Path to uploaded image');
            
            // Keterangan
            $table->text('keterangan')->nullable();
            
            // Terjadi Insiden
            $table->enum('terjadi_insiden', ['ya', 'tidak'])->default('tidak');
            
            // Keterangan Insiden (jika ya)
            $table->text('keterangan_insiden')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('hari_tanggal');
            $table->index('penanggung_jawab');
            $table->index('terjadi_insiden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_soc');
    }
};