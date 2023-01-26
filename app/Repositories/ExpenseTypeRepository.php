<?php 
namespace App\Repositories;

use App\Models\ExpenseType;

class ExpenseTypeRepository
{
    protected $expenseType;

    public function __construct(ExpenseType $expenseType)
    {
        $this->expenseType = $expenseType;
    }

    public function create($expenseTypeData)
    {
        return $this->expenseType->create($expenseTypeData);
    }

    public function get($id = null)
    {
        if($id){
            return $this->expenseType->find($id);
        }
        return $this->expenseType->all();
    }

    public function update($id, $expenseTypeData)
    {
        $expenseType = $this->expenseType->find($id);
        $expenseType->update($expenseTypeData);
        return $expenseType;
    }

    public function delete($id)
    {
        $expenseType = $this->expenseType->find($id);
        $expenseType->delete();
        return $expenseType;
    }

    public function count(){
        try {
            return $this->expenseType->count();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function exists($id){
        try {
            return $this->expenseType->where('goods_code', $id)->exists();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function checkIfExpenseNameExists($name){
        try {
            return $this->expenseType->where('name', $name)->exists();
        } catch (\Exception $e) {
            return $e;
        }
    }
}
