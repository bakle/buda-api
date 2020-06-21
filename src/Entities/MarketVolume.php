<?php

namespace Bakle\Buda\Entities;

use Bakle\Buda\Contracts\EntityContract;

class MarketVolume implements EntityContract
{
    /** @var string */
    private $id;

    /** @var array */
    private $bidVolume24Hours;

    /** @var array */
    private $askVolume24Hours;

    /** @var array */
    private $bidVolume7Days;

    /** @var array */
    private $askVolume7Days;

    /**
     * MarketVolume constructor.
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->market_id;
        $this->bidVolume24Hours = $data->bid_volume_24h;
        $this->askVolume24Hours = $data->ask_volume_24h;
        $this->bidVolume7Days = $data->bid_volume_7d;
        $this->askVolume7Days = $data->ask_volume_7d;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function bidVolume24Hours(): array
    {
        return $this->bidVolume24Hours;
    }

    /**
     * @return string
     */
    public function askVolume24Hours(): array
    {
        return $this->askVolume24Hours;
    }

    /**
     * @return string
     */
    public function bidVolume7Days(): array
    {
        return $this->bidVolume7Days;
    }

    /**
     * @return string
     */
    public function askVolume7Days(): array
    {
        return $this->askVolume7Days;
    }
}
