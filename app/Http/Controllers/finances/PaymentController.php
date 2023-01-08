<?php

namespace App\Http\Controllers\finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\finances\PaymentsDataTable;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Models\Guest;
use App\Models\InvoiceGuest;
use App\Helpers\Helper;
class PaymentController extends Controller
{
    

    public function index()
    {
        $total_payments = Payment::count();
        return view('pages.main.hr.finances.payments')->with(compact('total_payments'));
    }

    public function getPaymentsDataTable(PaymentsDataTable $dataTable)
    {
        return $dataTable->render('pages.main.hr.finances.payments');
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
        $validator = Validator::make($request->all(), [
            'guest' => 'required',
            'invoice_id' => 'required',
            'payment_method' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $guest_id = $request->input('guest');
                $invoice_id = $request->input('invoice_id');
                $amount = Helper::Numberize($request->input('amount'));
                $payment_method = $request->input('payment_method');
                $payment_date = $request->input('payment_date');
                $guest = Guest::find($guest_id);
                $guest_name = $guest->first_name . ' ' . $guest->last_name;

                $doesInvoiceExist = InvoiceGuest::where('id', $invoice_id)->exists();
                if ($doesInvoiceExist) {

                    $created_by = Helper::getLoggedInUserId();
                    $payment_details = [
                        'guest_id' => $guest_id,
                        'invoice_id' => $invoice_id,
                        'amount' => $amount,
                        'method' => $payment_method,
                        'date' => $payment_date,
                        'created_by' => $created_by
                    ];

                    if (
                        Payment::create($payment_details)
                    ) {
                        $message = "Payment for guest " . $guest_name . " has been recorded successfully";
                        $stats = $this->GetPaymentStats();
                        $data = [
                            'success' => $message,
                            'data' => $stats['data'],
                            'total' => $stats['total']
                        ];
                    } else {

                        $message = "Technical error in adding payment details";
                        $data = [
                            'error' => $message
                        ];
                    }
                }else{
                    return response()->json(['error' => 'Invoice number does not exist']); 
                }
                return response()->json($data);
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
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

    private function GetPaymentStats()
    {
        try {

            $payments = Payment::all();
            $total_payments = Payment::count();

            $data = array(
                'data' => $payments,
                'total' => $total_payments
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
