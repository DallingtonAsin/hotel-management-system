<?php

namespace App\DataTables\Kitchen;

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

                $btn = "";

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                data-id="' . $order->id . '" data-status="pending" data-original-title="Update Order Status" id="change-order-status"
                class="px-3 py-1 border border-secondary rounded text-secondary mr-2">update</a>';

                $btn .= '<a href="javascript:void(0);" id="view-kitchen-order" 
                data-toggle="tooltip" data-original-title="view order"
                data-id="' . $order->id . '" data-status="{{$status}}"
                 class="px-3 py-1 border border-secondary rounded mr-2 text-secondary">view</a>';

                // $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                // data-id="' . $order->id . '" data-status="pending" data-original-title="Edit Order" id="edit-order"
                // class="px-3 py-1 border border-secondary rounded text-secondary mr-2">
                // <span class="fa fa-clock-o pr-2"></span>Edit order</a>';

             

                // $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                //   data-id="' . $order->id . '" data-status="completed" data-original-title="Mark Completed" id="mark-completed"
                //   class="px-3 py-1 border border-success rounded edit-order mr-2">
                //   <span class="fa fa-check-circle pr-1"></span>Mark Completed</a>';

                // $btn .= '<a href="javascript:void(0);" id="mark-cancelled" 
                //         data-toggle="tooltip" data-original-title="Mark Cancelled"
                //         data-id="' . $order->id . '" data-status="cancelled"
                //          class="px-3 py-1 border border-danger rounded mr-2"">
                //         <span class="fa fa-times-circle pr-1" ></span>Mark Cancelled</a>';



                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                        data-id="' . $order->id . '" data-original-title="Kitchen Invoice" id="download-kitchen-invoice"
                        class="px-3 py-1 border border-warning rounded text-secondary edit-order ml-2">
                        <span class="fa fa-download pr-1"></span>Kitchen Invoice</a>';

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                        data-id="' . $order->id . '" data-original-title="Download Invoice" id="download-invoice"
                        class="px-3 py-1 border border-success rounded text-success edit-order ml-2">
                        <span class="fa fa-download pr-1"></span>General Invoice</a>';

                return $btn;
            })->addColumn('room_number', function ($order) {
                $room_number = null;
                if (isset($order->room_id)) {
                    $room = Helper::findRoom(($order->room_id));
                    $room_number = $room->number;
                }
                return $room_number;
            })->editColumn('order_date', function ($order) {
                return date('Y-m-d H:i A', strtotime($order->order_date));
            })->addColumn('checkbox', function ($order) {
                $checkBox = '<input type="checkbox" id="' . $order->id . '"/>';
                return $checkBox;
            })->editColumn('status', function ($order) {

                if (stripos($order->status, 'pending') !== false) {
                    $statusText = "<span class='text-warning'>" . ucwords($order->status) . "</span>";
                } else if (stripos($order->status, 'completed') !== false) {
                    $statusText = "<span class='text-success'>" . ucwords($order->status) . "</span>";
                } else if (stripos($order->status, 'cancelled') !== false) {
                    $statusText = "<span class='text-danger'>" . ucwords($order->status) . "</span>";
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
        return $model->newQuery()->select('*')->where('status', config('kitchen-order-statuses')['pending']);
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
            'id',
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
