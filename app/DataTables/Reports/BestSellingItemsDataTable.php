<?php

namespace App\DataTables\Reports;

use App\Models\Staff;
use Yajra\DataTables\Services\DataTable;
use App\Models\BestSellingItem;

class BestSellingItemsDataTable extends DataTable
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
       ->addIndexColumn()->editColumn('quantity', function ($data) {
            return number_format($data->quantity);
        })->editColumn('totalsales', function ($data) {
            return number_format($data->totalsales);
        })->addColumn('ratio', function ($data) {
            return number_format($data->totalsales/$data->quantity);
        })->addColumn('percent', function ($data){
            $total  = BestSellingItem::sum('totalsales');
            return  round(($data->totalsales/$total)*100, 2);
        });


    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Model\BestSellingItem $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BestSellingItem $model)
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
            'item',
            'quantity',
            'totalsales'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'BestSellingItems_' . date('YmdHis');
    }
}
