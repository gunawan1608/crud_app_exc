<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbook_insiden', function (Blueprint $table) {
            $table->id();

            // WAKTU
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->text('keterangan_waktu_selesai')->nullable();

            // DOWNTIME & SLA
            $table->integer('downtime_menit')->default(0);
            $table->decimal('konversi_ke_jam', 8, 2)->default(0);
            $table->string('sla')->nullable();
            $table->decimal('persentase_sla_tahunan', 5, 2)->nullable();
            $table->text('keterangan_sla')->nullable();

            // INSIDEN
            $table->string('aplikasi')->nullable();
            $table->string('ip_server')->nullable();
            $table->string('tipe_insiden')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('akar_penyebab')->nullable();
            $table->text('tindak_lanjut_detail')->nullable();

            // STATUS
            $table->enum('status_insiden', ['Open', 'On Progress', 'Closed'])
                  ->default('Open');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbook_insiden');
    }
};
