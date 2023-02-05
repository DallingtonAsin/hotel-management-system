<?php

namespace App\DataTables\Accomodation;

use App\Models\Guest;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class GuestsDataTable extends DataTable
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
            ->addColumn('action', function ($guest) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
                        data-id="' . $guest->id . '" data-original-title="Edit" id="edit-guest"
                        class="px-3 py-1 border border-success rounded  edit-guest mx-2">
                        <span class="fa fa-pencil text-success"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-guest" 
                        data-toggle="tooltip" data-original-title="Delete"
                        data-id="' . $guest->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
                        <span class="fa fa-trash" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-guest" 
                        data-toggle="tooltip" data-original-title="View"
                        data-id="' . $guest->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
                        <i class="fa fa-eye" ></i></a>';

                return $btn;
            })->editColumn('created_by', function ($guest) {
                return Helper::getUserNames($guest->created_by);
            })->addColumn('name', function ($guest) {
                $name = $guest->first_name . ' ' . $guest->last_name;
                return $name;
            })->addColumn('checkbox', function ($guest) {
                $checkBox = '<input type="checkbox" id="' . $guest->id . '"/>';
                return $checkBox;
            })->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Guest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Guest $model)
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
            ->setTableId('guests/guestsdatatable-table')
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
            'first_name',
            'last_name',
            'company_name',
            'tin_number',
            'company_contact',
            'company_email',
            'phone_number',
            'email',
            'passport_number',
            'tax_number',
            'nin',
            'other_details',
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
        return 'Guests_' . date('YmdHis');
    }
}
