<?php 
namespace App\Repositories;

use App\Models\PaymentCategory;

class PaymentCategoryRepository
{
    protected $paymentCategory;

    public function __construct(PaymentCategory $paymentCategory)
    {
        $this->paymentCategory = $paymentCategory;
    }

    public function create($paymentCategoryData)
    {
        return $this->paymentCategory->create($paymentCategoryData);
    }

    public function get($id = null)
    {
        if($id){
           return $this->paymentCategory->find($id);
        }
        return $this->paymentCategory->all();
    }

    public function update($id, $paymentCategoryData)
    {
        $paymentCategory = $this->paymentCategory->find($id);
        $paymentCategory->update($paymentCategoryData);
        return $paymentCategory;
    }

    public function delete($id)
    {
        $paymentCategory = $this->paymentCategory->find($id);
        $paymentCategory->delete();
        return $paymentCategory;
    }

    public function exists($id){
        $paymentCategory = $this->paymentCategory->where('id', $id)->exists();
        return $paymentCategory; 
    }
    

    public function count(){
        return $this->paymentCategory->count();
    }

    public function existsPaymentCategory($name){
            return $this->paymentCategory->where('name', $name)->exists();
    }

    public function checkPaymentCategoryonUpdate($id, $name){
            return $this->paymentCategory->where('id', '!=', $id)->where('name', $name)->exists();
    }

}
