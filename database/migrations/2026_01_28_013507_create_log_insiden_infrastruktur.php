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
        Schema::create('logbook_insiden_infrastruktur', function (Blueprint $table) {
            $table->id(); // 1. No (auto increment)

            // 2-3. Informasi Pelapor
            $table->string('pelapor'); // 2. Pelapor
            $table->string('metode_pelaporan'); // 3. Metode Pelaporan

            // 4-7. Waktu & Downtime (OTOMATIS)
            $table->datetime('waktu_mulai'); // 4. Waktu Mulai
            $table->datetime('waktu_selesai'); // 5. Waktu Selesai
            $table->integer('lama_downtime')->default(0)->comment('6. Lama Downtime (menit) - OTOMATIS'); // 6. Lama Downtime
            $table->decimal('konversi_ke_jam', 8, 2)->default(0)->comment('7. Konversi Ke Jam - OTOMATIS'); // 7. Konversi Ke Jam

            // 8-10. SLA (OTOMATIS)
            $table->decimal('sla', 8, 6)->default(0)->comment('8. SLA per kejadian (%) - OTOMATIS'); // 8. SLA
            $table->decimal('persentase_sla_tahunan', 8, 6)->default(0)->comment('9. % SLA Tahunan - OTOMATIS'); // 9. % SLA Tahunan
            $table->text('keterangan_sla')->nullable(); // 10. Keterangan SLA

            // 11-18. Detail Insiden
            $table->string('lokasi'); // 11. Lokasi
            $table->string('insiden'); // 12. Insiden
            $table->string('tipe_insiden')->nullable(); // 13. Tipe Insiden
            $table->text('keterangan'); // 14. Keterangan
            $table->text('akar_penyebab')->nullable(); // 15. Akar Penyebab
            $table->text('tindak_lanjut_detail')->nullable(); // 16. Tindak Lanjut (Detail)
            $table->string('no_ticket')->nullable(); // 17. No Ticket (Jika ada)
            $table->json('direspon_oleh'); // 18. Direspon Oleh (multiple select)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook_insiden_infrastruktur');
    }
};
