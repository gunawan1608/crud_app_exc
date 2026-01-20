<?php

namespace App\Imports;

use App\Models\LogbookInsiden;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LogbookImport implements ToModel, WithHeadingRow
{
    /**
     * Map kolom Excel ke database
     */
    public function model(array $row)
    {
        // Parse waktu mulai dan selesai
        $waktuMulai = $this->parseDate($row['waktu_mulai'] ?? null);
        $waktuSelesai = $this->parseDate($row['waktu_selesai'] ?? null);

        // Hitung downtime
        $lamaDowntime = 0;
        $konversiJam = 0;

        if ($waktuMulai && $waktuSelesai) {
            $lamaDowntime = Carbon::parse($waktuMulai)->diffInMinutes(Carbon::parse($waktuSelesai));
            $konversiJam = round($lamaDowntime / 60, 2);
        }

        return new LogbookInsiden([
            'pelapor' => $row['pelapor'] ?? null,
            'metode_pelaporan' => $row['metode_pelaporan'] ?? 'Email',
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'keterangan_waktu_selesai' => $row['keterangan_waktu_selesai'] ?? null,
            'downtime_menit' => $lamaDowntime,
            'konversi_ke_jam' => $konversiJam,
            'sla' => $row['sla'] ?? null,
            'persentase_sla_tahunan' => $row['persentase_sla_tahunan'] ?? null,
            'keterangan_sla' => $row['keterangan_sla'] ?? null,
            'aplikasi' => $row['aplikasi'] ?? null,
            'ip_server' => $row['ip_server'] ?? null,
            'tipe_insiden' => $row['tipe_insiden'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
            'akar_penyebab' => $row['akar_penyebab'] ?? null,
            'tindak_lanjut_detail' => $row['tindak_lanjut_detail'] ?? null,
            'direspon_oleh' => $row['direspon_oleh'] ?? null,
            'status_insiden' => $this->parseStatus($row['status_insiden'] ?? 'Open'),
        ]);
    }

    /**
     * Parse tanggal dari berbagai format Excel
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // Jika numeric (Excel date serial number)
        if (is_numeric($value)) {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        }

        // Coba parse sebagai string
        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Normalisasi status insiden
     */
    private function parseStatus($value)
    {
        $value = strtolower(trim($value ?? ''));

        if (in_array($value, ['on progress', 'progress', 'in progress'])) {
            return 'On Progress';
        }

        if (in_array($value, ['closed', 'close', 'done', 'selesai'])) {
            return 'Closed';
        }

        return 'Open';
    }
}
