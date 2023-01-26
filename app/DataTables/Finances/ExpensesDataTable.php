<?php

namespace App\DataTables\Finances;

use Yajra\DataTables\Services\DataTable;
use App\Models\Expense;
use App\Models\ExpenseType;

class ExpensesDataTable extends DataTable
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
        ->order(function($query){
               $query->orderBy('date_of_expenditure', 'desc');
        })->addIndexColumn()
        ->addColumn('action', function ($expense) {
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="'.$expense->id.'" data-original-title="Edit" id="edit-expense"
              class="px-3 py-1 border border-success rounded  edit-expense mx-2">
             <span class="fa fa-pen text-success pr-1"></span></a>';
          
            $btn .= '<a href="javascript:void(0);" id="delete-expense" 
            data-toggle="tooltip" data-original-title="Delete" data-id="'.$expense->id.'"
             class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
            <span class="fa fa-trash-alt pr-1" ></span></a>';

           $btn .= '<a href="javascript:void(0);" id="view-expense" 
           data-toggle="tooltip" data-original-title="View" data-id="'.$expense->id.'" 
           class="px-3 py-1 border border-secondary rounded text-secondary bolded">
           <i class="fa fa-eye pr-1" ></i></a>';

           return $btn;

        })->editColumn('is_deleted', function ($data) {
            return $data->is_deleted ? '<span class="text-danger">Yes</span>' : '<span class="text-dark">No</span>'; 
        })->addColumn('expense_type', function ($expense) {
             $expense_type = ExpenseType::where('id', $expense->type_id)->first()->name;
             return $expense_type;
        })->addColumn('checkbox', function ($expense) {
            $checkBox = '<input type="checkbox" id="'.$expense->id.'"/>';
           return $checkBox;
      })->editColumn('amount', function ($data) {
            return number_format($data->amount);
        })->rawColumns(['action', 'is_deleted', 'checkbox']);
    }

 
    public function query(Expense $model)
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
        ->dom('Bfrtip')
        ->orderBy(1)->parameters($this->getBuilderParameters());

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
            'type_id',
            'amount',
            'date_of_expenditure'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Expenses_' . date('YmdHis');
    }
}
