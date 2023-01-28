<?php 
namespace App\Repositories;

use App\Models\StaffPayment;

class StaffPaymentRepository
{
    protected $staffPayment;

    public function __construct(StaffPayment $staffPayment)
    {
        $this->staffPayment = $staffPayment;
    }

    public function create($staffPaymentData)
    {
        return $this->staffPayment->create($staffPaymentData);
    }

    public function get($id = null)
    {
        if($id){
           return $this->staffPayment->find($id);
        }
        return $this->staffPayment->all();
    }

    public function update($id, $staffPaymentData)
    {
        $staffPayment = $this->staffPayment->find($id);
        $staffPayment->update($staffPaymentData);
        return $staffPayment;
    }

    public function delete($id)
    {
        $staffPayment = $this->staffPayment->find($id);
        $staffPayment->delete();
        return $staffPayment;
    }

    public function exists($id){
        $staffPayment = $this->staffPayment->where('id', $id)->exists();
        return $staffPayment; 
    }
    
    public function count(){
        return $this->staffPayment->count();
    }

    public function checkIfPaymentExists($staff_id, $category_id, $date){
        return $this->staffPayment->where('staff_id', $staff_id)
                     ->where('payment_category_id', $category_id)
                     ->where('payment_date', $date)
                     ->exists();
    }

    public function checkIfPaymentExistsonUpdate($id, $staff_id, $category_id, $date){
        return $this->staffPayment->where('id', '!=', $id)->where('staff_id', $staff_id)
                     ->where('payment_category_id', $category_id)
                     ->where('payment_date', $date)
                     ->exists();
    }

}
