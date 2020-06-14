<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class MarketTest extends TestCase
{
    /** @test */
    public function itCanGetSpecificMarket(): void
    {
        $buda = new BudaMock();

        $response = $buda->getMarket('eth-btc');

        $this->assertEquals('ETH-BTC', $response->data()->id());
        $this->assertEquals(['0.02537093', 'BTC'], $response->data()->lastPrice());
        $this->assertEquals(['0.02518027', 'BTC'], $response->data()->minAsk());
        $this->assertEquals(['0.02485485', 'BTC'], $response->data()->maxBid());
        $this->assertEquals(['0.0', 'ETH'], $response->data()->volume());
        $this->assertEquals('0.0', $response->data()->priceVariation24Hours());
        $this->assertEquals('0.003', $response->data()->priceVariation7Days());
    }

    /** @test */
    public function itFailsGettingWrongMarket(): void
    {
        $this->expectException(BudaException::class);

        $buda = new BudaMock();

        $buda->getMarket('fail-market');
    }
}
