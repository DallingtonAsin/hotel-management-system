<?php

namespace App\DataTables\reservations;

use App\Models\Reservation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Models\Guest;
use App\Helpers\Helper;

class ReservationsDataTable extends DataTable
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
            ->addColumn('action', function ($reservation) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="' . $reservation->id . '" data-original-title="Edit" id="edit-reservation"
              class="edit-btn edit-reservation pr-4">
             <span class="fa fa-pen"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-reservation" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="' . $reservation->id . '" class="trash-btn pr-4"">
            <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-reservation" 
           data-toggle="tooltip" data-original-title="View"
            data-id="' . $reservation->id . '" class="text-info bolded">
           <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->editColumn('created_by', function ($reservation) {
                return Helper::getUserNames($reservation->created_by);
            })->addColumn('guest', function ($reservation) {
                $guest = Guest::find($reservation->guest_id);
                return $guest->first_name.' '.$guest->last_name;
             })->addColumn('checkbox', function ($reservation) {
              $checkBox = '<input type="checkbox" id="'.$reservation->id.'"/>';
             return $checkBox;
             })->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Reservation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Reservation $model)
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
                    ->setTableId('reservations/reservationsdatatable-table')
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
            'guest_type',
            'arrival_date',
            'departure_date',
            'discount_percent',
            'total_price',
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
        return 'reservations/Reservations_' . date('YmdHis');
    }
}
