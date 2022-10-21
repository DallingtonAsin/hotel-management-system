<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use App\Models\Sales;
//use Maatwebsite\Excel\Concerns\FromCollection;

class ExportSales implements FromQuery, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    public function query()
    {
        return Sales::query()->select('bill_no', 'item', 'quantity', 'selling_price', 
                                     'total_cost', 'discount','amount', 'customer',
                                      'date_of_sale','cashier')->where('bill_no','>', 0)
                                      ->orderBy('sales.bill_no')
                                     ;
    }


    public function headings():array{
        return[
            'No',
            'Item',
            'Quantity',
            'SellingPrice',
            'TotalCost',
            'Discount',
            'Amount',
            'Customer',
            'Date',
            'Cashier'
            
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
