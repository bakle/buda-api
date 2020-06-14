<?php

namespace Bakle\Buda;

use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Responses\MarketResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Buda
{
    /** @var string */
    private $format = 'json';

    /** @var string */
    private $baseUrl = 'https://www.buda.com/api/v2/';

    /** @var Client */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 5,
        ]);
    }

    /**
     * @param string $market
     * @return MarketResponse
     * @throws BudaException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTickerMarket(string $market): MarketResponse
    {
        try {
            $response = $this->client->request('GET', 'markets/'.$market.'/ticker.'.$this->format);

            return new MarketResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }
}
