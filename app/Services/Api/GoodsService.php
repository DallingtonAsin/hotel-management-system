<?php

namespace App\Services\Api;

use App\Repositories\GoodsRepository;
use App\Services\Api\ApiService;

class GoodsService
{
    protected $apiService;
    protected $goodRepository;

    public function __construct(GoodsRepository $goodRepository, ApiService $apiService)
    {
        $this->apiService = $apiService;
        $this->goodRepository = $goodRepository;
    }

 // efris endpoints
    public function addGood($goodData)
    {
        try {
           return $this->apiService->post('/register-good', $goodData);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function get()
    {
        try {
            return $this->apiService->get('/goods');
        } catch (\Exception $e) {
            return $e;
        }
    }

}
