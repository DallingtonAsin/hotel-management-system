<?php

namespace App\DataTables\Finances;

use App\Models\StaffPayment;
use App\Models\Staff;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;
use App\Models\PaymentCategory;

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
            ->order(function($query){
                $query->orderBy('id', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('action', function ($payment) {

                $btn = "";

                $btn .= '<a href="javascript:void(0);" id="edit-staff-payment" data-toggle="tooltip" data-original-title="edit details" data-id="' . $payment->id . '" 
                class="px-3 py-1 border border-secondary rounded mr-2 text-secondary">edit</a>';

                $btn .= '<a href="javascript:void(0);" id="view-staff-payment" 
                         data-toggle="tooltip" data-original-title="view details" data-id="' . $payment->id . '"
                         class="px-3 py-1 border border-secondary rounded mr-2 text-secondary">view</a>';

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $payment->id . '" data-original-title="Delete payment" id="delete-staff-payment"
                         class="px-3 py-1 border border-danger rounded text-danger ml-2">delete</a>';

                return $btn;
            })->addColumn('employee_name', function($data){
                $staff = Staff::find($data->staff_id);
                return $staff->first_name . ' '. $staff->last_name;
            })->addColumn('employee_id', function($data){
                $staff = Staff::find($data->staff_id);
                return $staff->staff_id;
            })->addColumn('payment_category', function($data){
                $payment_category = PaymentCategory::find($data->payment_category_id);
                return $payment_category->name;
            })->addColumn('payment_slip', function($data){
                $btn = '<a href="javascript:void(0);" id="download-payment-slip" 
                         data-toggle="tooltip" data-original-title="payment slip"
                         data-id="' . $data->id . '" class="px-3 py-1 border border-primary rounded mr-2 text-primary">Payment Slip</a>';
                 return $btn;
            })->editColumn('amount', function ($data) {
                return number_format($data->amount); 
            })->editColumn('is_deleted', function ($data) {
                return $data->is_deleted ? '<span class="text-danger">Yes</span>' : '<span class="text-dark">No</span>'; 
            })->editColumn('created_by', function($data){
                return Helper::getUserNames($data->created_by);
            })->rawColumns(['action', 'payment_slip', 'is_deleted']);
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
            'payment_category_id',
            'amount',
            'payment_date',
            'is_deleted',
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
