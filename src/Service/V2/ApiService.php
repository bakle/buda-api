<?php

namespace Bakle\Buda\Service\V2;

use Bakle\Buda\Client\GuzzleClient;
use Bakle\Buda\Contracts\ClientContract;

class ApiService
{
    /** @var string */
    private $format = 'json';

    /** @var string */
    private $baseUrl = 'https://www.buda.com/api/v2';

    /** @var ClientContract */
    private $client;

    public function __construct()
    {
        $this->client = new GuzzleClient($this->baseUrl);
    }

    public function get(string $endpoint, array $parameters, array $headers)
    {
        $this->client->get($endpoint, $parameters, $headers);
    }

    public function post(string $endpoint, array $parameters, array $headers)
    {
        $this->client->post($endpoint, $parameters, $headers);
    }
}
