<?php

namespace Bakle\Buda\Tests\Mocks;

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
use GuzzleHttp\Exception\ClientException;

class BudaMock
{
    /** @var string */
    private $format = 'json';

    /** @var string */
    private $baseUrl = '/api/v2/';

    /** @var AuthenticatorMock */
    private $authenticator;

    /**
     * @param string $apiKey
     * @param string $secretKey
     */
    public function setCredentials(string $apiKey, string $secretKey): void
    {
        $this->authenticator = new AuthenticatorMock($apiKey, $secretKey);
    }

    /**
     * @return MarketResponse
     * @throws BudaException
     */
    public function getMarkets(): MarketResponse
    {
        try {
            $data = '{
            "markets":
                [
                    {
                        "id":"BTC-CLP",
                        "name":"btc-clp",
                        "base_currency":"BTC",
                        "quote_currency":"CLP",
                        "minimum_order_amount":["0.00002","BTC"],
                        "disabled":false,
                        "illiquid":false
                    },
                    {
                        "id":"BTC-COP",
                        "name":"btc-cop",
                        "base_currency":"BTC",
                        "quote_currency":"COP",
                        "minimum_order_amount":["0.00002","BTC"],
                        "disabled":false,
                        "illiquid":false
                    }
                ]
            }';

            return new MarketResponse('200', $data);
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @return MarketResponse
     * @throws BudaException
     */
    public function getMarket(string $market): MarketResponse
    {
        MarketValidator::validate($market);

        try {
            $data = '{
            "market":
                {
                        "id":"BTC-COP",
                        "name":"btc-cop",
                        "base_currency":"BTC",
                        "quote_currency":"COP",
                        "minimum_order_amount":["0.00002","BTC"],
                        "disabled":false,
                        "illiquid":false
                    }
            }';

            return new MarketResponse('200', $data);
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $market
     * @return MarketVolumeResponse
     * @throws BudaException
     */
    public function getMarketVolume(string $market): MarketVolumeResponse
    {
        MarketValidator::validate($market);

        $data = '{
                "volume": {
                    "market_id": "BTC-COP",
                    "bid_volume_24h": [
                        "5.02389055",
                        "BTC"
                    ],
                    "ask_volume_24h": [
                        "4.40828336",
                        "BTC"
                    ],
                    "bid_volume_7d": [
                        "42.4818546",
                        "BTC"
                    ],
                    "ask_volume_7d": [
                        "45.6118442",
                        "BTC"
                    ]
                }
        }';

        return new MarketVolumeResponse('200', $data);
    }

    /**
     * @param string $market
     * @return TickerMarketResponse
     * @throws BudaException
     */
    public function getTickerMarket(string $market): TickerMarketResponse
    {
        MarketValidator::validate($market);

        $market = strtoupper($market);
        $data = '{"ticker":{"market_id":"'.$market.'","last_price":["0.02537093","BTC"],"min_ask":["0.02518027","BTC"],"max_bid":["0.02485485","BTC"],"volume":["0.0","ETH"],"price_variation_24h":"0.0","price_variation_7d":"0.003"}}';

        return new TickerMarketResponse('200', $data);
    }

    /**
     * @param string $market
     * @return OrderBookResponse
     * @throws BudaException
     */
    public function getOrdersBook(string $market): OrderBookResponse
    {
        MarketValidator::validate($market);

        $data = '{"order_book":{"market_id":"'.strtoupper($market).'","asks":[["836677.14", "0.447349"]],"bids":[["821580.0", "0.25667389"]]}}';

        return new OrderBookResponse('200', $data);
    }

    /**
     * @param string $market
     * @param int $limit
     * @param int $timestamp
     * @return TradeResponse
     * @throws BudaException
     */
    public function getTrades(string $market, $limit = 50, int $timestamp = 0): TradeResponse
    {
        MarketValidator::validate($market);

        $entries = '[
            ["1592763501284","0.00035029","33969985.0","buy",1050379],
            ["1592763085557","0.0062085","33542711.0","sell",1050370],
            ["1592758811991","0.00287978","33969990.0","buy",1050350],
            ["1592758175163","0.00906818","33542520.04","sell",1050346],
            ["1592757480204","0.00013538","33542505.0","sell",1050338],
            ["1592756746977","0.00055265","33971985.0","buy",1050333],
            ["1592755514177","0.00008515","33542024.04","sell",1050317],
            ["1592754923871","0.002559","33971985.0","buy",1050308],
            ["1592752135629","0.01407347","33971985.0","buy",1050272],
            ["1592752135629","0.00029695","33971984.0","buy",1050271]
        ]';

        if ($limit === 5) {
            $entries = '[
                ["1592763501284","0.00035029","33969985.0","buy",1050379],
                ["1592763085557","0.0062085","33542711.0","sell",1050370],
                ["1592758811991","0.00287978","33969990.0","buy",1050350],
                ["1592758175163","0.00906818","33542520.04","sell",1050346],
                ["1592757480204","0.00013538","33542505.0","sell",1050338]
            ]';
        }

