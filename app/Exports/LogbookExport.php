<?php

namespace App\Exports;

use App\Models\LogbookInsiden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LogbookExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithTitle,WithEvents
{
    /**
     * Get data collection
     */
    public function collection()
    {
        return LogbookInsiden::orderBy('waktu_mulai', 'desc')->get();
    }

    /**
     * Header kolom Excel (lengkap dan terstruktur)
     */
    public function headings(): array
    {
        return [
            'No',
            'Pelapor',
            'Metode Pelaporan',
            'Aplikasi',
            'IP Server',
            'Tipe Insiden',
            'Waktu Mulai',
            'Waktu Selesai',
            'Keterangan Waktu Selesai',
            'Downtime (Menit)',
            'Konversi ke Jam',
            'SLA',
            'Persentase SLA Tahunan (%)',
            'Keterangan SLA',
            'Keterangan Insiden',
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
            $logbook->pelapor ?? '',
            $logbook->metode_pelaporan ?? '',
            $logbook->aplikasi ?? '',
            $logbook->ip_server ?? '',
            $logbook->tipe_insiden ?? '',
            $logbook->waktu_mulai ? $logbook->waktu_mulai->format('d/m/Y H:i') : '',
            $logbook->waktu_selesai ? $logbook->waktu_selesai->format('d/m/Y H:i') : '',
            $logbook->keterangan_waktu_selesai ?? '',
            $logbook->downtime_menit ?? 0,
            $logbook->konversi_ke_jam ?? 0,
            $logbook->sla ?? '',
            $logbook->persentase_sla_tahunan ?? '',
            $logbook->keterangan_sla ?? '',
            $logbook->keterangan ?? '',
            $logbook->akar_penyebab ?? '',
            $logbook->tindak_lanjut_detail ?? '',
            $logbook->direspon_oleh ?? '',
            $logbook->status_insiden ?? '',
        ];
    }

    /**
     * Lebar kolom yang optimal
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Pelapor
            'C' => 15,  // Metode Pelaporan
            'D' => 20,  // Aplikasi
            'E' => 15,  // IP Server
            'F' => 18,  // Tipe Insiden
            'G' => 16,  // Waktu Mulai
            'H' => 16,  // Waktu Selesai
            'I' => 25,  // Keterangan Waktu Selesai
            'J' => 12,  // Downtime (Menit)
            'K' => 12,  // Konversi ke Jam
            'L' => 10,  // SLA
            'M' => 18,  // Persentase SLA Tahunan
            'N' => 25,  // Keterangan SLA
            'O' => 35,  // Keterangan Insiden
            'P' => 30,  // Akar Penyebab
            'Q' => 30,  // Tindak Lanjut Detail
            'R' => 20,  // Direspon Oleh
            'S' => 12,  // Status Insiden
        ];
    }

    /**
     * Nama sheet
     */
    public function title(): string
    {
        return 'Data Insiden';
    }

    /**
     * Styling Excel yang lebih baik
     */
  public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {

            $sheet = $event->sheet->getDelegate();
            $lastRow = $sheet->getHighestRow();

            // === HEADER ===
            $sheet->getStyle('A1:S1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '16A34A'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);

            $sheet->getRowDimension(1)->setRowHeight(30);

            // === DATA BORDER ===
            if ($lastRow > 1) {
                $sheet->getStyle("A2:S{$lastRow}")->applyFromArray([
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_TOP,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Zebra striping
                for ($i = 2; $i <= $lastRow; $i++) {
                    if ($i % 2 === 0) {
                        $sheet->getStyle("A{$i}:S{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'F9FAFB'],
                            ],
                        ]);
                    }
                }

                // Kolom alignment
                $sheet->getStyle("A2:A{$lastRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("J2:K{$lastRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                $sheet->getStyle("M2:M{$lastRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                $sheet->getStyle("S2:S{$lastRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Status warna
                for ($i = 2; $i <= $lastRow; $i++) {
                    $status = $sheet->getCell("S{$i}")->getValue();

                    if ($status === 'Open') {
                        $sheet->getStyle("S{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FEE2E2'],
                            ],
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => '991B1B'],
                            ],
                        ]);
                    }

                    if ($status === 'On Progress') {
                        $sheet->getStyle("S{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FEF3C7'],
                            ],
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => '92400E'],
                            ],
                        ]);
                    }

                    if ($status === 'Closed') {
                        $sheet->getStyle("S{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'D1FAE5'],
                            ],
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => '065F46'],
                            ],
                        ]);
                    }
                }
            }

            // Freeze & filter
            $sheet->freezePane('A2');
            $sheet->setAutoFilter("A1:S{$lastRow}");
        }
    ];
}

}
