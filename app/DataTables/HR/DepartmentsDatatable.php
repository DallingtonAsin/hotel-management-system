<?php

namespace App\DataTables\HR;

use App\Models\Department;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class DepartmentsDatatable extends DataTable
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
               $query->orderBy('created_at', 'desc');
        })->addIndexColumn()
        ->addColumn('action', function ($department) {
            
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="'.$department->id.'" data-original-title="Edit" id="edit-department"
              class="edit-btn edit-department pr-4">
             <span class="fa fa-pen"></span></a>';
          
            $btn .= '<a href="javascript:void(0);" id="delete-department" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="'.$department->id.'" class="trash-btn pr-4"">
            <span class="fa fa-trash-alt" ></span></a>';

           $btn .= '<a href="javascript:void(0);" id="view-department" 
           data-toggle="tooltip" data-original-title="View"
            data-id="'.$department->id.'" class="text-info bolded">
           <i class="fa fa-eye" ></i></a>';

           return $btn;

        })->addColumn('checkbox', function ($department) {
              $checkBox = '<input type="checkbox" id="'.$department->id.'"/>';
             return $checkBox;
        })->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Department $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Department $model)
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
                    ->setTableId('hr/departmentsdatatable-table')
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
        return 'HR/Departments_' . date('YmdHis');
    }
}
