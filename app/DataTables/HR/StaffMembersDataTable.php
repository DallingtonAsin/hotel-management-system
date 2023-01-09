<?php

namespace App\DataTables\HR;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;

class StaffMembersDataTable extends DataTable
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
            ->addColumn('action', function ($staff) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="' . $staff->id . '" data-original-title="Edit" id="edit-staff"
              class="edit-btn edit-staff pr-4">
             <span class="fa fa-pen"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-staff" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="' . $staff->id . '" class="trash-btn pr-4"">
            <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-staff" 
           data-toggle="tooltip" data-original-title="View"
            data-id="' . $staff->id . '" class="text-info bolded">
           <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->addColumn('checkbox', function ($staff) {
            $checkBox = '<input type="checkbox" id="' . $staff->id . '"/>';
            return $checkBox;
        })->addColumn('department', function ($staff) {
            return Department::where('id', $staff->department_id)->value('name');
        })->addColumn('name', function ($staff) {
            $name = $staff->first_name . ' ' . $staff->last_name;
            return $name;
        })->addColumn('designation', function ($staff) {
            return Designation::where('id', $staff->designation_id)->value('name');
        })->editColumn('is_active', function ($data) {
            return ($data->is_active)
                ? '<span class="text-success">active</span>'
                : '<span class="text-danger">inactive</span>';
        })->rawColumns(['action', 'is_active', 'checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select(
            'id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'staff_id',
            'department_id',
            'designation_id',
            'phone_number',
            'other_phone_number',
            'address',
            'nin',
            'image',
            'password'
        )->where('is_deleted', false);
            // ->where('id', '!=', Auth::user()->id);
        
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('hr/staffmembersdatatable-table')
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
            'first_name',
            'last_name',
            'name',
            'gender',
            'email',
            'staff_id',
            'department_id',
            'designation_id',
            'phone_number',
            'other_phone_number',
            'address',
            'nin',
            'image',
            'password'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'StaffMembers_' . date('YmdHis');
    }
}