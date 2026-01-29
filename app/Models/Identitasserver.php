<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasServer extends Model
{
    use HasFactory;

    protected $table = 'identitas_server';

    /**
     * Fillable sesuai urutan Excel
     */
    protected $fillable = [
        // 2-5. SERVER INFO
        'no',                    // 2. No
        'ip_host_server',        // 3. IP HOST SERVER
        'nama_server',           // 4. NAMA SERVER
        'lingkungan_server',     // 5. LINGKUNGAN SERVER

        // 6-7. IP SERVER
        'ip_local',              // 6. IP SERVER - LOCAL
        'ip_public',             // 7. IP SERVER - PUBLIC

        // 8-11. SYSTEM SPECS
        'os',                    // 8. OS
        'ram_gb',                // 9. RAM (GB)
        'virtual_socket',        // 10. virtual socket
        'core_per_socket',       // 11. Core per Socket

        // 12-17. STORAGE & SOFTWARE
        'harddisk_gb',           // 12. HARDDISK (GB)
        'versi_php',             // 13. Versi PHP
        'av_bitdefender',        // 14. AV BITDEFENDER
        'administrator',         // 15. Administrator
        'status',                // 16. Status
        'keterangan',            // 17. Keterangan
    ];

    /**
     * Casting
     */
    protected $casts = [
        'no' => 'integer',
        'ram_gb' => 'integer',
        'virtual_socket' => 'integer',
        'core_per_socket' => 'integer',
        'harddisk_gb' => 'integer',
    ];

    /**
     * Daftar pilihan Lingkungan Server
     */
    public static function getLingkunganOptions(): array
    {
        return [
            'Development' => 'Development',
            'Staging' => 'Staging',
            'Production' => 'Production',
        ];
    }

    /**
     * Daftar pilihan AV BitDefender
     */
    public static function getAvBitdefenderOptions(): array
    {
        return [
            'Ada' => 'Ada',
            'Tidak Ada' => 'Tidak Ada',
            'TIDAK ADA' => 'TIDAK ADA',
        ];
    }

    /**
     * Daftar pilihan Status
     */
    public static function getStatusOptions(): array
    {
        return [
            'Aktif' => 'Aktif',
            'Tidak Aktif' => 'Tidak Aktif',
        ];
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Aktif' => 'bg-green-100 text-green-800 border-green-200',
            'Tidak Aktif' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    /**
     * Get lingkungan badge color
     */
    public function getLingkunganColorAttribute(): string
    {
        return match($this->lingkungan_server) {
            'Production' => 'bg-blue-100 text-blue-800 border-blue-200',
            'Staging' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'Development' => 'bg-purple-100 text-purple-800 border-purple-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    /**
     * Get AV badge color
     */
    public function getAvColorAttribute(): string
    {
        return match($this->av_bitdefender) {
            'Ada' => 'bg-green-100 text-green-800 border-green-200',
            'Tidak Ada', 'TIDAK ADA' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    /**
     * Format RAM display
     */
    public function getRamFormattedAttribute(): string
    {
        return $this->ram_gb ? $this->ram_gb . ' GB' : '-';
    }

    /**
     * Format Harddisk display
     */
    public function getHarddiskFormattedAttribute(): string
    {
        return $this->harddisk_gb ? $this->harddisk_gb . ' GB' : '-';
    }

    /**
     * Get total CPU cores
     */
    public function getTotalCoresAttribute(): int
    {
        if ($this->virtual_socket && $this->core_per_socket) {
            return $this->virtual_socket * $this->core_per_socket;
        }
        return 0;
    }
}
