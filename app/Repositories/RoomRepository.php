<?php

namespace App\Repositories;

use App\Models\Room;

class RoomRepository
{
    protected $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function create($roomData)
    {
        try {
            return $this->room->create($roomData);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function get($id = null)
    {
        try {
            if($id){
                return $this->room->find($id);
            }
            return $this->room->all();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function update($id, $roomData)
    {
        try {
            $room = $this->room->find($id);
            $room->update($roomData);
            return $room;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $room = $this->room->find($id);
            $room->delete();
            return $room;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function isAvailable($id){
        try {

            $is_available = false;
            $room_statuses = config('room-statuses');
          
            $room = $this->room->find($id);
            $room_status = $room->status->name;
            
            if(strtolower($room_status) ===  strtolower($room_statuses['available'])){
                $is_available = true;
            }

            return $is_available;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    public function findRoomByNumber($number){
        return $this->room->where('number', $number);
    }
}
