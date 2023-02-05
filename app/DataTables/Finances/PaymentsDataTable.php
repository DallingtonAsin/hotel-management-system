<?php

namespace App\DataTables\Finances;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Models\Guest;
use App\Models\Payment;
use App\Helpers\Helper;

class PaymentsDataTable extends DataTable
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
            ->addColumn('action', function ($payment) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
        data-id="' . $payment->id . '" data-original-title="Edit" id="edit-payment"
          class="px-3 py-1 border border-success rounded  edit-payment mx-2">
         <span class="fa fa-pencil text-success"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-payment" 
        data-toggle="tooltip" data-original-title="Delete"
         data-id="' . $payment->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
        <span class="fa fa-trash" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-payment" 
       data-toggle="tooltip" data-original-title="View"
        data-id="' . $payment->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
       <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->addColumn('checkbox', function ($payment) {
            $checkBox = '<input type="checkbox" id="' . $payment->id . '"/>';
            return $checkBox;
        })->addColumn('guest_name', function ($payment) {
            $guest = Guest::find($payment->guest_id);
            return $guest->first_name . ' ' . $guest->last_name;
        })->editColumn('created_by', function ($payment) {
            return Helper::getUserNames($payment->created_by);
        })->editColumn('amount', function ($payment) {
            return number_format($payment->amount);
        })->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Payment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Payment $model)
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
            ->setTableId('finances/paymentsdatatable-table')
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
            'guest_id',
            'invoice_number',
            'amount',
            'method',
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
        return 'Payments_' . date('YmdHis');
    }
}