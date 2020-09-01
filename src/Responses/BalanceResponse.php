<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\Balance;

class BalanceResponse extends Response
{
    /**
     * @param string $data
     */
    protected function setData(string $data): void
    {
        $this->setMultipleBalances(json_decode($data)->balances);
    }

    /**
     * @param array $balances
     */
    private function setMultipleBalances(array $balances): void
    {
        $this->data = [];
        foreach ($balances as $balance) {
            $this->data[] = new Balance($balance);
        }
    }
}
