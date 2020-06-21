<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\MarketVolume;

class MarketVolumeResponse extends Response
{
    /**
     * @param string $data
     */
    protected function setData(string $data): void
    {
        $this->data = new MarketVolume(json_decode($data)->volume);
    }
}
