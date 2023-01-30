<?php

namespace App\DataTables\Inventory;

use App\Models\Good;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;
use App\Repositories\CurrencyRepository;


class GoodsDataTable extends DataTable
{

    protected $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
      $this->currencyRepository =  $currencyRepository;
    }
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
              data-id="' . $good->id . '" data-original-title="Edit" id="edit-good"
              class="px-3 py-1 border border-success rounded edit-good mx-2 text-success">edit good</a>';


                $btn .= '<a href="javascript:void(0);" id="view-good"
                         data-toggle="tooltip" data-original-title="View"
                         data-id="' . $good->id . '" class="px-3 py-1 border border-secondary rounded text-secondary">view details</a>';


                return $btn;
            })->addColumn('currency_code', function($data){
                $currency = $this->currencyRepository->get($data->currency_id);
                return $currency->code;
            })->editColumn('created_by', function($data){
                return Helper::getUserNames($data->created_by);
              })->editColumn('unit_price', function($data){
                return number_format($data->unit_price);
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
            'currency_id',
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
