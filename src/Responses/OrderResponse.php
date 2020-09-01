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
        $decodeData = json_decode($data);

        property_exists($decodeData, 'orders') ? $this->setMultipleOrders($decodeData->orders)
            : $this->setOrder($decodeData->order);
    }

    /**
     * @param array $orders
     */
    private function setMultipleOrders(array $orders): void
    {
        $this->data = [];
        foreach ($orders as $order) {
            $this->data[] = new Order($order);
        }
    }

    /**
     * @param object $order
     * @throws \Exception
     */
    private function setOrder(object $order): void
    {
        $this->data = new Order($order);
    }
}
