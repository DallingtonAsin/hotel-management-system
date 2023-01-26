<?php 
namespace App\Repositories;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

class StaffRepository
{
    protected $staff;

    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function create($staffData)
    {
        return $this->staff->create($staffData);
    }

    public function get($id = null)
    {
        if($id){
           return $this->staff->find($id);
        }
        return $this->staff->all();
    }

    public function update($id, $staffData)
    {
        $staff = $this->staff->find($id);
        $staff->update($staffData);
        return $staff;
    }

    public function delete($id)
    {
        $staff = $this->staff->find($id);
        $staff->delete();
        return $staff;
    }

    public function exists($id){
        $staff = $this->staff->where('id', $id)->exists();
        return $staff; 
    }

    public function increase($id, $quantity){
        return $this->staff->find($id)->increase($quantity);
    }

    public function decrease($id, $quantity){
        return $this->staff->find($id)->decrease($quantity);
    }

    public function hasPermissions($permission_name){
        $user = $this->staff->find(Auth::user()->id);
        $hasAccess = $user->hasPermission($permission_name);
        return $hasAccess;
    }

    
}
