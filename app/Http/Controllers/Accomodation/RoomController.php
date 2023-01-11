<?php

namespace App\Http\Controllers\Accomodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Accomodation\RoomsDatatable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Helpers\Helper;

class RoomController extends Controller
{

    public function index()
    {
        $total_rooms = Room::count();
        return view('pages.main.accomodation.rooms.index', ['total_rooms' => $total_rooms]);
    }

    public function RoomsDataTable(RoomsDatatable $dataTable)
    {
        return $dataTable->render('pages.main.accomodation.rooms.index');
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
            'room_type' => 'required',
            'room_number' => 'required',
            'floor_number' => 'required',
            'status' => 'required',
            'description' => 'sometimes|nullable',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $room_type_id = $request->input('room_type');
                $room_number = $request->input('room_number');
                $floor_number = Helper::Numberize($request->input('floor_number'));
                $status = ucfirst($request->input('status'));
                $description = ucfirst($request->input('description'));
                $created_by = Helper::getLoggedInUserId();

                if (
                    Room::create([
                        'type_id' => $room_type_id,
                        'number' => $room_number,
                        'floor_number' => $floor_number,
                        'status' => $status,
                        'description' => $description,
                        'created_by' => $created_by
                    ])
                ) {

                    $message = "Room with number " . $room_number . " has been added successfully";
                    $stats = $this->GetRoomStats();
                    $data = [
                        'success' => $message,
                        'data' => $stats['data'],
                        'total' => $stats['total']
                    ];
                } else {
                    $message = "Technical error in adding room";
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

    private function GetRoomStats()
    {
        try {
            $rooms = Room::all();
            $total_rooms = Room::count();

            $data = array(
                'data' => $rooms,
                'total' => $total_rooms
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function fetchRoomsAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                $rooms = Room::get();
                echo json_encode($rooms);
                die();
            }
        } catch (\Exception $ex) {
            echo "Error " . $ex->getMessage();
        }
    }

    public function suggestRoomss(Request $request)
    {
        try {
            $data = array();
            $room_number = $request->room_number;
       
            $room_suggestions = Room::where('number', 'like', '%' . $room_number . '%')
                ->get();
            foreach ($room_suggestions as $item) {
                $data[] = $item->id;
                $data[] = $item->number;
            }
            // return response()->json($data);
            echo json_encode($data);

        } catch (\Exception $ex) {
            echo "Error " . $ex->getMessage();
        }
    }


    protected function suggestRooms(Request $request)
    {

        if($request->input('query')){
            $query = $request->input('query');
            $data = array();
            $items = DB::table("rooms")
            ->where("number", "like", "%".$query."%")
            ->get();

            foreach($items as $item){
                $data[] = $item->number;
            }
            return response()->json($data);
        }

    }
}