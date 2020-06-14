<?php

namespace Bakle\Buda\Constants;

class ResponseStatuses
{
    public const SUCCESSFUL = 'successful';
    public const NOT_FOUND = 'not_found';

    public const STATUS_CODES = [
        self::SUCCESSFUL => '200',
        self::NOT_FOUND => '404',
    ];
}
