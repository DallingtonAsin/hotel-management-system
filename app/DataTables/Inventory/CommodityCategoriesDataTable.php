<?php

namespace App\DataTables\Inventory;

use App\Helpers\Helper;
use App\Models\CommodityCategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class CommodityCategoriesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_by', function($data){
              return Helper::getUserNames($data->created_by);
            })->addColumn('action', 'inventory/commoditycategoriesdatatable.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CommodityCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CommodityCategory $model)
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
                    ->setTableId('inventory/commoditycategoriesdatatable-table')
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
            'code',
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
        return 'CommodityCategories_' . date('YmdHis');
    }
}
