<?php

namespace App\Exports;

use App\Models\LogbookInsiden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogbookExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Get data collection
     */
    public function collection()
    {
        return LogbookInsiden::orderBy('waktu_mulai', 'desc')->get();
    }

    /**
     * Header kolom Excel (sesuai template logbook)
     */
    public function headings(): array
    {
        return [
            'No',
            'Pelapor',
            'Metode Pelaporan',
            'Waktu Mulai',
            'Waktu Selesai',
            'Keterangan Waktu Selesai',
            'Downtime (Menit)',
            'Konversi ke Jam',
            'SLA',
            'Persentase SLA Tahunan',
            'Keterangan SLA',
            'Aplikasi',
            'IP Server',
            'Tipe Insiden',
            'Keterangan',
            'Akar Penyebab',
            'Tindak Lanjut Detail',
            'Direspon Oleh',
            'Status Insiden',
        ];
    }

    /**
     * Map data ke kolom Excel
     */
    public function map($logbook): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $logbook->pelapor,
            $logbook->metode_pelaporan,
            $logbook->waktu_mulai ? $logbook->waktu_mulai->format('d/m/Y H:i') : '',
            $logbook->waktu_selesai ? $logbook->waktu_selesai->format('d/m/Y H:i') : '',
            $logbook->keterangan_waktu_selesai,
            $logbook->downtime_menit,
            $logbook->konversi_ke_jam,
            $logbook->sla,
            $logbook->persentase_sla_tahunan,
            $logbook->keterangan_sla,
            $logbook->aplikasi,
            $logbook->ip_server,
            $logbook->tipe_insiden,
            $logbook->keterangan,
            $logbook->akar_penyebab,
            $logbook->tindak_lanjut_detail,
            $logbook->direspon_oleh,
            $logbook->status_insiden,
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '22C55E'], // Hijau
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
