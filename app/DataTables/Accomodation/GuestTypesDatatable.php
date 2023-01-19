<?php

namespace App\DataTables\Accomodation;

use App\Models\GuestType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class GuestTypesDatatable extends DataTable
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
            ->addColumn('action', function ($guestType) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="' . $guestType->id . '" data-original-title="Edit" id="edit-guest-type"
              class="px-3 py-1 border border-success rounded  edit-guest-type mx-2">
             <span class="fa fa-pen text-success"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-guest-type" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="' . $guestType->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
            <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-guest-type" 
           data-toggle="tooltip" data-original-title="View"
            data-id="' . $guestType->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
           <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->addColumn('checkbox', function ($guestType) {
            $checkBox = '<input type="checkbox" id="' . $guestType->id . '"/>';
            return $checkBox;
        })->editColumn('is_regular', function ($guestType) {
            return $guestType->is_regular ? true : false;
        })->editColumn('is_corporate', function ($guestType) {
            return $guestType->is_corporate ? true : false;
        })->editColumn('created_by', function ($guestType) {
            return Helper::getUserNames($guestType->created_by);
        })->rawColumns(['action', 'checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\GuestType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(GuestType $model)
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
            ->setTableId('guests/guesttypesdatatable-table')
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
            'is_regular',
            'is_corporate',
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
        return 'GuestTypes_' . date('YmdHis');
    }
}