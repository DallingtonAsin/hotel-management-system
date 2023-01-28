<?php

namespace App\DataTables\Finances;

use App\Models\PaymentCategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class PaymentCategoriesDataTable extends DataTable
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
            })->addIndexColumn()
            ->addColumn('action', function ($category) {

                $btn = "";

                $btn .= '<a href="javascript:void(0);" id="view-payment-category" 
                    data-toggle="tooltip" data-original-title="edit details"
                    data-id="' . $category->id . '" data-status="{{$status}}"
                     class="px-3 py-1 border border-primary rounded mr-2 text-primary"><i class="fa fa-pen"></i></a>';


                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                     data-id="' . $category->id . '" data-original-title="View Payment Category" id="view-payment-category"
                     class="px-3 py-1 border border-secondary rounded text-secondary ml-2"><i class="fa fa-eye"></i></a>';

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                     data-id="' . $category->id . '" data-original-title="Delete Payment Category" id="delete-payment-category"
                     class="px-3 py-1 border border-danger rounded text-danger ml-2"><i class="fa fa-trash-alt"></i></a>';

                return $btn;
            })->editColumn('is_deleted', function ($data) {
                return $data->is_deleted ? '<span class="text-danger">Yes</span>' : '<span class="text-dark">No</span>';
            })->editColumn('created_by', function ($data) {
                return Helper::getUserNames($data->created_by);
            })->rawColumns(['action', 'is_deleted']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PaymentCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PaymentCategory $model)
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
            ->setTableId('finances/paymentcategoriesdatatable-table')
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
            'name',
            'transaction_type',
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
        return 'Finances/PaymentCategories_' . date('YmdHis');
    }
}
