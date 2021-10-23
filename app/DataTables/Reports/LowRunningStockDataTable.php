<?php

namespace App\DataTables\Reports;

use Yajra\DataTables\Services\DataTable;
use App\Models\Stock;

class LowRunningStockDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
      
        return datatables($query)->addIndexColumn()
        ->filter(function ($query){
           $query->whereColumn('quantity', '<=', 'threshold_qty');
        })->editColumn('quantity', function ($data) {
            return number_format($data->quantity);
        })->editColumn('threshold_qty', function ($data) {
            return number_format($data->threshold_qty);
        })->editColumn('buying_price', function ($data) {
            return number_format($data->buying_price);
        })->editColumn('selling_price', function ($data) {
            return number_format($data->selling_price);
        })->rawColumns(['action', 'checkbox']);
    }

    
    public function query(Stock $model)
    {
       
        return $model->newQuery()->select(
            'id',
            'item_id',
            'item',
            'quantity',
            'threshold_qty',
            'buying_price',
            'selling_price',
            'supplier'
        );

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'stock_id',
            'stock',
            'quantity',
            'threshold_qty',
            'buying_price',
            'selling_price',
            'supplier'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'LowRunningStock_' . date('YmdHis');
    }
}
