<?php

namespace App\DataTables\Inventory;

use Yajra\DataTables\Services\DataTable;
use App\Models\Damage;
use App\Models\Stock;
use App\Repositories\StockRepository;

class DamagesDataTable extends DataTable
{

    protected $stockRepository;
    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
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
            })->addIndexColumn()
            ->addColumn('action', function ($damage) {
                $btn = "";

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"
            data-id="' . $damage->id . '" data-original-title="Edit" id="edit-damage"
              class="px-3 py-1 border border-success rounded  edit-damage mx-2">
             <span class="fa fa-pencil text-success"></span></a>';


                // $btn .= '<a href="javascript:void(0);" id="delete-damage"
                // data-toggle="tooltip" data-original-title="Delete" data-id="'.$damage->id.'" 
                // class="trash-btn pr-4">
                // <span class="fa fa-trash" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-damage"
            data-toggle="tooltip" data-original-title="View" data-id="' . $damage->id . '"
             class="px-3 py-1 border border-secondary rounded text-secondary bolded">
            <i class="fa fa-eye" ></i></a>';

                return $btn;
            })->addColumn('checkbox', function ($damage) {
                $checkBox = '<input type="checkbox" id="' . $damage->id . '"/>';
                return $checkBox;
            })->addColumn('item_code', function ($data) {

                $item = $this->stockRepository->get($data->item_id);
                if($item){
                    return $item->item_code;
                }
                return 'Test item '.$data->item_id;

            })->addColumn('item_name', function ($data) {
                $item = $this->stockRepository->get($data->item_id);
                if($item){
                    return $item->item_name;
                }
                return 'Test item '.$data->item_id;

            })->addColumn('buying_price', function ($data) {
                $item = Stock::where('id', $data->item_id)->first();
                if($item){
                    number_format($item->buying_price);
                }
                return 0;
            })->addColumn('total_cost', function ($data) {
                $item = Stock::where('id', $data->item_id)->first();
                if($item){
                    return number_format($data->quantity * $item->buying_price);
                }
                return 0;
            })->editColumn('quantity', function ($data) {
                return number_format($data->quantity);
            })->editColumn('recorded_on', function ($data) {
                return date('d/m/Y H:i', strtotime($data->recorded_on));
            })->rawColumns(['action', 'checkbox']);
    }


    public function query(Damage $model)
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
            'item_id',
            'quantity',
            'recorded_on',
            'recorded_by',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Damages_' . date('YmdHis');
    }
}
