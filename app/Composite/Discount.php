<?php

namespace  App\Composite;

use App\Contracts\BillInterface;

class Discount implements BillInterface
{

    /**
     * @var string
     */
    private string $message;

    /**
     * Total constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function print(): string
    {
        return $this->message . PHP_EOL;
    }
}
