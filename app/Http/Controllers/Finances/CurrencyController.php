<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\DataTables\Finances\CurrencyDataTable;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_currencies = Currency::count();
        return view('pages.main.hr.finances.currency')->with(compact('total_currencies'));
    }

    public function getCurrencyDataTable(CurrencyDataTable $dataTable)
    {
        return $dataTable->render('pages.main.hr.finances.currency');
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
            'country_name' => 'required',
            'currency_code' => 'required',
            'rate' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $country_name = ucfirst($request->input('country_name'));
                $currency_code = strtoupper($request->input('currency_code'));

                $exists = $this->checkIfCurrencyExists($country_name, $currency_code);
                if ($exists) {
                    return response()->json(['error' => 'Currency code ' . $currency_code . ' or country ' . $country_name . ' already exists']);
                } else {

                    $rate = Helper::Numberize($request->input('rate'));
                    $created_by = Helper::getLoggedInUserId();

                    $data = [
                        'country' => $country_name,
                        'code' => $currency_code,
                        'rate' => $rate,
                        'created_by' => $created_by
                    ];

                    if (Currency::create($data)) {
                        $message = "Currency code " . $currency_code . " has been added successfully";
                        $stats = $this->getCurrencyStats();
                        $data = [
                            'success' => $message,
                            'data' => $stats['data'],
                            'total' => $stats['total']
                        ];
                    } else {
                        $message = "Technical error in adding currency";
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


    private function checkIfCurrencyExists($country, $currency_code)
    {
        try {

            $exists = Currency::where('code', 'like', "%" . $currency_code . "%")
                ->orWhere('country', 'like', "%" . $country . "%")
                ->exists();
            return $exists;

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    private function getCurrencyStats()
    {
        try {

            $currencies = Currency::all();
            $total_currencies = Currency::count();

            $data = array(
                'data' => $currencies,
                'total' => $total_currencies
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
}