<?php

namespace App\DataTables\Finances;

use App\Models\Currency;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class CurrencyDataTable extends DataTable
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
            ->addColumn('action', function ($currency) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
                        data-id="' . $currency->id . '" data-original-title="Edit" id="edit-currency"
                        class="px-3 py-1 border border-success rounded  edit-currency mx-2">
                        <span class="fa fa-pen text-success"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-currency" 
                        data-toggle="tooltip" data-original-title="Delete"
                        data-id="' . $currency->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
                        <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-currency" 
                        data-toggle="tooltip" data-original-title="View"
                            data-id="' . $currency->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
                        <i class="fa fa-eye" ></i></a>';

                return $btn;

        })->editColumn('rate', function ($currency) {
            return number_format($currency->rate);
        })->addColumn('currency_code', function ($currency) {
            return '<strong>'.$currency->code.'</strong>';
        })->addColumn('checkbox', function ($currency) {
            $checkBox = '<input type="checkbox" id="' . $currency->id . '"/>';
            return $checkBox;
        })->editColumn('created_by', function ($currency) {
            return Helper::getUserNames($currency->created_by);
        })->rawColumns(['checkbox', 'currency_code', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Currency $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Currency $model)
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
            ->setTableId('hr/currency-table')
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
            'country',
            'code',
            'rate',
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
        return 'HR/Currency_' . date('YmdHis');
    }
}