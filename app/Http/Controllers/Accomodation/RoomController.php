<?php

namespace App\Http\Controllers\Accomodation;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\DataTables\Accomodation\RoomsDatatable;
use Illuminate\Support\Facades\Validator;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\Guest;
use App\Helpers\Helper;
use App\Models\Reservation;

class RoomController extends Controller
{

    public function index()
    {
        $total_rooms = Room::count();
        $room_statuses = RoomStatus::all();
        return view('pages.main.accomodation.rooms.index')
               ->with(compact('total_rooms', 'room_statuses'));
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
                $status_id = $request->input('status');
                $description = ucfirst($request->input('description'));
                $created_by = Helper::getLoggedInUserId();

                if (
                    Room::create([
                        'type_id' => $room_type_id,
                        'number' => $room_number,
                        'floor_number' => $floor_number,
                        'status_id' => $status_id,
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
            $items = Room::where("number", "like", "%".$query."%")->get();

            foreach($items as $item){
                $data[] = $item->number;
            }
            return response()->json($data);
        }

    }

    protected function getRoomOccupantDetails(Request $request, $room_number)
    {

        if($request->ajax()){
           
            $room_id = Room::where('number', $room_number)->value('id');
            $guest_id = Reservation::where("room_id", $room_id)->latest()->value('guest_id');
            if(!empty($guest_id)){
                $guest = Guest::find($guest_id);
                 return response()->json(['success'  => 'OK', 'data' => $guest]);
            }else{
                return response()->json(['error' => 'Please confirm that there is an occupant in this room, as it appears to be unoccupied.']);
            }

        }

    }

    public function getRoomPriceAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                if($request->filled(['room_number', 'occupancy_type'])){

                    $room_number = $request->input('room_number');
                    $occupancy_type = $request->input('occupancy_type');

                    $room_type_id = Room::where('number', $room_number)->value('type_id');
                    $roomType = RoomType::find($room_type_id);

                    if (stripos($occupancy_type, 'single') !== false) {
                        $price = $roomType->single_occupancy_rate;
                    } else {
                        $price = $roomType->double_occupancy_rate;
                    }

                    return response()->json([
                        'success' => 'OK',
                        'data' => number_format($price),
                    ]);

                   
                }else{
                    return response()->json(['error' => 'System unable to get room number or occupancy type']);
                }
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }



}