<?php

namespace Bakle\Buda\Responses;

use Bakle\Buda\Entities\Fee;

class FeeResponse extends Response
{
    /**
     * @param string $data
     */
    protected function setData(string $data): void
    {
        $this->data = new Fee(json_decode($data)->fee);
    }
}
