<?php

namespace Bakle\Buda\Entities;

use Bakle\Buda\Contracts\EntityContract;

class Market implements EntityContract
{
    /** @var string */
    private $id;

    /** @var array */
    private $lastPrice;

    /** @var array */
    private $minAsk;

    /** @var array */
    private $maxBid;

    /** @var array */
    private $volume;

    /** @var string */
    private $priceVariation24Hours;

    /** @var string */
    private $priceVariation7Days;

    /**
     * Market constructor.
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->market_id;
        $this->lastPrice = $data->last_price ?? '';
        $this->minAsk = $data->min_ask ?? '';
        $this->maxBid = $data->max_bid ?? '';
        $this->volume = $data->volume ?? '';
        $this->priceVariation24Hours = $data->price_variation_24h ?? '';
        $this->priceVariation7Days = $data->price_variation_7d ?? '';
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
    public function lastPrice(): array
    {
        return $this->lastPrice;
    }

    /**
     * @return array
     */
    public function minAsk(): array
    {
        return $this->minAsk;
    }

    /**
     * @return array
     */
    public function maxBid(): array
    {
        return $this->maxBid;
    }

    /**
     * @return array
     */
    public function volume(): array
    {
        return $this->volume;
    }

    /**
     * @return string
     */
    public function priceVariation24Hours(): string
    {
        return $this->priceVariation24Hours;
    }

    /**
     * @return string
     */
    public function priceVariation7Days(): string
    {
        return $this->priceVariation7Days;
    }
}
