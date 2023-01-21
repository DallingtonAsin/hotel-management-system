<?php

namespace App\DataTables\Kitchen;

use App\Models\KitchenOrder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class OrderHistoryDataTable extends DataTable
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
            ->addColumn('room_number', function ($order) {
                $room_number = null;
                if (isset($order->room_id)) {
                    $room = Helper::findRoom(($order->room_id));
                    $room_number = $room->number;
                }
                return $room_number;
            })->addColumn('action', function ($order) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
                        data-id="' . $order->id . '" data-original-title="Kitchen Invoice" id="download-kitchen-invoice"
                        class="px-3 py-1 border border-default rounded text-secondary edit-order ml-2">
                        <span class="fa fa-eye pr-1"></span>view order</a>';

                return $btn;
            })->editColumn('order_date', function ($order) {
                return date('Y-m-d H:i A', strtotime($order->order_date));
            })->addColumn('checkbox', function ($order) {
                $checkBox = '<input type="checkbox" id="' . $order->id . '"/>';
                return $checkBox;
            })->editColumn('status', function ($order) {

                if (stripos($order->status, 'pending') !== false) {
                    $statusText = "<span class='text-warning'>" . $order->status . "</span>";
                } else if (stripos($order->status, 'completed') !== false) {
                    $statusText = "<span class='text-success'>" . $order->status . "</span>";
                } else if (stripos($order->status, 'cancelled') !== false) {
                    $statusText = "<span class='text-danger'>" . $order->status . "</span>";
                }

                return $statusText;
            })->editColumn('created_by', function ($order) {
                return Helper::getUserNames($order->created_by);
            })->rawColumns(['checkbox', 'status', 'action']);
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
            'room_id',
            'status',
            'order_date',
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
