<?php

namespace App\Http\Controllers\Accomodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Accomodation\GuestTypesDatatable;
use App\Models\GuestType;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class GuestTypeController extends Controller
{
    
    public function index()
    {
        $total_guest_types = GuestType::count();
        return view('pages.main.accomodation.guests.types')->with(compact('total_guest_types'));
    }

    public function getGuestTypesDataTable(GuestTypesDatatable $dataTable)
    {
        return $dataTable->render('pages.main.accomodation.guests.types');
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
                $created_by = Helper::getLoggedInUserId();

                $req_data = [
                    'name' => $name,
                    'is_regular' => $is_regular_bool,
                    'is_corporate' => $is_corporate_bool,
                    'created_by' => $created_by,
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


    private function getGuestTypeDetails($id)
    {
        try {
            $data = GuestType::find($id);
            $data->is_regular = $data->is_regular == 1 ? 'Yes' : 'No';
            $data->is_corporate = $data->is_corporate == 1 ? 'Yes' : 'No';
            return response()->json(['success' => 'ok', 'data' => $data]);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
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
        return $this->getGuestTypeDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getGuestTypeDetails($id);
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
