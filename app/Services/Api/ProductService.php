<?php

namespace App\Services\Api;

use GuzzleHttp\Client;
use App\Repositories\Api\ProductRepository;

class ProductService
{
    protected $client;
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->client = new Client();
        $this->productRepository = $productRepository;
    }

    public function create($productData)
    {
        try {
            $response = $this->client->post('https://example.com/api/users', [
                'form_params' => $productData
            ]);
            $data = json_decode($response->getBody()->getContents());
            $this->productRepository->create($data);
            
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function get($id)
    {
        try {
            $response = $this->client->get('https://example.com/api/users/'.$id);
            $data = json_decode($response->getBody()->getContents());
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id, $productData)
    {
        try {
            $response = $this->client->put('https://example.com/api/users/'.$id, [
                'form_params' => $productData
            ]);
            $data = json_decode($response->getBody()->getContents());
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $response = $this->client->delete('https://example.com/api/users/'.$id);
            $data = json_decode($response->getBody()->getContents());
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
