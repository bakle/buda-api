<?php

namespace Bakle\Buda\Tests\Mocks;

use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Responses\MarketResponse;
use Bakle\Buda\Responses\MarketVolumeResponse;
use Bakle\Buda\Responses\TickerMarketResponse;
use GuzzleHttp\Exception\ClientException;

class BudaMock
{
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

    public function getMarketVolume(string $market): MarketVolumeResponse
    {
        if ($market === 'fail-market') {
            throw new BudaException('{"message":"Not found","code":"not_found"}');
        }

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
        if ($market === 'fail-market') {
            throw new BudaException('{"message":"Not found","code":"not_found"}');
        }

        $market = strtoupper($market);
        $data = '{"ticker":{"market_id":"'.$market.'","last_price":["0.02537093","BTC"],"min_ask":["0.02518027","BTC"],"max_bid":["0.02485485","BTC"],"volume":["0.0","ETH"],"price_variation_24h":"0.0","price_variation_7d":"0.003"}}';

        return new TickerMarketResponse('200', $data);
    }
}
