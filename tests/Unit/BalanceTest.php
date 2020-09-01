<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Exceptions\AuthenticationException;
use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class BalanceTest extends TestCase
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
    public function itCanGetBalances(): void
    {
        $buda = new BudaMock();
        $buda->setCredentials($this->apiKey, $this->secretKey);
        $response = $buda->getBalances();

        foreach ($response->data() as $data) {
            $this->assertEquals('BTC', $data->id());
            $this->assertEquals(['0.0', 'BTC'], $data->amount());
            $this->assertEquals(['0.0', 'BTC'], $data->availableAmount());
            $this->assertEquals(['0.0', 'BTC'], $data->frozenAmount());
            $this->assertEquals(['0.0', 'BTC'], $data->pendingWithdrawAmount());
            $this->assertEquals('152485', $data->accountId());
        }
    }

    /** @test */
    public function itCanGetBalancesWithSpecificCurrency(): void
    {
        $buda = new BudaMock();
        $buda->setCredentials($this->apiKey, $this->secretKey);
        $response = $buda->getBalances('cop');

        foreach ($response->data() as $data) {
            $this->assertEquals('COP', $data->id());
            $this->assertEquals(['0.0', 'COP'], $data->amount());
            $this->assertEquals(['0.0', 'COP'], $data->availableAmount());
            $this->assertEquals(['0.0', 'COP'], $data->frozenAmount());
            $this->assertEquals(['0.0', 'COP'], $data->pendingWithdrawAmount());
            $this->assertEquals('152485', $data->accountId());
        }
    }

    /** @test */
    public function itFailsGettingBalancesIfUnauthenticated(): void
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

        $buda->getBalances('fail-currency');
    }
}
