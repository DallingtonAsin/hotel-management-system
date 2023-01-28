<?php

namespace App\DataTables\Finances;

use App\Models\StaffPayment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class StaffPaymentsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($payment) {

                $btn = "";

                $btn .= '<a href="javascript:void(0);" id="view-payment" 
            data-toggle="tooltip" data-original-title="view details"
            data-id="' . $payment->id . '" data-status="{{$status}}"
             class="px-3 py-1 border border-primary rounded mr-2 text-primary">view details</a>';

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
             data-id="' . $payment->id . '" data-original-title="Download Invoice" id="edit-payment"
             class="px-3 py-1 border border-secondary rounded text-secondary ml-2">
             invoice</a>';

                return $btn;
            })->editColumn('is_deleted', function ($data) {
                return $data->is_deleted ? '<span class="text-danger">Yes</span>' : '<span class="text-dark">No</span>'; 
            })->editColumn('created_by', function($data){
                return Helper::getUserNames($data->created_by);
            })->rawColumns(['action', 'is_deleted']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\StaffPayment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StaffPayment $model)
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
                    ->setTableId('finances/staffpaymentsdatatable-table')
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
            'staff_id',
            'payment_payment_id',
            'amount',
            'payment_date',
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
        return 'Finances/StaffPayments_' . date('YmdHis');
    }
}
