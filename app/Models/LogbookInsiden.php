<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogbookInsiden extends Model
{
    use HasFactory;

    protected $table = 'logbook_insiden';

    protected $fillable = [
        'pelapor',
        'metode_pelaporan',
        'waktu_mulai',
        'waktu_selesai',
        'keterangan_waktu_selesai',
        'downtime_menit',
        'konversi_ke_jam',
        'sla',
        'persentase_sla_tahunan',
        'status_sla',
        'target_sla',
        'keterangan_sla',
        'aplikasi',
        'ip_server',
        'tipe_insiden',
        'keterangan',
        'akar_penyebab',
        'tindak_lanjut_detail',
        'direspon_oleh',
        'status_insiden',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'downtime_menit' => 'integer',
        'konversi_ke_jam' => 'decimal:2',
        'persentase_sla_tahunan' => 'decimal:6',
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
    public function hitungKonversiJam(): float
    {
        return round($this->downtime_menit / 60, 2);
    }

    /**
     * Hitung SLA Per Kejadian (Otomatis)
     * Formula: SLA = 100 - (downtime_jam / 8760 * 100)
     */
    public function hitungSlaBiasa(): float
    {
        $downtimeJam = $this->konversi_ke_jam ?? 0;
        $jamTahunan = 8760;

        $sla = 100 - (($downtimeJam / $jamTahunan) * 100);

        return round($sla, 6);
    }

    /**
     * Hitung SLA Tahunan dari semua kejadian
     * Formula Excel: 100% − SUMPRODUCT(100% − SLA per kejadian)
     * atau: SLA_tahunan = 100 - SUM(100 - SLA_per_kejadian)
     */
    public static function hitungSlaTahunan(): float
    {
        // Ambil semua SLA per kejadian
        $allSla = self::pluck('sla');

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
    public static function tentukanStatusSla(?float $targetSla = null): string
    {
        if ($targetSla === null) {
            $targetSla = self::min('target_sla') ?? 98.00;
        }

        $slaTahunan = self::hitungSlaTahunan();

        return $slaTahunan >= $targetSla ? 'TERCAPAI' : 'TIDAK TERCAPAI';
    }

    /**
     * Format downtime ke jam dan menit
     */
    public function getDowntimeFormatted(): string
    {
        $hours = floor($this->downtime_menit / 60);
        $minutes = $this->downtime_menit % 60;

        if ($hours > 0) {
            return "{$hours} jam {$minutes} menit";
        }
        return "{$minutes} menit";
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status_insiden) {
            'Open' => 'bg-red-100 text-red-800',
            'On Progress' => 'bg-yellow-100 text-yellow-800',
            'Closed' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get SLA status color
     */
    public function getSlaStatusColorAttribute(): string
    {
        return match($this->status_sla) {
            'TERCAPAI' => 'bg-green-100 text-green-800',
            'TIDAK TERCAPAI' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
