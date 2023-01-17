<?php 
namespace App\Repositories\Api;

use App\Models\Stock;

class ProductRepository
{
    protected $product;

    public function __construct(Stock $product)
    {
        $this->product = $product;
    }

    public function create($productData)
    {
        return $this->product->create($productData);
    }

    public function get($id)
    {
        return $this->product->find($id);
    }

    public function update($id, $productData)
    {
        $product = $this->product->find($id);
        $product->update($productData);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->product->find($id);
        $product->delete();
        return $product;
    }
}
