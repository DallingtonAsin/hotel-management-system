<?php

namespace App\DataTables\pos;

use App\Models\KitchenOrder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class KitchenOrdersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->order(function ($query) {
                $query->orderBy('created_at', 'desc');
            })->addIndexColumn()
            ->addColumn('action', function ($order) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
        data-id="' . $order->id . '" data-original-title="Edit" id="edit-order"
          class="edit-btn edit-order pr-4">
         <span class="fa fa-pen"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-order" 
        data-toggle="tooltip" data-original-title="Delete"
         data-id="' . $order->id . '" class="trash-btn pr-4"">
        <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-order" 
       data-toggle="tooltip" data-original-title="View"
        data-id="' . $order->id . '" class="text-info bolded">
       <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->addColumn('checkbox', function ($order) {
            $checkBox = '<input type="checkbox" id="' . $order->id . '"/>';
            return $checkBox;
        })->editColumn('created_by', function ($order) {
            return Helper::getUserNames($order->created_by);
        })->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\KitchenOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(KitchenOrder $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('pos/kitchenordersdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'order_number',
            'table_number',
            'item',
            'quantity',
            'status',
            'created_by'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'KitchenOrders_' . date('YmdHis');
    }
}