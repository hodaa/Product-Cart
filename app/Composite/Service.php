<?php

namespace  App\Composite;

use App\Contracts\BillInterface;

class Service implements BillInterface
{
    /**
     * @return string
     */
    public function print(): string
    {
        return 'Hi I am the service';
    }
}
