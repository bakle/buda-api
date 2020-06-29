<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Exceptions\AuthenticationException;
use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class OrderDetailTest extends TestCase
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
    public function itCanGetOrderDetail(): void
    {
        $buda = new BudaMock();
        $buda->setCredentials($this->apiKey, $this->secretKey);
        $response = $buda->getOrderDetail('555555');

        $this->assertEquals('555555', $response->data()->id());
        $this->assertEquals('BTC-COP', $response->data()->marketId());
        $this->assertEquals('444444', $response->data()->accountId());
        $this->assertEquals('Ask', $response->data()->type());
        $this->assertEquals('traded', $response->data()->state());
        $this->assertEquals('2020-06-04 18:36:26', $response->data()->createdAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('COP', $response->data()->feeCurrency());
        $this->assertEquals('limit', $response->data()->priceType());
        $this->assertNull($response->data()->source());
        $this->assertEquals(['0.0', 'BTC'], $response->data()->amount());
        $this->assertEquals(['0.02982682', 'BTC'], $response->data()->originalAmount());
        $this->assertEquals(['0.02982682', 'BTC'], $response->data()->tradedAmount());
        $this->assertEquals(['1031976.06', 'COP'], $response->data()->totalExchanged());
        $this->assertEquals(['4127.9', 'COP'], $response->data()->paidFee());
    }

    /** @test */
    public function itFailsGettingOrderDetailIfUnauthenticated(): void
    {
        $this->expectException(AuthenticationException::class);

        $buda = new BudaMock();

        $buda->getOrderDetail('555555');
    }

    /** @test */
    public function itFailsGettingOrderDetail(): void
    {
        $this->expectException(BudaException::class);

        $buda = new BudaMock();
        $buda->setCredentials($this->apiKey, $this->secretKey);

        $buda->getOrderDetail('fail-order');
    }
}
