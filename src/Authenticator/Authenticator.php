<?php

namespace Bakle\Buda\Authenticator;

class Authenticator
{
    /** @var string */
    private $apiKey;

    /** @var string */
    private $secretKey;

    /** @var int */
    private $nonce;

    /** @var string */
    private $signature;

    /**
     * Authenticator constructor.
     * @param string $apiKey
     * @param string $secretKey
     */
    public function __construct(string $apiKey, string $secretKey)
    {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $params
     */
    public function authenticate(string $method, string $path, array $params = [])
    {
        $encodedBody = count($params) ? base64_encode(json_encode($params)) : '';

        $this->nonce = time();

        $authenticationString = $this->getAuthenticationString($method, $path, $encodedBody);

        $this->signature = hash_hmac('SHA384', $authenticationString, $this->secretKey);
    }

    /**
     * @return array
     */
    public function authenticationData(): array
    {
        return [
            'X-SBTC-APIKEY' => $this->apiKey,
            'X-SBTC-NONCE' => $this->nonce,
            'X-SBTC-SIGNATURE' => $this->signature,
        ];
    }

    /**
     * @param string $method
     * @param string $path
     * @param string $encodedBody
     * @return string
     */
    private function getAuthenticationString(string $method, string $path, string $encodedBody): string
    {
        return $encodedBody !== '' ? sprintf('%s %s %s %s', $method, $path, $encodedBody, $this->nonce)
            : sprintf('%s %s %s', $method, $path, $this->nonce);
    }
}
