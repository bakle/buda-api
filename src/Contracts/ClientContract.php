<?php

namespace Bakle\Buda\Contracts;

interface ClientContract
{
    public function get(string $endpoint, array $parameters, array $headers);

    public function post(string $endpoint, array $parameters, array $headers);
}
