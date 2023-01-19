<?php

namespace App\DataTables\Accomodation;

use App\Models\Reservation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Models\Guest;
use App\Models\GuestType;
use App\Models\ReservationInvoice;
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

                $btn = "";
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                 data-id="' . $reservation->id . '" data-original-title="Generate Invoice" id="generate-invoice"
                 class="btn btn-xs btn-primary text-white generate-invoice"><i class="fa fa-download pr-1"></i> Invoice</a>';

                 $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                 data-id="' . $reservation->id . '" data-original-title="Cancel Reservation" id="cancel-reservation"
                 class="btn btn-xs btn-danger text-white cancel-reservation ml-2"><i class="fa fa-trash-alt pr-1"></i> Cancel</a>';


                return $btn;

            })->editColumn('created_by', function ($reservation) {
            return Helper::getUserNames($reservation->created_by);
        })->addColumn('guest_type', function ($reservation) {
            $guestTypeObj = GuestType::find($reservation->guest_type_id);
            return $guestTypeObj->name;
        })->addColumn('invoice_number', function ($reservation) {
            $ReservationInvoice = ReservationInvoice::find($reservation->id);
            if(isset($ReservationInvoice->invoice_number)){
                $invoice_number = $ReservationInvoice->invoice_number;
            }else{
                $invoice_number = '00000';
            }
            return $invoice_number;
        })->addColumn('invoice_status', function ($reservation) {
            $invoice = ReservationInvoice::find($reservation->id);
            $status = !empty($invoice->status) ? ucfirst($invoice->status) : 'Pending';
            return $status;
        })->addColumn('amount', function ($reservation) {
            $invoice = ReservationInvoice::find($reservation->id);
            $amount = !empty($invoice->amount) ? number_format($invoice->amount) : 50;
            return $amount;
        })->addColumn('tax', function ($reservation) {
            $invoice = ReservationInvoice::find($reservation->id);
            $tax = !empty($invoice->tax) ? number_format($invoice->tax) : 50;
            return $tax;
        })->addColumn('discount_percent', function ($reservation) {
            $invoice = ReservationInvoice::find($reservation->id);
            $discount_percent = !empty($invoice->tadiscount_percentx) ? number_format($invoice->discount_percent) : 50;
            return $discount_percent;
        })->addColumn('total_amount', function ($reservation) {
            $invoice = ReservationInvoice::find($reservation->id);
            $total_amount = !empty($invoice->total_amount) ? number_format($invoice->total_amount) : 50;
            return $total_amount;
        })->addColumn('guest', function ($reservation) {
            $guest = Guest::find($reservation->guest_id);
            return $guest->first_name . ' ' . $guest->last_name;
        })->addColumn('room_number', function ($reservation) {
            $room_number = Room::where('id', $reservation->room_id)->value('number');
            return $room_number;
        })->addColumn('nights', function ($reservation) {
            $nights = Carbon::parse($reservation->arrival_date)->diffInDays(Carbon::parse($reservation->departure_date));
            return $nights;
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