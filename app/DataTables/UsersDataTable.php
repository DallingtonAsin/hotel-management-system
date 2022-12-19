<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\User;
use Helper;

class UsersDataTable extends DataTable
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
        ->addColumn('action', function ($user) {
            
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="'.$user->id.'" data-original-title="Edit" id="edit-user"
              class="edit-btn edit-user pr-4">
             <span class="fa fa-pen"></span></a>';
          
            $btn .= '<a href="javascript:void(0);" id="delete-user" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="'.$user->id.'" class="trash-btn pr-4"">
            <span class="fa fa-trash-alt" ></span></a>';

           $btn .= '<a href="javascript:void(0);" id="view-user" 
           data-toggle="tooltip" data-original-title="View"
            data-id="'.$user->id.'" class="text-info bolded">
           <i class="fa fa-eye" ></i></a>';

           return $btn;

        })->addColumn('checkbox', function ($user) {
              $checkBox = '<input type="checkbox" id="'.$user->id.'"/>';
             return $checkBox;
        })->editColumn('is_active', function ($data) {
           return ($data->is_active)
             ? '<span class="text-success">active</span>' 
             : '<span class="text-danger">inactive</span>';
        })->rawColumns(['action', 'is_active', 'checkbox']);


    }

    public function query(User $model)
    {
               return $model->newQuery()
               ->select('*');
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
            'first_name',
            'last_name',
            'name',
            'username',
            'gender',
            'email',
            'department_id',
            'tel_no',
            'alt_telno',
            'address',
            'nationalID_no',
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
        return 'Users' . date('YmdHis');
    }
}

