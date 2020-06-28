<?php

namespace Bakle\Buda\Entities;

use Bakle\Buda\Contracts\EntityContract;

class OrderBook implements EntityContract
{
    /** @var string */
    private $id;

    /** @var array */
    private $asks;

    /** @var array */
    private $bids;

    /**
     * MarketVolume constructor.
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->market_id;
        $this->asks = $data->asks;
        $this->bids = $data->bids;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function asks(): array
    {
        return $this->asks;
    }

    /**
     * @return array
     */
    public function bids(): array
    {
        return $this->bids;
    }
}
