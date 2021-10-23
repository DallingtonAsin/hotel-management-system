<?php

namespace App\DataTables\Reports;

use App\User;
use Yajra\DataTables\Services\DataTable;
use App\Models\MonthlySale;

class MonthlySalesDataTable extends DataTable
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
        ->addIndexColumn()->order(function($query){
               $query->orderBy('month_int', 'asc');
        })->addColumn('period', function ($data){
            $month = date("F", mktime(0, 0, 0, $data->month_int, 10)); 
            return $month ." ".$data->SalesYear;
        })->editColumn('month', function ($data){
            $month = date("F", mktime(0, 0, 0, $data->month_int, 10)); 
            return $month;
        })->editColumn('year', function ($data){
            return $data->SalesYear;
        })->addColumn('sales', function ($data){
            return number_format($data->TotalSales);
        })->addColumn('percent', function ($data){
             $total  = MonthlySale::sum('TotalSales');
             return round(($data->TotalSales/$total)*100, 2);
         });
    }



    /**
     * Get query source of dataTable.
     *
     * @param \App\Model\MonthlySale $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MonthlySale $model)
    {
        return $model->newQuery()->select('*')->where("SalesYear", Date('Y'));;
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
        return 'Reports\MonthlySales_' . date('YmdHis');
    }
}
