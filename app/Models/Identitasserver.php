<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasServer extends Model
{
    use HasFactory;

    protected $table = 'identitas_server';

    protected $fillable = [
        'no',
        'ip_host_server',
        'nama_server',
        'lingkungan_server',
        'ip_local',
        'ip_public',
        'os',
        'ram_gb',
        'virtual_socket',
        'core_per_socket',
        'harddisk_gb',
        'versi_php',
        'av_bitdefender',
        'administrator',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'no' => 'integer',
        'ram_gb' => 'integer',
        'virtual_socket' => 'integer',
        'core_per_socket' => 'integer',
        'harddisk_gb' => 'integer',
    ];

    /**
     * Daftar pilihan IP Host Server
     */
    public static function getIpHostServerOptions(): array
    {
        return [
            '192.168.10.21' => '192.168.10.21',
            '192.168.10.22' => '192.168.10.22',
            '192.168.10.24' => '192.168.10.24',
            '202.43.168.180' => '202.43.168.180',
        ];
    }

    /**
     * Daftar pilihan Lingkungan Server
     */
    public static function getLingkunganOptions(): array
    {
        return [
            'Production' => 'Production',
            'Development' => 'Development',
            'Staging' => 'Staging',
        ];
    }

    /**
     * Daftar pilihan AV BitDefender
     */
    public static function getAvBitdefenderOptions(): array
    {
        return [
            'ADA' => 'ADA',
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
            'ADA' => 'bg-green-100 text-green-800 border-green-200',
            'TIDAK ADA' => 'bg-red-100 text-red-800 border-red-200',
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
