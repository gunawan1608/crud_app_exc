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
        Schema::table('logbook_insiden', function (Blueprint $table) {
            // Tambahkan field target_sla (SATU-SATUNYA field baru)
            if (!Schema::hasColumn('logbook_insiden', 'target_sla')) {
                $table->decimal('target_sla', 5, 2)->default(98.00)->after('status_sla')
                    ->comment('Target SLA yang diinput user sebagai pembanding (default 98%)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbook_insiden', function (Blueprint $table) {
            if (Schema::hasColumn('logbook_insiden', 'target_sla')) {
                $table->dropColumn('target_sla');
            }
        });
    }
};
