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

    public function get($id)
    {
        return $this->stock->find($id);
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
}
