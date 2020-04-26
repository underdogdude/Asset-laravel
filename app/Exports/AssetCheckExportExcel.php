<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;

class AssetCheckExportExcel implements FromArray, ShouldAutoSize, WithEvents
{
   
    protected $export;

    public function __construct(array $export)
    {
        $this->export = $export;
    }

    public function array(): array
    {
        return $this->export;
    }

    public function registerEvents(): array
    {
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:Q1');
                $event->sheet->getDelegate()->mergeCells('A2:Q2');
                $event->sheet->getDelegate()->mergeCells('A3:Q3');
                $event->sheet->getDelegate()->mergeCells('L4:O4');
                
                $text_header = array(
                    'font' => array(
                        'name' => 'Angsana New',
                        'size' => 15,
                        'bold' => true
                    ),
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                );
                $text_sub_header = array(
                    'font' => array(
                        'name' => 'Angsana New',
                        'size' => 13,
                        'bold' => true
                    ),
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                );


                $cellRange = 'A1:Q1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($text_header);
                $cellRange = 'A2:Q2'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($text_header);
                $cellRange = 'A3:Q3'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($text_header);

                $cellRange = 'A4:Q7'; // All Sub Headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($text_sub_header);

                # Styles Here
                $event->sheet->getParent()->getDefaultStyle()->applyFromArray([
                    'font' => [
                        'name' => 'Angsana New',
                        'size' => 10
                    ]
                ]);

                $border = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                // Border
                $event->sheet->getStyle('A4:Q8')->applyFromArray($border);
                $event->sheet->getStyle('L4:O4')->applyFromArray($border);
                $border = [
                    'borders' => [
                        'vertical' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getStyle('A4:Q8')->applyFromArray($border);

                $border = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getStyle('A9:Q'.$event->sheet->getHighestRow())->applyFromArray($border);
            }
        ];
    }
}
