<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logbook_insiden', function (Blueprint $table) {

            // HAPUS no_ticket JIKA ADA
            if (Schema::hasColumn('logbook_insiden', 'no_ticket')) {
                $table->dropColumn('no_ticket');
            }

            // TAMBAHAN SESUAI EXCEL
            if (!Schema::hasColumn('logbook_insiden', 'keterangan_waktu_selesai')) {
                $table->text('keterangan_waktu_selesai')->nullable()->after('waktu_selesai');
            }

            if (!Schema::hasColumn('logbook_insiden', 'konversi_ke_jam')) {
                $table->decimal('konversi_ke_jam', 8, 2)->default(0)->after('downtime_menit');
            }

            if (!Schema::hasColumn('logbook_insiden', 'sla')) {
                $table->string('sla')->nullable()->after('konversi_ke_jam');
            }

            if (!Schema::hasColumn('logbook_insiden', 'persentase_sla_tahunan')) {
                $table->decimal('persentase_sla_tahunan', 5, 2)->nullable()->after('sla');
            }

            if (!Schema::hasColumn('logbook_insiden', 'keterangan_sla')) {
                $table->text('keterangan_sla')->nullable()->after('persentase_sla_tahunan');
            }

            if (!Schema::hasColumn('logbook_insiden', 'aplikasi')) {
                $table->string('aplikasi')->nullable()->after('keterangan_sla');
            }

            if (!Schema::hasColumn('logbook_insiden', 'ip_server')) {
                $table->string('ip_server')->nullable()->after('aplikasi');
            }

            if (!Schema::hasColumn('logbook_insiden', 'tipe_insiden')) {
                $table->string('tipe_insiden')->nullable()->after('ip_server');
            }

            if (!Schema::hasColumn('logbook_insiden', 'akar_penyebab')) {
                $table->text('akar_penyebab')->nullable()->after('keterangan');
            }

            if (!Schema::hasColumn('logbook_insiden', 'tindak_lanjut_detail')) {
                $table->text('tindak_lanjut_detail')->nullable()->after('akar_penyebab');
            }

            if (!Schema::hasColumn('logbook_insiden', 'status_insiden')) {
                $table->enum('status_insiden', ['Open', 'On Progress', 'Closed'])
                    ->default('Open')
                    ->after('tindak_lanjut_detail');
            }
        });
    }

    public function down(): void
    {
        Schema::table('logbook_insiden', function (Blueprint $table) {
            $table->dropColumn([
                'keterangan_waktu_selesai',
                'konversi_ke_jam',
                'sla',
                'persentase_sla_tahunan',
                'keterangan_sla',
                'aplikasi',
                'ip_server',
                'tipe_insiden',
                'akar_penyebab',
                'tindak_lanjut_detail',
                'status_insiden',
            ]);

            // rollback aman
            $table->string('no_ticket')->nullable();
        });
    }
};
