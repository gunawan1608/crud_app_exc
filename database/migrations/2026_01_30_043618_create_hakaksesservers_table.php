<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hak_akses_server', function (Blueprint $table) {
            $table->id();

            // Server Info
            $table->string('ip_host_server', 45);
            $table->string('nama_server');
            $table->string('lingkungan_server', 50);

            // IP Server
            $table->string('ip_local', 45)->nullable();
            $table->string('ip_public', 45)->nullable();

            // Aplikasi & Kategori
            $table->string('aplikasi');
            $table->string('kategori_sistem_elektronik', 100);
            $table->string('role_hak_akses');

            // Hak Akses Detail
            $table->string('akun');
            $table->string('pemilik_hak_akses');
            $table->string('hak_akses');
            $table->string('status', 50);
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('ip_host_server');
            $table->index('nama_server');
            $table->index('aplikasi');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hak_akses_server');
    }
};
