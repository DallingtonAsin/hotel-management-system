<?php

namespace App\DataTables\Reports;

use App\User;
use Yajra\DataTables\Services\DataTable;
use App\Models\DebtorsSupplier;

class SupplierDebtorsDataTable extends DataTable
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
         })->editColumn('debts', function ($data){
            return number_format($data->debts);
        })->addColumn('percent', function ($data){
             $total  = DebtorsSupplier::sum('debts');
             return round(($data->debts/$total)*100, 1);
         });
    }


//     <tbody>
//     @isset($debtorsSuppliers)
//     @php
//     $count = 1;
//     @endphp

//     @foreach($debtorsSuppliers as $element)
//     <tr>
//      <td>{{ $count++ }}</td>
//      <td>{{ $element->name }}</td>
//      <td>{{ $element->contact }}</td>
//      <td>{{ number_format($element->debts) }}</td>
//      <td>{{ round(($element->debts/$data['totalSupplierDebts'])*100,1) }}</td>
//    </tr>
//    @endforeach
//    @endisset
//  </tbody>

    /**
     * Get query source of dataTable.
     *
     * @param \App\Model\DebtorsSupplier $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DebtorsSupplier $model)
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
        return 'Reports\SupplierDebtors_' . date('YmdHis');
    }
}
