<?php

namespace Bakle\Buda\Entities;

use Bakle\Buda\Contracts\EntityContract;

class Trade implements EntityContract
{
    /** @var string */
    private $id;

    /** @var string|null */
    private $timestamp;

    /** @var string */
    private $lastTimestamp;

    /** @var array */
    private $entries;

    /**
     * MarketVolume constructor.
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->market_id;
        $this->timestamp = $data->timestamp;
        $this->lastTimestamp = $data->last_timestamp;
        $this->entries = $data->entries;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function timestamp(): ?string
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function lastTimestamp(): string
    {
        return $this->lastTimestamp;
    }

    /**
     * @return array
     */
    public function entries(): array
    {
        return $this->entries;
    }
}
