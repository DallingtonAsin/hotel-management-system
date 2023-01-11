<?php

namespace App\DataTables\HR;

use App\Models\Designation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Models\Department;
use App\Helpers\Helper;

class DesignationsDataTable extends DataTable
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
            ->addColumn('action', function ($designation) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="' . $designation->id . '" data-original-title="Edit" id="edit-designation"
              class="edit-btn edit-designation pr-4">
             <span class="fa fa-pen"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-designation" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="' . $designation->id . '" class="trash-btn pr-4"">
            <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-designation" 
           data-toggle="tooltip" data-original-title="View"
            data-id="' . $designation->id . '" class="text-info bolded">
           <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->addColumn('checkbox', function ($designation) {
            $checkBox = '<input type="checkbox" id="' . $designation->id . '"/>';
            return $checkBox;
        })->addColumn('department', function ($designation) {
            $department = Department::where('id', $designation->department_id)->value('name');
            return $department;
        })->editColumn('created_by', function ($designation) {
                return Helper::getUserNames($designation->created_by);
        })->rawColumns(['checkbox', 'department', 'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Designation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Designation $model)
    {
        return $model->newQuery()->select(
            'id',
            'name',
            'department_id',
            'created_by'
        );
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('hr/designationsdatatable-table')
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
        return 'Designations_' . date('YmdHis');
    }
}