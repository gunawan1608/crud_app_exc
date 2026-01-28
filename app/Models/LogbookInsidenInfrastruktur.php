<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogbookInsidenInfrastruktur extends Model
{
    use HasFactory;

    protected $table = 'logbook_insiden_infrastruktur';

    /**
     * Fillable sesuai urutan Excel
     * HANYA field yang boleh diinput user
     */
    protected $fillable = [
        // 2-3. Informasi Pelapor
        'pelapor',                    // 2. Pelapor
        'metode_pelaporan',           // 3. Metode Pelaporan

        // 4-5. Waktu (USER INPUT)
        'waktu_mulai',                // 4. Waktu Mulai
        'waktu_selesai',              // 5. Waktu Selesai

        // 6-9. OTOMATIS (tidak boleh diinput user, tapi perlu di fillable untuk auto-calculation)
        'lama_downtime',              // 6. Lama Downtime (menit) - OTOMATIS
        'konversi_ke_jam',            // 7. Konversi Ke Jam - OTOMATIS
        'sla',                        // 8. SLA - OTOMATIS
        'persentase_sla_tahunan',     // 9. % SLA Tahunan - OTOMATIS

        // 10. Keterangan SLA
        'keterangan_sla',             // 10. Keterangan SLA

        // 11-18. Detail Insiden
        'lokasi',                     // 11. Lokasi
        'insiden',                    // 12. Insiden
        'tipe_insiden',               // 13. Tipe Insiden
        'keterangan',                 // 14. Keterangan
        'akar_penyebab',              // 15. Akar Penyebab
        'tindak_lanjut_detail',       // 16. Tindak Lanjut (Detail)
        'no_ticket',                  // 17. No Ticket (Jika ada)
        'direspon_oleh',              // 18. Direspon Oleh
    ];

    /**
     * Casting sesuai tipe data Excel
     */
    protected $casts = [
        'waktu_mulai' => 'datetime',              // 4. Waktu Mulai
        'waktu_selesai' => 'datetime',            // 5. Waktu Selesai
        'lama_downtime' => 'integer',             // 6. Lama Downtime (menit)
        'konversi_ke_jam' => 'decimal:2',         // 7. Konversi Ke Jam
        'sla' => 'decimal:6',                     // 8. SLA
        'persentase_sla_tahunan' => 'decimal:6',  // 9. % SLA Tahunan
        'direspon_oleh' => 'array',               // 18. Direspon Oleh (JSON)
    ];

    /**
     * 6. Hitung Lama Downtime (menit) - OTOMATIS
     */
    public function hitungLamaDowntime(): int
    {
        if ($this->waktu_mulai && $this->waktu_selesai) {
            return Carbon::parse($this->waktu_mulai)
                ->diffInMinutes(Carbon::parse($this->waktu_selesai));
        }
        return 0;
    }

    /**
     * 7. Hitung Konversi Ke Jam - OTOMATIS
     */
    public function hitungKonversiKeJam(): float
    {
        return round($this->lama_downtime / 60, 2);
    }

    /**
     * 8. Hitung SLA per kejadian - OTOMATIS
     * Formula: SLA_per_kejadian = 100 - ((konversi_ke_jam / 8760) * 100)
     */
    public function hitungSla(): float
    {
        $konversiJam = $this->konversi_ke_jam ?? 0;
        $jamTahunan = 8760;

        $sla = 100 - (($konversiJam / $jamTahunan) * 100);

        return round($sla, 6);
    }

    /**
     * 9. Hitung % SLA Tahunan - OTOMATIS
     * Formula: persentase_sla_tahunan = 100 - SLA_per_kejadian
     */
    public function hitungPersentaseSlaTahunan(): float
    {
        $sla = $this->sla ?? 0;
        return round(100 - $sla, 6);
    }

    /**
     * Hitung SLA Tahunan Global dari semua kejadian
     * Formula Excel: 100% − SUMPRODUCT(100% − SLA per kejadian)
     */
    public static function hitungSlaTahunanGlobal(): float
    {
        $allSla = self::pluck('sla');

        if ($allSla->isEmpty()) {
            return 100.00;
        }

        // SUMPRODUCT(100 - SLA per kejadian)
        $sumProduct = $allSla->sum(function($sla) {
            return 100 - floatval($sla);
        });

        // SLA Tahunan Global = 100 - SUMPRODUCT
        $slaTahunan = 100 - $sumProduct;

        return round($slaTahunan, 2);
    }

    /**
     * Format Lama Downtime ke jam dan menit
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
