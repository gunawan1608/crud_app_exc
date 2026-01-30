<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanSoc extends Model
{
    use HasFactory;

    protected $table = 'catatan_soc';

    protected $fillable = [
        'hari_tanggal',
        'waktu',
        'penanggung_jawab',
        'pelaksana',
        'to_do_list',
        'gambar',
        'keterangan',
        'terjadi_insiden',
        'keterangan_insiden',
    ];

    protected $casts = [
        'hari_tanggal' => 'date',
        'pelaksana' => 'array',
    ];

    /**
     * Daftar penanggung jawab yang tersedia
     */
    public static function getPenanggungJawabOptions(): array
    {
        return [
            'Akbar Aryanto',
            'Anang Tri Setyo Utomo',
            'Yopi Prasetyo',
            'Indra Hikmawan',
            'Andrew A.M.S. Pane',
            'Dian Purnamasari',
            'M. Zidni Ilman',
            'Romario Samuel Siahaan',
        ];
    }

    /**
     * Daftar pelaksana yang tersedia
     */
    public static function getPelaksanaOptions(): array
    {
        return [
            'Yopi Prasetyo',
            'M. Zidni Ilman',
            'Lainnya',
        ];
    }

    /**
     * Get formatted pelaksana names
     */
    public function getPelaksanaNames(): string
    {
        if (empty($this->pelaksana)) {
            return '-';
        }

        return implode(', ', $this->pelaksana);
    }

    /**
     * Get insiden badge color
     */
    public function getInsidenColorAttribute(): string
    {
        return match($this->terjadi_insiden) {
            'ya' => 'bg-red-100 text-red-800 border-red-200',
            'tidak' => 'bg-green-100 text-green-800 border-green-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}