<?php

namespace App\DataTables\Inventory;

use Yajra\DataTables\Services\DataTable;
use App\Models\Purchase;

class PurchasesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->order(function($query){
               $query->orderBy('id', 'asc');
        })->addIndexColumn()
        ->addColumn('action', function ($purchase) {
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"
            data-id="'.$purchase->id.'" data-original-title="Edit" id="edit-purchase"
              class="px-3 py-1 border border-success rounded  edit-purchase mx-2">
             <span class="fa fa-pen text-success"></span></a>';

            // $btn .= '<a href="javascript:void(0);" id="delete-purchase"
            // data-toggle="tooltip" data-original-title="Delete" data-id="'.$purchase->id.'"
            //  class="trash-btn pr-4"">
            // <span class="fa fa-trash-alt" ></span></a>';

           $btn .= '<a href="javascript:void(0);" id="view-purchase"
           data-toggle="tooltip" data-original-title="View" data-id="'.$purchase->id.'" 
           class="px-3 py-1 border border-seondary rounded text-secondary bolded">
           <i class="fa fa-eye" ></i></a>';

           return $btn;

        })->addColumn('checkbox', function ($purchase) {
              $checkBox = '<input type="checkbox" id="'.$purchase->id.'"/>';
             return $checkBox;
        })->editColumn('quantity', function ($data) {
            return number_format($data->quantity);
        })->editColumn('cost_price_per_item', function ($data) {
            return number_format($data->cost_price_per_item);
        })->editColumn('total_cost_price', function ($data) {
            return number_format($data->total_cost_price);
        })->editColumn('date', function ($data) {
            return date('d-m-Y H:i', strtotime($data->date));
        })->rawColumns(['action', 'checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Staff $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Purchase $model)
    {
        return $model->newQuery()->select('*');
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
            'item_code',
            'item',
            'quantity',
            'cost_price_per_item',
            'total_cost_price',
            'supplier',
            'created_by',
            'date'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Purchases_' . date('YmdHis');
    }
}
