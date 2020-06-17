<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class MarketVolumeTest extends TestCase
{
    /** @test */
    public function itCanGetMarketVolume(): void
    {
        $buda = new BudaMock();

        $response = $buda->getMarketVolume('btc-cop');

        $this->assertEquals('BTC-COP', $response->data()->id());
        $this->assertEquals(['5.02389055', 'BTC'], $response->data()->bidVolume24Hours());
        $this->assertEquals(['4.40828336', 'BTC'], $response->data()->askVolume24Hours());
        $this->assertEquals(['42.4818546', 'BTC'], $response->data()->bidVolume7Days());
        $this->assertEquals(['45.6118442', 'BTC'], $response->data()->askVolume7Days());
    }

    /** @test */
    public function itFailsGettingMarketVolume(): void
    {
        $this->expectException(BudaException::class);

        $buda = new BudaMock();

        $buda->getTickerMarket('fail-market');
    }
}
