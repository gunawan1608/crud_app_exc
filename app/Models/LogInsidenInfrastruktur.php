<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogInsidenInfrastruktur extends Model
{
    use HasFactory;

    protected $table = 'log_insiden_infrastruktur';

    protected $fillable = [
        'lokasi',
        'insiden',
        'tipe_insiden',
        'keterangan',
        'akar_penyebab',
        'tindak_lanjut',
        'no_ticket',
        'direspon_oleh',
        'waktu_mulai',
        'waktu_selesai',
        'lama_downtime',
        'downtime_jam',
        'sla_persen',
        'sla_tahunan',
        'target_sla',
        'status_sla',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'direspon_oleh' => 'array',
        'lama_downtime' => 'integer',
        'downtime_jam' => 'decimal:2',
        'sla_persen' => 'decimal:6',
        'sla_tahunan' => 'decimal:6',
        'target_sla' => 'decimal:2',
    ];

    /**
     * Hitung downtime otomatis dalam menit
     */
    public function hitungDowntime(): int
    {
        if ($this->waktu_mulai && $this->waktu_selesai) {
            return Carbon::parse($this->waktu_mulai)
                ->diffInMinutes(Carbon::parse($this->waktu_selesai));
        }
        return 0;
    }

    /**
     * Hitung konversi ke jam
     */
    public function hitungDowntimeJam(): float
    {
        return round($this->lama_downtime / 60, 2);
    }

    /**
     * Hitung SLA Per Kejadian (Otomatis)
     * Formula: SLA = 100 - (downtime_jam / 24 * 100)
     * Note: Menggunakan 24 jam sebagai base (berbeda dengan logbook aplikasi yang menggunakan 8760 jam/tahun)
     */
    public function hitungSlaPersen(): float
    {
        $downtimeJam = $this->downtime_jam ?? 0;
        $jamPerHari = 24;

        $sla = 100 - (($downtimeJam / $jamPerHari) * 100);

        return round($sla, 6);
    }

    /**
     * Hitung SLA Tahunan dari semua kejadian
     * Formula: SLA_tahunan = 100 - SUM(100 - SLA_per_kejadian)
     */
    public static function hitungSlaTahunan(): float
    {
        // Ambil semua SLA per kejadian
        $allSla = self::pluck('sla_persen');

        if ($allSla->isEmpty()) {
            return 100.00;
        }

        // Hitung SUMPRODUCT(100 - SLA per kejadian)
        $sumProduct = $allSla->sum(function($sla) {
            return 100 - floatval($sla);
        });

        // SLA Tahunan = 100 - SUMPRODUCT
        $slaTahunan = 100 - $sumProduct;

        return round($slaTahunan, 2);
    }

    /**
     * Tentukan status SLA berdasarkan target
     */
    public static function tentukanStatusSla($slaTahunan, $targetSla)
    {
        return $slaTahunan >= $targetSla
            ? 'SLA TERCAPAI'
            : 'SLA TIDAK TERCAPAI';
    }

    /**
     * Format downtime ke jam dan menit
     */
    public function getDowntimeFormatted(): string
    {
        $hours = floor($this->lama_downtime / 60);
        $minutes = $this->lama_downtime % 60;

        if ($hours > 0) {
            return "{$hours} jam {$minutes} menit";
        }
        return "{$minutes} menit";
    }

    /**
     * Get formatted direspon_oleh
     */
    public function getResponderNames(): string
    {
        if (empty($this->direspon_oleh)) {
            return '-';
        }

        return implode(', ', $this->direspon_oleh);
    }

    /**
     * Get status badge color
     */
    public function getSlaStatusColorAttribute(): string
    {
        return match($this->status_sla) {
            'SLA TERCAPAI' => 'bg-green-100 text-green-800 border-green-200',
            'SLA TIDAK TERCAPAI' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    /**
     * Daftar lokasi yang tersedia
     */
    public static function getLokasiOptions(): array
    {
        return [
            'BSN - Kantor Mampang' => 'BSN - Kantor Mampang',
            'BSN - SNSU 1' => 'BSN - SNSU 1',
            'BSN - SNSU 2' => 'BSN - SNSU 2',
        ];
    }

    /**
     * Daftar responder yang tersedia
     */
    public static function getResponderOptions(): array
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
     * Daftar tipe insiden
     */
    public static function getTipeInsidenOptions(): array
    {
        return [
            'Infrastruktur',
            'Hardware',
            'Jaringan',
            'Lainnya',
        ];
    }
}
