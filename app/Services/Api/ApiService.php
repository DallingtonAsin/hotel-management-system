<?php

namespace App\Services\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
        }catch (ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($e->getResponse()->getStatusCode() == 400) {
                return response()->json(['statusCode' => $statusCode, 'message' => $e->getMessage()]);
            }

        }
    }

    private function getApiResponse($response)
    {
        try {
            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody()->getContents());
                return response()->json(['statusCode' => $response->getStatusCode(), 'data' => $data]);
            } else {
                $message = (string) $response->getBody() || $response->getReasonPhrase();
                return response()->json(['statusCode' => $response->getStatusCode(), 'message' => $message]);
            }
        } catch (ClientException $e) {
             throw $e;
        }
    }
}
