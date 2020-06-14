<?php

namespace Bakle\Buda\Tests\Mocks;

use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Responses\MarketResponse;

class BudaMock
{
    /**
     * @param string $market
     * @return MarketResponse
     * @throws BudaException
     */
    public function getTickerMarket(string $market): MarketResponse
    {
        if ($market === 'fail-market') {
            throw new BudaException('{"message":"Not found","code":"not_found"}');
        }

        $market = strtoupper($market);
        $data = '{"ticker":{"market_id":"'.$market.'","last_price":["0.02537093","BTC"],"min_ask":["0.02518027","BTC"],"max_bid":["0.02485485","BTC"],"volume":["0.0","ETH"],"price_variation_24h":"0.0","price_variation_7d":"0.003"}}';

        return new MarketResponse('200', $data);
    }
}
