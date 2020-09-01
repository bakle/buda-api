<?php

namespace Bakle\Buda\Exceptions;

use Exception;

class AuthenticationException extends Exception
{
    public static function credentialsNotSet(): self
    {
        return new self('{"message":"Authentication credentials not set","code":"credentials_not_set"}');
    }
}
