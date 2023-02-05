<?php

namespace App\DataTables\User;

use Yajra\DataTables\Services\DataTable;
use App\Models\Supplier;

class SuppliersDataTable extends DataTable
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
        ->addColumn('action', function ($supplier) {
            
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="'.$supplier->id.'" data-original-title="Edit" id="edit-supplier"
              class="px-3 py-1 border border-success rounded  edit-supplier mx-2">
             <span class="fa fa-pencil text-success"></span></a>';
          
            $btn .= '<a href="javascript:void(0);" id="delete-supplier" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="'.$supplier->id.'" class="px-3 py-1 border border-danger rounded trash-btn mx-2">
            <span class="fa fa-trash" ></span></a>';

           $btn .= '<a href="javascript:void(0);" id="view-supplier" 
           data-toggle="tooltip" data-original-title="View"
            data-id="'.$supplier->id.'" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
           <i class="fa fa-eye" ></i></a>';

           return $btn;

        })->addColumn('checkbox', function ($supplier) {
              $checkBox = '<input type="checkbox" id="'.$supplier->id.'"/>';
             return $checkBox;
        })->editColumn('credit', function ($data) {
            return number_format($data->credit);
        })->editColumn('debt', function ($data) {
            return number_format($data->debt);
        })->rawColumns(['action', 'checkbox']);


    }

    public function query(Supplier $model)
    {
               return $model->newQuery()->select('id', 'name', 'phone_number', 'tin', 'address','email','credit','debt');
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
            'name',
            'tin',
            'phone_number',
            'address',
            'email',
            'credit',
            'debt',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Suppliers_' . date('YmdHis');
    }
}
