<?php

namespace App\Http\Controllers\Accomodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Accomodation\RoomTypesDatatable;
use App\Models\RoomType;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper as Helper;

class RoomTypeController extends Controller
{
    
    public function index()
    {
        $total_room_types = RoomType::count();
        return view('pages.main.accomodation.rooms.types', ['total_room_types' => $total_room_types]);
    }

    public function RoomTypesDataTable(RoomTypesDatatable $dataTable)
    {
        return $dataTable->render('pages.main.accomodation.rooms.types');
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
            'name' => 'required|max:55',
            'single_occupancy_rate' => 'required',
            'double_occupancy_rate' => 'required',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {
                $name = ucfirst($request->input('name'));
                $s_rate = Helper::Numberize($request->input('single_occupancy_rate'));
                $d_rate = Helper::Numberize($request->input('double_occupancy_rate'));

                $created_by = Helper::getLoggedInUserId();
                if (RoomType::create([
                    'name' => $name,
                    'single_occupancy_rate' => $s_rate,
                    'double_occupancy_rate' => $d_rate,
                    'created_by' => $created_by
                 ])) {
                    $message = "Room type " . $name . " has been added successfully";
                    $stats = $this->GetRoomTypeStats();
                    $data = [
                        'success' => $message,
                        'data' => $stats['data'],
                        'total' => $stats['total']
                    ];
                } else {
                    $message = "Technical error in adding room type";
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

    private function GetRoomTypeStats()
    {
        try {
            $room_types = RoomType::all();
            $total_room_types = RoomType::count();

            $data = array(
                'data' => $room_types,
                'total' => $total_room_types
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function fetchRoomTypesAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                $room_types = RoomType::get();
                echo json_encode($room_types);
                die();
            }
        } catch (\Exception $ex) {
            echo "Error " . $ex->getMessage();
        }
    }
}
