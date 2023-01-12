<?php

namespace App\Http\Controllers\Accomodation;

use App\DataTables\Accomodation\FrequentContactDataTable;
use App\Http\Controllers\Controller;
use App\Models\FrequentContact;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;

class FrequentContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $total_frequent_contacts = FrequentContact::count();
        return view('pages.main.hr.frequent_contacts')->with(compact('total_frequent_contacts'));
    }

    public function getFrequentContactsDataTable(FrequentContactDataTable $dataTable)
    {
        return $dataTable->render('pages.main.hr.frequent_contacts');
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
     * return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'tin' => 'required',
            'contact_person' => 'required',
            'price' => 'required',
            'currency' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $name = ucfirst($request->input('name'));
                $email = $request->input('email');
                $phone_number = $request->input('phone_number');
                $tin = $request->input('tin');
                $contact_person = $request->input('contact_person');
                $price = $request->input('price');
                $currency_id = $request->input('currency');

                $currency_code = Currency::where('id', $currency_id)->value('code');

                $exists = FrequentContact::where('name', $name)
                                          ->where('phone_number', $phone_number)
                                           ->where('email', $email)->exists();
                if ($exists) {
                    return response()->json(['error' => 'Frequent contact ' . $name . ' already exists']);
                } else {

                    $price = Helper::Numberize($request->input('price'));
                    $created_by = Helper::getLoggedInUserId();

                    $data = [
                        'name' => $name,
                        'email' => $email,
                        'phone_number' => $phone_number,
                        'tin' => $tin,
                        'contact_person' => $contact_person,
                        'price' => $price,
                        'currency_code' => $currency_code,
                        'created_by' => $created_by
                    ];

                    if (FrequentContact::create($data)) {
                        $message = "Frequent contact " . $name . " has been added successfully";
                        $stats = $this->getFrequentContactStats();
                        $data = [
                            'success' => $message,
                            'data' => $stats['data'],
                            'total' => $stats['total']
                        ];
                    } else {

                        $message = "Technical error in adding frequent contact";
                        $data = [
                            'error' => $message
                        ];
                    }
                    return response()->json($data);
                }
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    private function getFrequentContactStats()
    {
        try {

            $frequent_contacts = FrequentContact::all();
            $total_frequent_contacts = FrequentContact::count();

            $data = array(
                'data' => $frequent_contacts,
                'total' => $total_frequent_contacts
            );

            return $data;
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

    public function fetchFrequentContactsAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                $freq_contacts = FrequentContact::get();
                echo json_encode($freq_contacts);
                die();
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function fetchFreqContactDetailsById(Request $request, $freq_contact_id)
    {
        try {
            if ($request->ajax()) {
                $details = FrequentContact::where('id', $freq_contact_id)->get();
                echo json_encode($details);
                die();

            }
        } catch (\Exception $ex) {
            echo "Error " . $ex->getMessage();
        }
    }

}
