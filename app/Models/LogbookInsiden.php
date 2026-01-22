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
        'status_sla',
        'persentase_sla_tahunan',
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
        'persentase_sla_tahunan' => 'decimal:2',
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
}
