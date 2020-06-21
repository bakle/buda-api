<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\Trade;

class TradeResponse extends Response
{
    /**
     * @param string $data
     */
    protected function setData(string $data): void
    {
        $this->data = new Trade(json_decode($data)->trades);
    }
}
