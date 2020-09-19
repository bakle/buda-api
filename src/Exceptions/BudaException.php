<?php

namespace Bakle\Buda\Exceptions;

use Bakle\Buda\Constants\ResponseStatuses;
use Exception;

class BudaException extends Exception
{
    public static function forInvalidMarket(string $market)
    {
        throw new self(json_encode([
            'code' => ResponseStatuses::UNPROCESSABLE_ENTITY,
            'message' => 'Invalid market',
        ]), ResponseStatuses::STATUS_CODES[ResponseStatuses::UNPROCESSABLE_ENTITY]);
    }
}
