<?php 

namespace App\Services;

use App\Repositories\StaffRepository;

class PermissionService
{

    protected $staffRepository;
    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }
    public function hasPermission($permissionName)
    {
        try{
            return $this->staffRepository->hasPermissions($permissionName);
        }catch(\Exception $ex){
            throw $ex;
        }
        
    }
}