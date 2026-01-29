<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identitas_server', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('no');
            $table->string('ip_host_server', 45);
            $table->string('nama_server');
            $table->string('lingkungan_server', 50);

            $table->string('ip_local', 45)->nullable();
            $table->string('ip_public', 45)->nullable();

            $table->string('os', 100)->nullable();
            $table->unsignedInteger('ram_gb')->nullable();
            $table->unsignedInteger('virtual_socket')->nullable();
            $table->unsignedInteger('core_per_socket')->nullable();

            $table->unsignedInteger('harddisk_gb')->nullable();
            $table->string('versi_php', 50)->nullable();
            $table->string('av_bitdefender', 50)->nullable();
            $table->string('administrator')->nullable();
            $table->string('status', 50);
            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->index('ip_host_server');
            $table->index('nama_server');
            $table->index('lingkungan_server');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identitas_server');
    }
};
