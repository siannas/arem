<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use \Maatwebsite\Excel\Writer;

class Template implements FromCollection, WithHeadings, WithEvents
{
    use Exportable, RegistersEventListeners;

    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'nik',
            'nama',
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $event->sheet->styleCells(
            'A1:B1',
            [
                'font'    => array(
                    'name'      => 'Arial',
                    'bold'      => true,
                    'italic'    => false,
                    'strike'    => false,
                ),
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ]
            ]
        );

        $event->sheet->styleColumnDimension('A',35);
        $event->sheet->styleColumnDimension('B',35);
    }
}