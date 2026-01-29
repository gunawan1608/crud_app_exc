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
        Schema::create('identitas_server', function (Blueprint $table) {
            $table->id(); // 1. ID (auto increment)

            // 2-5. SERVER INFO
            $table->unsignedInteger('no')->comment('2. Nomor urut'); // 2. No
            $table->string('ip_host_server', 45)->comment('3. IP Host Server'); // 3. IP HOST SERVER
            $table->string('nama_server')->comment('4. Nama Server'); // 4. NAMA SERVER
            $table->enum('lingkungan_server', ['Development', 'Staging', 'Production'])
                  ->default('Production')
                  ->comment('5. Lingkungan Server'); // 5. LINGKUNGAN SERVER

            // 6-7. IP SERVER
            $table->string('ip_local', 45)->nullable()->comment('6. IP Local'); // 6. IP SERVER - LOCAL
            $table->string('ip_public', 45)->nullable()->comment('7. IP Public'); // 7. IP SERVER - PUBLIC

            // 8-11. SYSTEM SPECS
            $table->string('os', 100)->nullable()->comment('8. Operating System'); // 8. OS
            $table->unsignedInteger('ram_gb')->nullable()->comment('9. RAM dalam GB'); // 9. RAM (GB)
            $table->unsignedInteger('virtual_socket')->nullable()->comment('10. Virtual Socket'); // 10. virtual socket
            $table->unsignedInteger('core_per_socket')->nullable()->comment('11. Core per Socket'); // 11. Core per Socket

            // 12-17. STORAGE & SOFTWARE
            $table->unsignedInteger('harddisk_gb')->nullable()->comment('12. Harddisk dalam GB'); // 12. HARDDISK (GB)
            $table->string('versi_php', 50)->nullable()->comment('13. Versi PHP'); // 13. Versi PHP
            $table->enum('av_bitdefender', ['Ada', 'Tidak Ada'])
                  ->nullable()
                  ->comment('14. Antivirus BitDefender'); // 14. AV BITDEFENDER
            $table->string('administrator')->nullable()->comment('15. Administrator'); // 15. Administrator
            $table->enum('status', ['Aktif', 'Tidak Aktif'])
                  ->default('Aktif')
                  ->comment('16. Status Server'); // 16. Status
            $table->text('keterangan')->nullable()->comment('17. Keterangan'); // 17. Keterangan

            $table->timestamps();

            // Indexes
            $table->index('ip_host_server');
            $table->index('nama_server');
            $table->index('lingkungan_server');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_server');
    }
};
