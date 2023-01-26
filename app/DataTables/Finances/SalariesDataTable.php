<?php

namespace App\DataTables\Finances;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;
use App\Models\Salary;
use App\Models\Staff;

class SalariesDataTable extends DataTable
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
            ->addColumn('action', function ($salary) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
        data-id="' . $salary->id . '" data-original-title="Edit" id="edit-salary"
          class="px-3 py-1 border border-success rounded  edit-salary mx-2">
         <span class="fa fa-pen text-success"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-salary" 
        data-toggle="tooltip" data-original-title="Delete"
         data-id="' . $salary->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
        <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-salary" 
       data-toggle="tooltip" data-original-title="View"
        data-id="' . $salary->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
       <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->addColumn('checkbox', function ($salary) {
            $checkBox = '<input type="checkbox" id="' . $salary->id . '"/>';
            return $checkBox;
        })->addColumn('employee_name', function ($salary) {
            $user = Staff::find($salary->employee_id);
            return $user->first_name . ' ' . $user->last_name;
        })->editColumn('amount', function ($salary) {
            return number_format($salary->amount);
        })->editColumn('created_by', function ($salary) {
            return Helper::getUserNames($salary->created_by);
        })->rawColumns(['checkbox', 'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Salary $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Salary $model)
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
            ->setTableId('finances/salariesdatatable-table')
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
            'employee_id',
            'amount',
            'pay_date'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Salaries_' . date('YmdHis');
    }
}