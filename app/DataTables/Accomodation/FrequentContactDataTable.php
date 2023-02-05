<?php

namespace App\DataTables\Accomodation;

use App\Models\FrequentContact;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class FrequentContactDataTable extends DataTable
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
            $query->orderBy('created_at', 'desc');
        })->addIndexColumn()
        ->addColumn('action', function ($freqContact) {

            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
                    data-id="' . $freqContact->id . '" data-original-title="Edit" id="edit-frequent-contact"
                    class="px-3 py-1 border border-success rounded  edit-frequent-contact mx-2">
                    <span class="fa fa-pencil text-success"></span></a>';

            $btn .= '<a href="javascript:void(0);" id="delete-frequent-contact" 
                    data-toggle="tooltip" data-original-title="Delete"
                    data-id="' . $freqContact->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
                    <span class="fa fa-trash" ></span></a>';

            $btn .= '<a href="javascript:void(0);" id="view-frequent-contact" 
                    data-toggle="tooltip" data-original-title="View"
                        data-id="' . $freqContact->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
                    <i class="fa fa-eye" ></i></a>';

            return $btn;

        })->addColumn('checkbox', function ($freqContact) {
        $checkBox = '<input type="checkbox" id="' . $freqContact->id . '"/>';
        return $checkBox;
    })->editColumn('created_by', function ($freqContact) {
        return Helper::getUserNames($freqContact->created_by);
    })->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FrequentContact $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FrequentContact $model)
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
                    ->setTableId('accomodation/frequentcontact-table')
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
           'email',
           'phone_number',
           'tin',
           'contact_person',
           'price',
           'currency_code',
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
        return 'accomodation/FrequentContact_' . date('YmdHis');
    }
}
