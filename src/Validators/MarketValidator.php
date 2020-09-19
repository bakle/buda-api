<?php

namespace Bakle\Buda\Validators;

use Bakle\Buda\Constants\Markets;
use Bakle\Buda\Exceptions\BudaException;

class MarketValidator
{
    public static function validate(string $market)
    {
        if (! in_array($market, Markets::toArray())) {
            BudaException::forInvalidMarket($market);
        }
    }
}
