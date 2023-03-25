<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    private Client $client;

    public function __construct(string $base_url) {
        $this->client = new Client(
            [
                'base_uri' => $base_url,
                'timeout' => 30,
            ]
        );
    }

    /**
     * @throws GuzzleException
     */
    public function call(string $method, string $uri, array $body): ResponseInterface
    {
        $headers = [
            'Authorization' => 'Basic ' . base64_encode("{$_ENV['public_key']}:{$_ENV['private_key']}"),
            'Country-Code' => 'CAN',
            'Content-Type' => 'application/json',
        ];
        return $this->client->request($method, $uri, [
            'body' => json_encode($body),
            'headers' => $headers,
        ]);
    }
}