<?php

namespace Bakle\Buda;

use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Responses\MarketResponse;
use Bakle\Buda\Responses\MarketVolumeResponse;
use Bakle\Buda\Responses\OrderBookResponse;
use Bakle\Buda\Responses\TickerMarketResponse;
use Bakle\Buda\Responses\TradeResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

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
     * @return MarketResponse
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getMarkets(): MarketResponse
    {
        try {
            $response = $this->client->request('GET', 'markets.'.$this->format);

            return new MarketResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @return MarketResponse
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getMarket(string $market): MarketResponse
    {
        try {
            $response = $this->client->request('GET', 'markets/'.$market.'.'.$this->format);

            return new MarketResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @return MarketVolumeResponse
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getMarketVolume(string $market): MarketVolumeResponse
    {
        try {
            $response = $this->client->request('GET', 'markets/'.$market.'/volume.'.$this->format);

            return new MarketVolumeResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @return TickerMarketResponse
     * @throws BudaException|GuzzleException
     */
    public function getTickerMarket(string $market): TickerMarketResponse
    {
        try {
            $response = $this->client->request('GET', 'markets/'.$market.'/ticker.'.$this->format);

            return new TickerMarketResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @return OrderBookResponse
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getOrdersBook(string $market): OrderBookResponse
    {
        try {
            $response = $this->client->request('GET', 'markets/'.$market.'/order_book.'.$this->format);

            $data = json_decode($response->getBody()->getContents());
            $data->order_book->market_id = strtoupper($market);

            return new OrderBookResponse($response->getStatusCode(), json_encode($data));
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @param int $limit
     * @param int $timestamp
     * @return TradeResponse
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getTrades(string $market, $limit = 50, int $timestamp = 0): TradeResponse
    {
        try {
            $body['limit'] = $limit;

            if ($timestamp) {
                $body['timestamp'] = $timestamp;
            }

            $response = $this->client->request('GET', 'markets/'.$market.'/trades.'.$this->format, [
                'query' => $body,
            ]);

            return new TradeResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }
}
