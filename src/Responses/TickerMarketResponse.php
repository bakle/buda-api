<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\TickerMarket;

class TickerMarketResponse extends Response
{
    protected function setData(string $data): void
    {
        $this->data = $data !== '' ? new TickerMarket(json_decode($data)->ticker) : null;
    }
}
