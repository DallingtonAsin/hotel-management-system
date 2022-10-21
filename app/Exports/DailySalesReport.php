<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use App\Models\Sale;

class DailySalesReport implements FromQuery, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    public function query()
    {
        return Sale::query()->select('item_id', 'item', 'quantity', 'original_price',
                                      'selling_price','total_cost', 'discount', 'amount',
                                       'customer', 'date', 'time', 'cashier')
                                       ->where('date', date('Y-m-d'))
                                       ->orderBy('sales.date');
    }


    public function headings():array{
        return[
            'item_id',
            'item',
            'quantity',
            'original_price',
            'selling_price',
            'total_cost',
            'discount',
            'amount',
            'customer',
            'date',
            'time', 
            'cashier'
            
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
