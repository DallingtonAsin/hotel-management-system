<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Gate;
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
        ->addIndexColumn()
        ->addColumn('action', function ($pdt_category) {


            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"
            data-id="'.$pdt_category->id.'" data-original-title="Edit" id="edit-pdt-category"
            class="edit-btn edit-stock pr-4">
             <span class=" fa fa-pen"></span></a>';

            $btn .= '<a href="javascript:void(0);" id="view-pdt-category"
            data-toggle="tooltip" data-original-title="View"
             data-id="'.$pdt_category->id.'" class="text-info bolded pr-4">
            <i class="fa fa-eye" ></i></a>';

            $btn .= '<a href="javascript:void(0);" id="delete-pdt-category"
            data-toggle="tooltip" data-original-title="Delete" data-id="'.$pdt_category->id.'" class="trash-btn pl-3"">
            <span class="fa fa-trash-alt" ></span></a>';

           return $btn;

        })->addColumn('checkbox', function ($stockcat) {
              $checkBox = '<input type="checkbox" id="'.$stockcat->id.'"/>';
             return $checkBox;
        })->rawColumns(['action', 'checkbox']);

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
            'id',
            'item_category',
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
