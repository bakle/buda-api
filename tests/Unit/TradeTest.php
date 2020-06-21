<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class TradeTest extends TestCase
{
    /** @test */
    public function itCanGetTradesWithDefaultParams(): void
    {
        $buda = new BudaMock();

        $response = $buda->getTrades('btc-cop');

        $this->assertEquals('BTC-COP', $response->data()->id());
        $this->assertNull($response->data()->timestamp());
        $this->assertEquals('1592695826202', $response->data()->lastTimestamp());
        $this->assertCount(10, $response->data()->entries());
    }

    public function itCanGetTradesWithSpecificParams(): void
    {
        $buda = new BudaMock();

        $response = $buda->getTrades('btc-cop', 5, 9999);

        $this->assertEquals('BTC-COP', $response->data()->id());
        $this->assertEquals('9999', $response->data()->timestamp());
        $this->assertEquals('1592695826202', $response->data()->lastTimestamp());
        $this->assertCount(5, $response->data()->entries());
    }

    /** @test */
    public function itFailsGettingMTrades(): void
    {
        $this->expectException(BudaException::class);

        $buda = new BudaMock();

        $buda->getTrades('fail-market');
    }
}
