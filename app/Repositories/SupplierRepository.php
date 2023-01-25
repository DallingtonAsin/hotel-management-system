<?php 
namespace App\Repositories;

use App\Models\Supplier;

class SupplierRepository
{
    protected $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function create($supplierData)
    {
        return $this->supplier->create($supplierData);
    }

    public function get($id = null)
    {
        if($id){
           return $this->supplier->find($id);
        }
        return $this->supplier->all();
    }

    public function update($id, $supplierData)
    {
        $supplier = $this->supplier->find($id);
        $supplier->update($supplierData);
        return $supplier;
    }

    public function delete($id)
    {
        $supplier = $this->supplier->find($id);
        $supplier->delete();
        return $supplier;
    }

    public function exists($id){
        return $this->supplier->where('id', $id)->exists();
    }

    public function increase($id, $quantity){
        return $this->supplier->find($id)->increase($quantity);
    }

    public function decrease($id, $quantity){
        return $this->supplier->find($id)->decrease($quantity);
    }

    
}
