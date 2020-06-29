<?php

namespace Bakle\Buda\Entities;

use Bakle\Buda\Contracts\EntityContract;
use Exception;

class Balance implements EntityContract
{
    /** @var string */
    private $id;

    /** @var array */
    private $amount;

    /** @var array */
    private $availableAmount;

    /** @var array */
    private $frozenAmount;

    /** @var array */
    private $pendingWithdrawAmount;

    /** @var string */
    private $accountId;

    /**
     * MarketVolume constructor.
     * @param object $data
     * @throws Exception
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->amount = $data->amount;
        $this->availableAmount = $data->available_amount;
        $this->frozenAmount = $data->frozen_amount;
        $this->pendingWithdrawAmount = $data->pending_withdraw_amount;
        $this->accountId = $data->account_id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return array
     */
    public function availableAmount(): array
    {
        return $this->availableAmount;
    }

    /**
     * @return array
     */
    public function frozenAmount(): array
    {
        return $this->frozenAmount;
    }

    /**
     * @return array
     */
    public function pendingWithdrawAmount(): array
    {
        return $this->pendingWithdrawAmount;
    }

    /**
     * @return string
     */
    public function accountId(): string
    {
        return $this->accountId;
    }
}
