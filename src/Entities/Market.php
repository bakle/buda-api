<?php

namespace Bakle\Buda\Entities;

use Bakle\Buda\Contracts\EntityContract;

class Market implements EntityContract
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $baseCurrency;

    /** @var string */
    private $quoteCurrency;

    /** @var array */
    private $minimumOrderAmount;

    /** @var bool */
    private $disabled;

    /** @var bool */
    private $illiquid;

    /**
     * Market constructor.
     * @param object $market
     */
    public function __construct(object $market)
    {
        $this->id = $market->id;
        $this->name = $market->name;
        $this->baseCurrency = $market->base_currency;
        $this->quoteCurrency = $market->quote_currency;
        $this->minimumOrderAmount = $market->minimum_order_amount;
        $this->disabled = $market->disabled;
        $this->illiquid = $market->illiquid;
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
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function baseCurrency(): string
    {
        return $this->baseCurrency;
    }

    /**
     * @return string
     */
    public function quoteCurrency(): string
    {
        return $this->quoteCurrency;
    }

    /**
     * @return array
     */
    public function minimumOrderAmount(): array
    {
        return $this->minimumOrderAmount;
    }

    /**
     * @return bool
     */
    public function disabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @return bool
     */
    public function illiquid(): bool
    {
        return $this->illiquid;
    }
}
