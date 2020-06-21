<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Constants\TransactionTypes;
use Bakle\Buda\Exceptions\BudaException;
use Bakle\Buda\Tests\Mocks\BudaMock;
use PHPUnit\Framework\TestCase;

class FeeTest extends TestCase
{
    /** @test */
    public function itCanGetFees(): void
    {
        $buda = new BudaMock();

        $response = $buda->getFees('btc', TransactionTypes::DEPOSIT);

        $this->assertEquals('BTC', $response->data()->currency());
        $this->assertEquals(TransactionTypes::DEPOSIT, $response->data()->transactionType());
        $this->assertEquals(0, $response->data()->percent());
        $this->assertEquals(['4200.0', 'BTC'], $response->data()->base());
    }

    public function itFailsGettingFeesDueToIncorrectTransactionType(): void
    {
        $buda = new BudaMock();

        $this->expectException(BudaException::class);
        $this->expectExceptionMessage('Transaction type: test is not allowed!');

        $buda->getFees('btc', 'test');
    }

    /** @test */
    public function itFailsFees(): void
    {
        $this->expectException(BudaException::class);

        $buda = new BudaMock();

        $buda->getFees('fail-currency', TransactionTypes::WITHDRAWAL);
    }
}
