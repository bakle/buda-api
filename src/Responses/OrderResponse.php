<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\OrderBook;

class OrderBookResponse extends Response
{
    /**
     * @param string $data
     */
    protected function setData(string $data): void
    {
        $this->data = new OrderBook(json_decode($data)->order_book);
    }
}
