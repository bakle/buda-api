<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\Order;

class OrderResponse extends Response
{
    /**
     * @param string $data
     */
    protected function setData(string $data): void
    {
        $this->setMultipleOrders(json_decode($data)->orders);
    }

    /**
     * @param array $orders
     */
    private function setMultipleOrders(array $orders): void
    {
        foreach ($orders as $order) {
            $this->data[] = new Order($order);
        }
    }
}
