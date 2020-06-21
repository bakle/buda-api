<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Constants\ResponseStatuses;
use Bakle\Buda\Contracts\EntityContract;

abstract class Response
{
    /** @var string */
    protected $status;

    /** @var EntityContract|array */
    protected $data;

    /**
     * Response constructor.
     * @param string $statusCode
     * @param string $data
     */
    public function __construct(string $statusCode, string $data)
    {
        $this->setStatus($statusCode);

        $this->setData($data);
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }

    public function data()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->status === ResponseStatuses::STATUS_CODES[ResponseStatuses::SUCCESSFUL];
    }

    /**
     * @param string $statusCode
     */
    private function setStatus(string $statusCode): void
    {
        $this->status = $statusCode;
    }

    /**
     * @param string $data
     */
    abstract protected function setData(string $data): void;
}
