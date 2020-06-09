<?php

namespace Bakle\Buda\Client;

use Bakle\Buda\Contracts\ClientContract;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient implements ClientContract
{
    /** @var Client */
    private $client;

    public function __construct(string $baseUrl)
    {
        $this->client = new Client([
            'base_url' => $baseUrl,
            'timeout' => 5,
        ]);
    }

    public function get(string $endpoint, array $parameters, array $headers): ResponseInterface
    {
        $this->client->request('GET', $endpoint, [
            'json' => $parameters,
        ]);
    }

    public function post(string $endpoint, array $parameters, array $headers): ResponseInterface
    {
        $this->client->request('POST', $endpoint, [
            'json' => $parameters,
        ]);
    }
}
