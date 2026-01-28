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
        Schema::create('log_insiden_infrastruktur', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor')->nullable();
            $table->string('metode_pelaporan')->nullable();
            $table->string('lokasi');
            $table->string('insiden');
            $table->string('tipe_insiden')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('akar_penyebab')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->string('no_ticket')->nullable();
            $table->json('direspon_oleh')->nullable();

            // Waktu & Downtime
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_selesai');
            $table->integer('lama_downtime')->default(0)->comment('Downtime dalam menit');
            $table->decimal('downtime_jam', 8, 2)->default(0)->comment('Downtime dalam jam');

            // SLA Otomatis
            $table->decimal('sla_persen', 8, 6)->default(0)->comment('SLA per kejadian (%)');
            $table->decimal('sla_tahunan', 8, 6)->default(0)->comment('Kontribusi ke SLA tahunan (%)');
            $table->decimal('target_sla', 5, 2)->default(98.00)->comment('Target SLA yang diinginkan (%)');
            $table->string('status_sla')->nullable()->comment('Status pencapaian SLA');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_insiden_infrastruktur');
    }
};
