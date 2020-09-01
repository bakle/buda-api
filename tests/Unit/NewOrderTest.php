<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Exceptions\AuthenticationException;
use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class NewOrderTest extends TestCase
{
    /** @var string */
    private $apiKey;

    /** @var string */
    private $secretKey;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiKey = 'api-test';
        $this->secretKey = 'secret-test';
    }

    /** @test */
    public function itCanPlaceANewOrder(): void
    {
        $buda = new BudaMock();
        $buda->setCredentials($this->apiKey, $this->secretKey);
        $response = $buda->newOrder('btc-cop', 'Bid', 'limit', '0.0001', '100');

        $this->assertEquals('999999', $response->data()->id());
        $this->assertEquals('BTC-COP', $response->data()->marketId());
        $this->assertEquals('888888', $response->data()->accountId());
        $this->assertEquals('Bid', $response->data()->type());
        $this->assertEquals('received', $response->data()->state());
        $this->assertEquals('2020-06-29 16:30:52', $response->data()->createdAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('BTC', $response->data()->feeCurrency());
        $this->assertEquals('limit', $response->data()->priceType());
        $this->assertNull($response->data()->source());
        $this->assertEquals(['100.0', 'COP'], $response->data()->limit());
        $this->assertEquals(['0.0001', 'BTC'], $response->data()->amount());
        $this->assertEquals(['0.0001', 'BTC'], $response->data()->originalAmount());
        $this->assertEquals(['0.0', 'BTC'], $response->data()->tradedAmount());
        $this->assertEquals(['0.0', 'COP'], $response->data()->totalExchanged());
        $this->assertEquals(['0.0', 'BTC'], $response->data()->paidFee());
    }

    /** @test */
    public function itFailsPlacingANewOrderIfUnauthenticated(): void
    {
        $this->expectException(AuthenticationException::class);

        $buda = new BudaMock();

        $buda->newOrder('btc-cop', 'Bid', 'limit', '0.0001', '100');
    }

    /** @test */
    public function itFailsPlacingANewOrder(): void
    {
        $this->expectException(BudaException::class);

        $buda = new BudaMock();
        $buda->setCredentials($this->apiKey, $this->secretKey);

        $buda->newOrder('fail-market', 'Bid', 'limit', '0.0001', '100');
    }
}
