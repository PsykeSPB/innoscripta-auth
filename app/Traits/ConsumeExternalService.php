<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait  ConsumeExternalService
{
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [])
    {
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);

        if (isset($this->access_token)) {
            $headers['Authorization'] = 'Bearer ' . $this->access_token;
        }

        $response = $client->request($method, $requestUrl, [
            'form_params' => $formParams, 'headers' => $headers
        ]);

        return \GuzzleHttp\json_decode($response->getBody()->getContents());
    }
}