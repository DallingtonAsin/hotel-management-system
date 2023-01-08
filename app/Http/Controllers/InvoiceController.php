<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\InvoiceGuest;
use App\Models\Guest;
use App\Models\Company;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Reservation;



class InvoiceController extends Controller
{

    public function index()
    {
        //
    }

    public function generateInvoicePDF()
    {
        $pdf = PDF::loadView('pages.main.invoices.booking');

        return $pdf->download('nicesnippets.pdf');
    }

    private function createInvoicesDirIfnotExists($directory)
    {
        try {
            $path = public_path($directory);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function download($id)
    {

        try {
            // $invoice = InvoiceGuest::find($id);
            $directory = 'invoices';
            $this->createInvoicesDirIfnotExists(($directory));
   
            $filename = 'invoice-' . $id . '.pdf';
            $path = public_path('' . $directory . '/' . $filename);
            
            $count = Company::count();
            $company = [];
            if($count > 0){
                $company = Company::first();
            }

            $invoice = InvoiceGuest::where('reservation_id', $id)->first();
            $reservation = Reservation::find($id);

            $occupancy_type = $reservation->occupancy_type;
            $guest_id = $reservation->guest_id;
            $guest = Guest::find($guest_id);
         
            $room = Room::find($reservation->room_id);
            $room_type_id = $room->type_id;
           
            $roomType = RoomType::find($room_type_id);
            $room_type = $roomType->name;

            $tax_fees = $invoice->total * 0.18;


            if (stripos($occupancy_type, 'single') !== false) {
                $price_rate = number_format($roomType->single_occupancy_rate);
            } else {
                $price_rate = number_format($roomType->double_occupancy_rate);
            }

            $total_amount = $invoice->total + $tax_fees;

            $pdf = PDF::loadView('pages.main.invoices.reservation', [
                'invoice' => $invoice,
                'guest' => $guest,
                'company' => $company,
                'reservation' => $reservation,
                'room_type' => $room_type,
                'price_rate' => $price_rate,
                'tax_fees' => $tax_fees,
                'total_amount' => $total_amount
            ]);
            $pdf->save($path);

            $subpath = 'invoices/' . $filename;
            $url = Storage::disk('invoices')->url($subpath);
          
          
            return response()->json(['url' => $url]);

        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return back()->with('error', $ex->getMessage());
        }

        // return $pdf->stream('nicesnippets.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}