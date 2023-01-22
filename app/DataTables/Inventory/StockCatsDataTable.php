<?php

namespace App\DataTables\Inventory;

use App\Helpers\Helper;
use Yajra\DataTables\Services\DataTable;
use App\Models\StockCat;

class StockCatsDataTable extends DataTable
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
            $query->orderBy('id', 'desc');
        })
        ->addIndexColumn()
        ->addColumn('action', function ($data) {


            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"
            data-id="'.$data->id.'" data-original-title="Edit" id="edit-pdt-category"
            class="px-3 py-1 border border-success rounded  edit-stock mx-2">
             <span class=" fa fa-pen text-success"></span></a>';

            $btn .= '<a href="javascript:void(0);" id="delete-pdt-category"
            data-toggle="tooltip" data-original-title="Delete" data-id="'.$data->id.'" class="px-3 py-1 border border-danger rounded trash-btn pl-3"">
            <span class="fa fa-trash-alt" ></span></a>';

            $btn .= '<a href="javascript:void(0);" id="view-pdt-category"
            data-toggle="tooltip" data-original-title="View"
             data-id="'.$data->id.'" class="px-3 py-1 border border-secondary rounded text-secondary bolded mx-2">
            <i class="fa fa-eye" ></i></a>';

           return $btn;

        })->editColumn('is_deleted', function ($data) {
            return $data->is_deleted ? '<span class="text-danger">Yes</span>' : '<span class="text-dark">No</span>'; 
        })->editColumn('created_by', function ($data) {
            return Helper::getUserNames($data->created_by);
        })->addColumn('checkbox', function ($data) {
            $checkBox = '<input type="checkbox" id="'.$data->id.'"/>';
           return $checkBox;
      })->rawColumns(['action', 'is_deleted', 'checkbox']);

    }


    public function query(StockCat $model)
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
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name',
            'created_by',
            'is_deleted'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'StockCats_' . date('YmdHis');
    }
}
