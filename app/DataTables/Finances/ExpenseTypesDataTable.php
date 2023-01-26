<?php

namespace App\DataTables\Finances;

use App\Helpers\Helper;
use App\Models\ExpenseType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class ExpenseTypesDataTable extends DataTable
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
            ->addColumn('action', function ($data) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
                data-id="'.$data->id.'" data-original-title="Edit" id="edit-expense-type"
                  class="px-3 py-1 border border-success rounded  edit-expense mx-2">
                 <span class="fa fa-pen text-success pr-1"></span></a>';
              
                $btn .= '<a href="javascript:void(0);" id="delete-expense-type" 
                data-toggle="tooltip" data-original-title="Delete" data-id="'.$data->id.'"
                 class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
                <span class="fa fa-trash-alt pr-1" ></span></a>';
    
               $btn .= '<a href="javascript:void(0);" id="view-expense-type" 
               data-toggle="tooltip" data-original-title="View" data-id="'.$data->id.'" 
               class="px-3 py-1 border border-secondary rounded text-secondary bolded">
               <i class="fa fa-eye pr-1" ></i></a>';
    
               return $btn;
    
            })->editColumn('created_by', function($data){
                return Helper::getUserNames($data->created_by);
            }) ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ExpenseType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ExpenseType $model)
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
                    ->setTableId('finances/expensetypes-table')
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
            'name',
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
        return 'ExpenseTypes_' . date('YmdHis');
    }
}
