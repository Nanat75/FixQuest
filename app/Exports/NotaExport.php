<?php

namespace App\Exports;

use App\Models\Nota;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NotaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $notas;

    public function __construct($notas)
    {
        $this->notas = $notas;
    }

    public function collection(): Collection
    {
        return $this->notas->map(function (Nota $nota, int $index): array {
            return [
                'No'             => $index + 1,
                'Tanggal Masuk'  => $nota->tanggal_masuk,
                'Kode Unit'      => $nota->kode_unit,
                'Nama Driver'    => $nota->nama_driver,
                'Kerusakan'      => $nota->kerusakan,
                'Status'         => $nota->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Masuk',
            'Kode Unit',
            'Nama Driver',
            'Kerusakan',
            'Status',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $headerRange = 'A1:F1';
                $lastRow = $sheet->getHighestRow();
                $dataRange = 'A2:F' . $lastRow;

                // Header style
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F2F2F2'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'CCCCCC'],
                        ],
                    ],
                ]);

                // Body content styling
                $sheet->getStyle($dataRange)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                for ($row = 2; $row <= $lastRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(22);
                }
            },
        ];
    }
}
