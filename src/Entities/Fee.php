<?php

namespace Bakle\Buda\Entities;

use Bakle\Buda\Contracts\EntityContract;

class Fee implements EntityContract
{
    /** @var string */
    private $currency;

    /** @var string */
    private $transactionType;

    /** @var int */
    private $percent;

    /** @var array */
    private $base;

    /**
     * MarketVolume constructor.
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->currency = $data->currency;
        $this->transactionType = $data->name;
        $this->percent = $data->percent;
        $this->base = $data->base;
    }

    /**
     * @return string
     */
    public function currency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function transactionType(): string
    {
        return $this->transactionType;
    }

    /**
     * @return int
     */
    public function percent(): int
    {
        return $this->percent;
    }

    /**
     * @return array
     */
    public function base(): array
    {
        return $this->base;
    }
}
