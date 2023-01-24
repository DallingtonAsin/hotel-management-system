<?php

namespace App\DataTables\Inventory;

use App\Models\Good;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;


class GoodsDataTable extends DataTable
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
            ->addColumn('action', function ($good) {

                $btn = "";

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"
            data-id="' . $good->id . '" data-original-title="Edit" id="increase-good"
            class="px-3 py-1 border border-success rounded  increase-good mx-2">
             <small class="fa fa-plus-circle text-success pr-1"></small> good</a>';

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"
             data-id="' . $good->id . '" data-original-title="Edit" id="decrease-good"
             class="px-3 py-1 border border-success rounded  decrease-good mx-2">
              <small class="fa fa-minus-circle text-success pr-1"></small> good</a>';


                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"
              data-id="' . $good->id . '" data-original-title="Edit" id="edit-good"
              class="px-3 py-1 border border-secondary rounded  edit-good mx-2">edit good</a>';


                $btn .= '<a href="javascript:void(0);" id="view-good"
                         data-toggle="tooltip" data-original-title="View"
                         data-id="' . $good->id . '" class="px-3 py-1 border border-secondary rounded text-secondary">view details</a>';


                return $btn;
            })->editColumn('created_by', function($data){
                return Helper::getUserNames($data->created_by);
              })->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Good $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Good $model)
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
            ->setTableId('goodsdatatable-table')
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
            'goods_name',
            'goods_code',
            'measure_unit',
            'unit_price',
            'currency_code',
            'commodity_category_id',
            'have_excise_tax',
            'description',
            'stock_prewarning',
            'price_measure_unit',
            'have_piece_unit',
            'piece_unit_price',
            'package_scaled_value',
            'piece_scaled_value',
            'excise_duty_code',
            'have_other_unit',
            'goods_type_code',
            'goods_other_units',
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
        return 'Goods_' . date('YmdHis');
    }
}
