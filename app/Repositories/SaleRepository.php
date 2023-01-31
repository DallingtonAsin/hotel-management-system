<?php 
namespace App\Repositories;

use App\Models\Sale;

class SaleRepository
{
    protected $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function create($saleData)
    {
        return $this->sale->create($saleData);
    }

    public function get($id = null)
    {
        if($id){
           return $this->sale->find($id);
        }
        return $this->sale->all();
    }

    public function update($id, $saleData)
    {
        $sale = $this->sale->find($id);
        $sale->update($saleData);
        return $sale;
    }

    public function delete($id)
    {
        $sale = $this->sale->find($id);
        $sale->delete();
        return $sale;
    }

    public function exists($id){
        $sale = $this->sale->where('id', $id)->exists();
        return $sale; 
    }


}
