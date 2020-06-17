<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\Market;

class MarketResponse extends Response
{
    /**
     * @param string $data
     */
    protected function setData(string $data): void
    {
        $decodedData = json_decode($data);

        property_exists($decodedData, 'markets') ? $this->setMultipleMarkets($decodedData->markets)
            : $this->setSingleMarket($decodedData->market);
    }

    /**
     * @param array $markets
     */
    private function setMultipleMarkets(array $markets): void
    {
        foreach ($markets as $market) {
            $this->data[] = new Market($market);
        }
    }

    /**
     * @param object $market
     */
    private function setSingleMarket(object $market): void
    {
        $this->data = new Market($market);
    }
}
