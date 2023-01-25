<?php 
namespace App\Repositories;

use App\Models\Stock;

class StockRepository
{
    protected $stock;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function create($stockData)
    {
        return $this->stock->create($stockData);
    }

    public function get($id = null)
    {
        if($id){
           return $this->stock->find($id);
        }
        return $this->stock->all();
    }

    public function update($id, $stockData)
    {
        $stock = $this->stock->find($id);
        $stock->update($stockData);
        return $stock;
    }

    public function delete($id)
    {
        $stock = $this->stock->find($id);
        $stock->delete();
        return $stock;
    }

    public function exists($id){
        $stock = $this->stock->where('id', $id)->exists();
        return $stock; 
    }

    public function increase($id, $quantity){
        return $this->stock->find($id)->increase($quantity);
    }

    public function decrease($id, $quantity){
        return $this->stock->find($id)->decrease($quantity);
    }

    
}
