<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class MarketTest extends TestCase
{
    /** @test */
    public function itCanGetMarkets(): void
    {
        $buda = new BudaMock();

        $response = $buda->getMarkets();

        foreach ($response->data() as $data) {
            $this->assertTrue(in_array($data->id(), ['BTC-CLP', 'BTC-COP']));
            $this->assertTrue(in_array($data->name(), ['btc-clp', 'btc-cop']));
            $this->assertTrue(in_array($data->baseCurrency(), ['BTC']));
            $this->assertTrue(in_array($data->quoteCurrency(), ['CLP', 'COP']));
            $this->assertTrue(in_array($data->minimumOrderAmount(), [['0.00002', 'BTC']]));
            $this->assertFalse($data->disabled());
            $this->assertFalse($data->illiquid());
        }
    }

    /** @test */
    public function itCanGetSpecificMarket(): void
    {
        $buda = new BudaMock();

        $response = $buda->getMarket('btc-cop');

        $this->assertEquals('BTC-COP', $response->data()->id());
        $this->assertEquals('btc-cop', $response->data()->name());
        $this->assertEquals('BTC', $response->data()->baseCurrency());
        $this->assertEquals('COP', $response->data()->quoteCurrency());
        $this->assertEquals(['0.00002', 'BTC'], $response->data()->minimumOrderAmount());
        $this->assertFalse($response->data()->disabled());
        $this->assertFalse($response->data()->illiquid());
    }
}
