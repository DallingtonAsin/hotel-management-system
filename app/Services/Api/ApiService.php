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
        $this->url = 'http://efris-api.test/api';
    }

    public function get($endpoint)
    {
        try {
            $response = $this->client->get($this->url . '' . $endpoint);
            return $this->getApiResponse($response);

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function post($endpoint, $data)
    {
        try {
            $response = $this->client->post($this->url . '' . $endpoint, [
                'json' => $data
            ]);
            
            return $this->getApiResponse($response);
          
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

        private function getApiResponse($response){
            try{
                if ($response->getStatusCode() == 200) {
                    $result['data'] = json_decode($response->getBody()->getContents());
                } else {
                    $result['message'] = (string) $response->getBody() || $response->getReasonPhrase();
                }
    
                $result['statusCode'] = $response->getStatusCode();
                return $result;
            }catch(\Exception $ex){
                throw $ex;
            }
        }
}