<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Exceptions\AuthenticationException;
use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /** @var string */
    private $apiKey;

    /** @var string */
    private $secretKey;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiKey = '1dbffe5b28c6092a51dacbfe33b47090';
        $this->secretKey = 'xUsEUx4bwREPVIVwJZyaHAHeU+PYso3ZpqvRpcmb';
    }

    /** @test */
    public function itCanGetOrders(): void
    {
        $buda = new BudaMock();
        $buda->setCredentials($this->apiKey, $this->secretKey);
        $response = $buda->getOrders('btc-cop');

        foreach ($response->data() as $data) {
            $this->assertEquals('31051262', $data->id());
            $this->assertEquals('BTC-COP', $data->marketId());
            $this->assertEquals('152485', $data->accountId());
            $this->assertEquals('Ask', $data->type());
            $this->assertEquals('traded', $data->state());
            $this->assertEquals('2020-06-04 18:36:26', $data->createdAt()->format('Y-m-d H:i:s'));
            $this->assertEquals('COP', $data->feeCurrency());
            $this->assertEquals('limit', $data->priceType());
            $this->assertNull($data->source());
            $this->assertEquals(['0.0', 'BTC'], $data->amount());
            $this->assertEquals(['0.02982682', 'BTC'], $data->originalAmount());
            $this->assertEquals(['0.02982682', 'BTC'], $data->tradedAmount());
            $this->assertEquals(['1031976.06', 'COP'], $data->totalExchanged());
            $this->assertEquals(['4127.9', 'COP'], $data->paidFee());
        }
    }

    /** @test */
    public function itFailsGettingOrdersIfUnauthenticated(): void
    {
        $this->expectException(AuthenticationException::class);

        $buda = new BudaMock();

        $buda->getOrders('btc-cop');
    }

    /** @test */
    public function itFailsGettingOrders(): void
    {
        $this->expectException(BudaException::class);

        $buda = new BudaMock();
        $buda->setCredentials($this->apiKey, $this->secretKey);

        $buda->getOrders('fail-market');
    }
}
