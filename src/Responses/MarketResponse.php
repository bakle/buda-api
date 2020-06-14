<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\Market;

class MarketResponse extends Response
{
    protected function setData(string $data): void
    {
        $this->data = $data !== '' ? new Market(json_decode($data)->ticker) : null;
    }
}
