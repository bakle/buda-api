<?php

namespace Bakle\Buda\Entities;

use Bakle\Buda\Contracts\EntityContract;
use DateTime;

class Order implements EntityContract
{
    /** @var string */
    private $id;

    /** @var string */
    private $marketId;

    /** @var string */
    private $accountId;

    /** @var string */
    private $type;

    /** @var string */
    private $state;

    /** @var DateTime */
    private $createdAt;

    /** @var string */
    private $feeCurrency;

    /** @var string */
    private $priceType;

    /** @var string|null */
    private $source;

    /** @var array */
    private $limit;

    /** @var array */
    private $amount;

    /** @var array */
    private $originalAmount;

    /** @var array */
    private $tradedAmount;

    /** @var array */
    private $totalExchanged;

    /** @var array */
    private $paidFee;

    /**
     * MarketVolume constructor.
     * @param object $data
     * @throws \Exception
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->marketId = $data->market_id;
        $this->accountId = $data->account_id;
        $this->type = $data->type;
        $this->state = $data->state;
        $this->createdAt = new DateTime($data->created_at);
        $this->feeCurrency = $data->fee_currency;
        $this->priceType = $data->price_type;
        $this->source = $data->source;
        $this->limit = $data->limit;
        $this->amount = $data->amount;
        $this->originalAmount = $data->original_amount;
        $this->tradedAmount = $data->traded_amount;
        $this->totalExchanged = $data->total_exchanged;
        $this->paidFee = $data->paid_fee;
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
    public function marketId(): string
    {
        return $this->marketId;
    }

    /**
     * @return string
     */
    public function accountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function state(): string
    {
        return $this->state;
    }

    /**
     * @return DateTime
     */
    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function feeCurrency(): string
    {
        return $this->feeCurrency;
    }

    /**
     * @return string
     */
    public function priceType(): string
    {
        return $this->priceType;
    }

    /**
     * @return string|null
     */
    public function source(): ?string
    {
        return $this->source;
    }

    /**
     * @return array
     */
    public function limit(): array
    {
        return $this->limit;
    }

    /**
     * @return array
     */
    public function amount(): array
    {
        return $this->amount;
    }

    /**
     * @return array
     */
    public function originalAmount(): array
    {
        return $this->originalAmount;
    }

    /**
     * @return array
     */
    public function tradedAmount(): array
    {
        return $this->tradedAmount;
    }

    /**
     * @return array
     */
    public function totalExchanged(): array
    {
        return $this->totalExchanged;
    }

    /**
     * @return array
     */
    public function paidFee(): array
    {
        return $this->paidFee;
    }
}
