<?php

namespace App\DataTables\Reports;

use App\User;
use Yajra\DataTables\Services\DataTable;
use App\Models\TopCustomer;

class TopCustomersDataTable extends DataTable
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
        ->addIndexColumn()->addColumn('volumeofsales', function ($data) {
             return number_format($data->volumeofsales);
         })->addColumn('percent', function ($data){
             $total  = TopCustomer::sum('volumeofsales');
             return round(($data->volumeofsales*100)/$total, 2);
         });
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TopCustomer $model)
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
        return [];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TopCustomers_' . date('YmdHis');
    }
}
