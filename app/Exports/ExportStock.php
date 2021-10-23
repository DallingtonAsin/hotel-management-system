<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use App\Models\Stock;

class ExportStock implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Stock::all();
    }

    public function headings():array{
        return[
            'id',
            'itemID',
            'Item',
            'Category',
            'Quantity',
            'Quantity Last Added',
            'Buying Price',
            'Selling Price',
            'Profit per Item',
            'Total CostPrice',
            'Total Profit',
            'Supplier',
            'Date of Entry',
            'Expiry Date'
            
        ];
    }


    public function registerEvents():array{
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->getColor('red');
            
            }

        ];
    }








}
