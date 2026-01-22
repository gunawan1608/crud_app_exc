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

class LogbookExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithTitle, WithEvents
{
    /**
     * Get data collection
     */
    public function collection()
    {
        return LogbookInsiden::orderBy('waktu_mulai', 'desc')->get();
    }

    /**
     * Header kolom Excel
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
            'SLA Per Kejadian (%)',
            'Kontribusi SLA Tahunan',
            'Target SLA (%)',
            'Status SLA',
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
            $logbook->sla ? number_format($logbook->sla, 6) : '0.000000',
            $logbook->persentase_sla_tahunan ? number_format($logbook->persentase_sla_tahunan, 6) : '0.000000',
            $logbook->target_sla ? number_format($logbook->target_sla, 2) : '98.00',
            $logbook->status_sla ?? '',
            $logbook->keterangan_sla ?? '',
            $logbook->keterangan ?? '',
            $logbook->akar_penyebab ?? '',
            $logbook->tindak_lanjut_detail ?? '',
            $logbook->direspon_oleh ?? '',
            $logbook->status_insiden ?? '',
        ];
    }

    /**
     * Lebar kolom
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
            'L' => 15,  // SLA Per Kejadian
            'M' => 18,  // Kontribusi SLA Tahunan
            'N' => 12,  // Target SLA
            'O' => 15,  // Status SLA
            'P' => 25,  // Keterangan SLA
            'Q' => 35,  // Keterangan Insiden
            'R' => 30,  // Akar Penyebab
            'S' => 30,  // Tindak Lanjut Detail
            'T' => 20,  // Direspon Oleh
            'U' => 12,  // Status Insiden
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
     * Styling Excel
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // === HEADER ===
                $sheet->getStyle('A1:U1')->applyFromArray([
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
                    $sheet->getStyle("A2:U{$lastRow}")->applyFromArray([
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
                            $sheet->getStyle("A{$i}:U{$i}")->applyFromArray([
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

                    $sheet->getStyle("J2:N{$lastRow}")
                        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                    // Highlight SLA columns
                    $sheet->getStyle("L2:L{$lastRow}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'DBEAFE'],
                        ],
                    ]);

                    $sheet->getStyle("M2:M{$lastRow}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'E0E7FF'],
                        ],
                    ]);

                    // Highlight Target SLA column
                    $sheet->getStyle("N2:N{$lastRow}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FED7AA'],
                        ],
                        'font' => [
                            'bold' => true,
                        ],
                    ]);

                    // Status SLA warna
                    for ($i = 2; $i <= $lastRow; $i++) {
                        $statusSla = $sheet->getCell("O{$i}")->getValue();

                        if ($statusSla === 'TERCAPAI') {
                            $sheet->getStyle("O{$i}")->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'D1FAE5'],
                                ],
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => '065F46'],
                                ],
                            ]);
                        } elseif ($statusSla === 'TIDAK TERCAPAI') {
                            $sheet->getStyle("O{$i}")->applyFromArray([
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

                        // Status Insiden warna
                        $status = $sheet->getCell("U{$i}")->getValue();

                        if ($status === 'Open') {
                            $sheet->getStyle("U{$i}")->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'FEE2E2'],
                                ],
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => '991B1B'],
                                ],
                            ]);
                        } elseif ($status === 'On Progress') {
                            $sheet->getStyle("U{$i}")->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'FEF3C7'],
                                ],
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => '92400E'],
                                ],
                            ]);
                        } elseif ($status === 'Closed') {
                            $sheet->getStyle("U{$i}")->applyFromArray([
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

                    // Add summary row for SLA Tahunan
                    $summaryRow = $lastRow + 2;
                    $sheet->setCellValue("K{$summaryRow}", 'SLA Tahunan:');
                    $sheet->getStyle("K{$summaryRow}")->applyFromArray([
                        'font' => ['bold' => true, 'size' => 12],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                    ]);

                    $slaTahunan = LogbookInsiden::hitungSlaTahunan();
                    $sheet->setCellValue("L{$summaryRow}", number_format($slaTahunan, 2) . '%');
                    $sheet->getStyle("L{$summaryRow}")->applyFromArray([
                        'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1E40AF']],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'DBEAFE'],
                        ],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_MEDIUM,
                                'color' => ['rgb' => '1E40AF'],
                            ],
                        ],
                    ]);
                }

                // Freeze & filter
                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:U{$lastRow}");
            }
        ];
    }
}
