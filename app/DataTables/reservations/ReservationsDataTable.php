<?php

namespace App\DataTables\reservations;

use App\Models\Reservation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Models\Guest;
use App\Models\InvoiceGuest;
use App\Models\Room;
use Carbon\Carbon;
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
                 data-id="' . $reservation->id . '" data-original-title="Generate Invoice" id="generate-invoice"
                 class="btn btn-xs btn-primary text-white generate-invoice pr-1"><i class="fa fa-download pr-1"></i> Invoice</a>';

                return $btn;

            })->editColumn('created_by', function ($reservation) {
            return Helper::getUserNames($reservation->created_by);
        })->addColumn('guest', function ($reservation) {
            $guest = Guest::find($reservation->guest_id);
            return $guest->first_name . ' ' . $guest->last_name;
        })->addColumn('room_number', function ($reservation) {
            $room_number = Room::where('id', $reservation->room_id)->value('number');
            return $room_number;
        })->addColumn('nights', function ($reservation) {
            $nights = Carbon::parse($reservation->arrival_date)->diffInDays(Carbon::parse($reservation->departure_date));
            return $nights;
        })->addColumn('discount_percent', function ($reservation) {
            $discount_percent = InvoiceGuest::where('reservation_id', $reservation->id)->value('discount_percent');
            return $discount_percent;
        })->addColumn('total_amount', function ($reservation) {
            $total_amount = InvoiceGuest::where('reservation_id', $reservation->id)->value('total');
            $total_amount = number_format($total_amount);
            return $total_amount;
        })->addColumn('checkbox', function ($reservation) {
            $checkBox = '<input type="checkbox" id="' . $reservation->id . '"/>';
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