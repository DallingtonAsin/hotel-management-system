<?php

namespace App\DataTables\HR;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Models\StaffPermission;
use App\Models\Permission;
use App\Staff;


class StaffPermissionsDataTable extends DataTable
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
       ->addColumn('is_active', function ($permission) {
                 return $permission->active 
                 ? '<strong class="text-success">Yes</strong>' 
                 : '<strong class="text-danger">No</strong>';
        })->addColumn('permission_name', function ($permission) {
            $permission = Permission::find($permission->permission_id);
            return ucfirst(str_replace("_", " ", $permission->name));
         })->addColumn('staff_name', function ($permission) {
              $staff = Staff::find($permission->staff_id);
              return $staff->first_name. ' '. $staff->last_name;
            })->rawColumns(['is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\StaffPermission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StaffPermission $model)
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
                    ->setTableId('hr/staffpermissionsdatatable-table')
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
            'permission_id',
            'staff_id',
            'active',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'StaffPermissions_' . date('YmdHis');
    }
}
