<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Constants\ResponseStatuses;
use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class OrderBookTest extends TestCase
{
    /** @test */
    public function itCanGetOrdersBook(): void
    {
        $buda = new BudaMock();

        $response = $buda->getOrdersBook('btc-cop');

        $this->assertEquals('BTC-COP', $response->data()->id());
        $this->assertEquals([['836677.14', '0.447349']], $response->data()->asks());
        $this->assertEquals([['821580.0', '0.25667389']], $response->data()->bids());
    }

    /** @test */
    public function itFailsGettingOrdersBook(): void
    {
        $buda = new BudaMock();

        $this->expectException(BudaException::class);
        $this->expectExceptionCode(ResponseStatuses::STATUS_CODES[ResponseStatuses::UNPROCESSABLE_ENTITY]);

        $buda->getOrdersBook('fail-market');
    }
}
