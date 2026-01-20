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
        'downtime_menit',
        'no_ticket',
        'direspon_oleh',
        'keterangan',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
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
}