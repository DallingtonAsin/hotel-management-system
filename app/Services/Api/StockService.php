<?php

namespace App\Services\Api;

use App\Repositories\StockRepository;
use App\Services\Api\ApiService;

class StockService
{
    protected $apiService;
    protected $stockRepository;

    public function __construct(StockRepository $stockRepository, ApiService $apiService)
    {
        $this->apiService = $apiService;
        $this->stockRepository = $stockRepository;
    }

    public function addStock($productData)
    {
        try {
           return $this->apiService->post('/add-stock', $productData);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function get()
    {
        try {
            return $this->apiService->get('/get-stock');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
