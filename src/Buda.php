<?php

namespace Bakle\Buda;

use Bakle\Buda\Authenticator\Authenticator;
use Bakle\Buda\Constants\TransactionTypes;
use Bakle\Buda\Exceptions\AuthenticationException;
use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Responses\BalanceResponse;
use Bakle\Buda\Responses\FeeResponse;
use Bakle\Buda\Responses\MarketResponse;
use Bakle\Buda\Responses\MarketVolumeResponse;
use Bakle\Buda\Responses\OrderBookResponse;
use Bakle\Buda\Responses\OrderResponse;
use Bakle\Buda\Responses\TickerMarketResponse;
use Bakle\Buda\Responses\TradeResponse;
use Bakle\Buda\Validators\MarketValidator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class Buda
{
    /** @var string */
    private $format = 'json';

    /** @var string */
    private $baseUrl = '/api/v2/';

    /** @var Client */
    private $client;

    /** @var Authenticator */
    private $authenticator;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.buda.com'.$this->baseUrl,
            'timeout' => 5,
        ]);
    }

    /**
     * @param string $apiKey
     * @param string $secretKey
     */
    public function setCredentials(string $apiKey, string $secretKey): void
    {
        $this->authenticator = new Authenticator($apiKey, $secretKey);
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
        MarketValidator::validate($market);

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
        MarketValidator::validate($market);

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
        MarketValidator::validate($market);

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
        MarketValidator::validate($market);

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
        MarketValidator::validate($market);

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

    /**
     * @param string $currency
     * @param string $transactionType
     * @return FeeResponse
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getFees(string $currency, string $transactionType): FeeResponse
    {
        if (! in_array($transactionType, [TransactionTypes::DEPOSIT, TransactionTypes::WITHDRAWAL])) {
            throw new BudaException('Transaction type: '.$transactionType.' is not allowed!');
        }

        try {
            $response = $this->client->request(
                'GET', 'currencies/'.$currency.'/fees/'.$transactionType.'.'.$this->format
            );

            $data = json_decode($response->getBody()->getContents());
            $data->fee->currency = strtoupper($currency);

            return new FeeResponse($response->getStatusCode(), json_encode($data));
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @param string $state
     * @return OrderResponse
     * @throws AuthenticationException
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getOrders(string $market, string $state = ''): OrderResponse
    {
        MarketValidator::validate($market);

        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        try {
            $path = $this->baseUrl.'markets/'.$market.'/orders.'.$this->format;

            $query = [];

            if ($state) {
                $query['state'] = $state;
                $path .= '?state='.$state;
            }

            $this->authenticator->authenticate('GET', $path);

            $response = $this->client->request('GET', 'markets/'.$market.'/orders.'.$this->format, [
                'headers' => $this->authenticator->authenticationData(),
                'query' => $query,
            ]);

            return new OrderResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $currency
     * @return BalanceResponse
     * @throws AuthenticationException
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getBalances(string $currency = ''): BalanceResponse
    {
        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        try {
            $path = 'balances';

            if ($currency) {
                $path .= '/'.$currency;
            }

            $path .= '.'.$this->format;

            $this->authenticator->authenticate('GET', $this->baseUrl.$path);

            $response = $this->client->request('GET', $path, [
                'headers' => $this->authenticator->authenticationData(),
            ]);

            return new BalanceResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $orderId
     * @return OrderResponse
     * @throws AuthenticationException
     * @throws BudaException
     * @throws GuzzleException
     */
    public function getOrderDetail(string $orderId): OrderResponse
    {
        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        try {
            $path = 'orders/'.$orderId.$this->format;

            $this->authenticator->authenticate('GET', $this->baseUrl.$path);

            $response = $this->client->request('GET', $path, [
                'headers' => $this->authenticator->authenticationData(),
            ]);

            return new OrderResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @param string $orderType
     * @param string $priceType
     * @param float $amount
     * @param float|null $limit
     * @return OrderResponse
     * @throws AuthenticationException
     * @throws BudaException
     * @throws GuzzleException
     */
    public function newOrder(string $market, string $orderType, string $priceType, float $amount, ?float $limit = null): OrderResponse
    {
        MarketValidator::validate($market);

        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        try {
            $path = 'markets/'.$market.'/orders';

            $params = [];
            $params['type'] = $orderType;
            $params['price_type'] = $priceType;
            if ($limit) {
                $params['limit'] = $limit;
            }
            $params['amount'] = $amount;

            $this->authenticator->authenticate('POST', $this->baseUrl.$path, $params);

            $response = $this->client->request('POST', $path, [
                'headers' => $this->authenticator->authenticationData(),
                'json' => $params,
            ]);

            return new OrderResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $orderId
     * @return OrderResponse
     * @throws AuthenticationException
     * @throws BudaException
     * @throws GuzzleException
     */
    public function cancelOrder(string $orderId): OrderResponse
    {
        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        try {
            $path = 'orders/'.$orderId;

            $params = [
                'state' => 'canceling',
            ];

            $this->authenticator->authenticate('PUT', $this->baseUrl.$path, $params);

            $response = $this->client->request('PUT', $path, [
                'headers' => $this->authenticator->authenticationData(),
                'json' => $params,
            ]);

            return new OrderResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }
}
