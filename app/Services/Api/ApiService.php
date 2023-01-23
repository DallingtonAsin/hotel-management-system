<?php

namespace App\Services\Api;

use GuzzleHttp\Client;

class ApiService
{
    protected $client;
    protected $url;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = 'http://127.0.0.1:8000';
    }

    public function get()
    {
        try {
            $response = $this->client->get($this->url);
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function post($data)
    {
        try {
            $response = $this->client->post($this->url, [
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

}
