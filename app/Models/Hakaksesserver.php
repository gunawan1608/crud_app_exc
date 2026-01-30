<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAksesServer extends Model
{
    use HasFactory;

    protected $table = 'hak_akses_server';

    protected $fillable = [
        'ip_host_server',
        'nama_server',
        'lingkungan_server',
        'ip_local',
        'ip_public',
        'aplikasi',
        'kategori_sistem_elektronik',
        'role_hak_akses',
        'akun',
        'pemilik_hak_akses',
        'hak_akses',
        'status',
        'keterangan',
    ];

    /**
     * Daftar IP Host Server (sama dengan Identitas Server)
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
     * Daftar Lingkungan Server
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
     * Daftar Kategori Sistem Elektronik
     */
    public static function getKategoriSistemOptions(): array
    {
        return [
            'tinggi' => 'Tinggi',
            'Strategis' => 'Strategis',
            'Tinggi' => 'Tinggi',
            'Rendah' => 'Rendah',
            'Belum di kategorikan' => 'Belum di kategorikan',
        ];
    }

    /**
     * Daftar Role Hak Akses
     */
    public static function getRoleHakAksesOptions(): array
    {
        return [
            'Pengembang Internal' => 'Pengembang Internal',
            'Vendor' => 'Vendor',
        ];
    }

    /**
     * Daftar Status
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
     * Get kategori sistem badge color
     */
    public function getKategoriColorAttribute(): string
    {
        return match($this->kategori_sistem_elektronik) {
            'Tinggi' => 'bg-red-100 text-red-800 border-red-200',
            'Strategis' => 'bg-purple-100 text-purple-800 border-purple-200',
            'Rendah' => 'bg-green-100 text-green-800 border-green-200',
            'Belum di kategorikan' => 'bg-gray-100 text-gray-800 border-gray-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    /**
     * Get role badge color
     */
    public function getRoleColorAttribute(): string
    {
        return match($this->role_hak_akses) {
            'Pengembang Internal' => 'bg-blue-100 text-blue-800 border-blue-200',
            'Vendor' => 'bg-orange-100 text-orange-800 border-orange-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
