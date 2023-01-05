<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\guests\GuestTypesDatatable;
use App\Models\GuestType;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class GuestTypeController extends Controller
{
    
    public function index()
    {
        $total_guest_types = GuestType::count();
        return view('pages.main.guests.types')->with(compact('total_guest_types'));
    }

    public function getGuestTypesDataTable(GuestTypesDatatable $dataTable)
    {
        return $dataTable->render('pages.main.guests.types');
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
            'name' => 'required',
        ]);
   
        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $name = ucfirst($request->input('name'));
                $is_regular = $request->input('is_regular');
                $is_corporate = $request->input('is_corporate');

                $is_regular_bool = $is_regular == 'Yes';
                $is_corporate_bool = $is_corporate == 'Yes';
                $added_by = Helper::getLoggedInUser();

                $req_data = [
                    'name' => $name,
                    'is_regular' => $is_regular_bool,
                    'is_corporate' => $is_corporate_bool,
                    'added_by' => $added_by,
                ];
            
                if (GuestType::create($req_data)) {

                    $message = "Guest type " . $name . " added successfully";
                    $stats = $this->GetGuestTypeStats();
                    $data = [
                        'success' => $message,
                        'data' => $stats['data'],
                        'total' => $stats['total']
                    ];

                } else {
                    $message = "Technical error in adding guest type";
                    $data = [
                        'error' => $message
                    ];
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

    private function GetGuestTypeStats()
    {
        try {

            $guest_types = GuestType::all();
            $total_guest_types = GuestType::count();

            $data = array(
                'data' => $guest_types,
                'total' => $total_guest_types
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
