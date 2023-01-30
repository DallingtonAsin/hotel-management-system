<?php 

namespace App\Services;

use App\Repositories\RoomRepository;

class RoomService
{
    protected $roomRepository;
    public function __construct(RoomRepository $roomRepository)
    {
       $this->roomRepository = $roomRepository; 
    }

    public function create($data){
        try{
            return $this->roomRepository->create($data);
        }catch(\Exception $ex){
            throw $ex;
        }
    }

    public function isAvailable($id)
    {
        try{
            return $this->roomRepository->isAvailable($id);
        }catch(\Exception $ex){
            throw $ex;
        }  
    }
}