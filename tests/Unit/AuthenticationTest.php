<?php

namespace Bakle\Buda\Tests\Unit;

use Bakle\Buda\Tests\Mocks\AuthenticatorMock;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    /** @test */
    public function itDoesNotGenerateCorrectSignature(): void
    {
        $apiKey = 'abcdef123';
        $secretKey = 'ab12cd34';
        $authenticator = new AuthenticatorMock($apiKey, $secretKey);

        $authenticator->authenticate('GET', '/api/v1/orders?open=true');

        $this->assertEquals('abcdef123', $authenticator->authenticationData()['X-SBTC-APIKEY']);
        $this->assertNotEquals('abcde12345', $authenticator->authenticationData()['X-SBTC-SIGNATURE']);
    }

    /** @test */
    public function itGeneratesCorrectSignature(): void
    {
        $apiKey = 'api-test';
        $secretKey = 'secret-test';
        $authenticator = new AuthenticatorMock($apiKey, $secretKey);

        $authenticator->authenticate('GET', '/api/v1/orders?open=true');

        $this->assertEquals('api-test', $authenticator->authenticationData()['X-SBTC-APIKEY']);
        $this->assertEquals('abcde12345', $authenticator->authenticationData()['X-SBTC-SIGNATURE']);
    }
}