        $timestamp = $timestamp === 0 ? 'null' : $timestamp;

        $data = '{
            "trades":{
                "market_id":"'.strtoupper($market).'",
                "timestamp":'.$timestamp.',
                "last_timestamp":"1592695826202",
                "entries":'.$entries.'
            }
        }';

        return new TradeResponse('200', $data);
    }

    /**
     * @param string $currency
     * @param string $transactionType
     * @return FeeResponse
     * @throws BudaException
     */
    public function getFees(string $currency, string $transactionType): FeeResponse
    {
        if (! in_array($transactionType, [TransactionTypes::DEPOSIT, TransactionTypes::WITHDRAWAL])) {
            throw new BudaException('Transaction type: '.$transactionType.' is not allowed!');
        }

        if ($currency === 'fail-currency') {
            throw new BudaException('{"message":"Not found","code":"not_found"}');
        }

        $currency = strtoupper($currency);

        $data = '{
            "fee": {
                "currency": "'.$currency.'",
                "name": "'.$transactionType.'",
                "percent": 0,
                "base": ["4200.0","'.$currency.'"]
            }
        }';

        return new FeeResponse('200', $data);
    }

    /**
     * @param string $market
     * @param string $state
     * @return OrderResponse
     * @throws AuthenticationException
     * @throws BudaException
     */
    public function getOrders(string $market, string $state = ''): OrderResponse
    {
        MarketValidator::validate($market);

        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        $path = $this->baseUrl.'markets/'.$market.'/orders.'.$this->format;

        $this->authenticator->authenticate('GET', $path);

        $data = '{
                "orders":[
                    {
                        "id":31051262,
                        "market_id":"BTC-COP",
                        "account_id":152485,
                        "type":"Ask",
                        "state":"traded",
                        "created_at":"2020-06-04T18:36:26.000Z",
                        "fee_currency":"COP",
                        "price_type":"limit",
                        "source":null,
                        "limit":["34598930.0","COP"],
                        "amount":["0.0","BTC"],
                        "original_amount":["0.02982682","BTC"],
                        "traded_amount":["0.02982682","BTC"],
                        "total_exchanged":["1031976.06","COP"],
                        "paid_fee":["4127.9","COP"]
                    }
                ]
            }';

        return new OrderResponse('200', $data);
    }

    /**
     * @param string $currency
     * @return BalanceResponse
     * @throws AuthenticationException
     * @throws BudaException
     */
    public function getBalances(string $currency = ''): BalanceResponse
    {
        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        if ($currency === 'fail-currency') {
            throw new BudaException('{"message":"Not found","code":"not_found"}');
        }

        $path = 'balances';

        if ($currency) {
            $path .= '/'.$currency;
        }

        $path .= '.'.$this->format;

        $this->authenticator->authenticate('GET', $this->baseUrl.$path);

        $data = '{
            "balances":[
                {
                    "id":"BTC",
                    "amount":["0.0","BTC"],
                    "available_amount":["0.0","BTC"],
                    "frozen_amount":["0.0","BTC"],
                    "pending_withdraw_amount":["0.0","BTC"],
                    "account_id":152485
                }
            ]
        }';

        if ($currency === 'cop') {
            $data = '{
                "balances":[
                    {
                        "id":"COP",
                        "amount":["0.0","COP"],
                        "available_amount":["0.0","COP"],
                        "frozen_amount":["0.0","COP"],
                        "pending_withdraw_amount":["0.0","COP"],
                        "account_id":152485
                    }
                ]
            }';
        }

        return new BalanceResponse('200', $data);
    }

    /**
     * @param string $orderId
     * @return OrderResponse
     * @throws AuthenticationException
     * @throws BudaException
     */
    public function getOrderDetail(string $orderId): OrderResponse
    {
        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        if ($orderId === 'fail-order') {
            throw new BudaException('{"message":"Not found","code":"not_found"}');
        }

        $path = 'orders/'.$orderId.$this->format;

        $this->authenticator->authenticate('GET', $path);

        $data = '{
                "order": {
                        "id":555555,
                        "market_id":"BTC-COP",
                        "account_id":444444,
                        "type":"Ask",
                        "state":"traded",
                        "created_at":"2020-06-04T18:36:26.000Z",
                        "fee_currency":"COP",
                        "price_type":"limit",
                        "source":null,
                        "limit":["34598930.0","COP"],
                        "amount":["0.0","BTC"],
                        "original_amount":["0.02982682","BTC"],
                        "traded_amount":["0.02982682","BTC"],
                        "total_exchanged":["1031976.06","COP"],
                        "paid_fee":["4127.9","COP"]
                    }                
                }';

        return new OrderResponse('200', $data);
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

            $data = '{
                "order":{
                    "id":999999,
                    "market_id":"BTC-COP",
                    "account_id":888888,
                    "type":"Bid",
                    "state":"received",
                    "created_at":"2020-06-29T16:30:52.821Z",
                    "fee_currency":"BTC",
                    "price_type":"limit",
                    "source":null,
                    "limit":["100.0","COP"],
                    "amount":["0.0001","BTC"],
                    "original_amount":["0.0001","BTC"],
                    "traded_amount":["0.0","BTC"],
                    "total_exchanged":["0.0","COP"],
                    "paid_fee":["0.0","BTC"]
                }
            }';

            return new OrderResponse('200', $data);
        } catch (ClientException $exception) {
            throw new BudaException($exception);
        }
    }

    /**
     * @param string $orderId
     * @return OrderResponse
     * @throws AuthenticationException
     */
    public function cancelOrder(string $orderId): OrderResponse
    {
        if (! $this->authenticator) {
            throw AuthenticationException::credentialsNotSet();
        }

        if ($orderId === 'fail-order') {
            throw new BudaException('{"message":"Not found","code":"not_found"}');
        }

        $path = 'orders/'.$orderId;

        $params = [
            'state' => 'canceling',
        ];

        $this->authenticator->authenticate('PUT', $this->baseUrl.$path, $params);

        $data = '{
                "order":{
                    "id":999999,
                    "market_id":"BTC-COP",
                    "account_id":888888,
                    "type":"Bid",
                    "state":"canceling",
                    "created_at":"2020-06-29T16:30:52.821Z",
                    "fee_currency":"BTC",
                    "price_type":"limit",
                    "source":null,
                    "limit":["100.0","COP"],
                    "amount":["0.0001","BTC"],
                    "original_amount":["0.0001","BTC"],
                    "traded_amount":["0.0","BTC"],
                    "total_exchanged":["0.0","COP"],
                    "paid_fee":["0.0","BTC"]
                }
            }';

        return new OrderResponse('200', $data);
    }
}
