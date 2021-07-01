<?php

namespace  App\Composite;

use App\Contracts\BillInterface;

class DiscountBag implements BillInterface
{
    private string $messages;

    /**
     * Total constructor.
     * @param $messages
     */
    public function __construct(string $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return string
     */
    public function print(): string
    {
        return $this->messages ? 'Discounts:'."\t".PHP_EOL. $this->messages : '';
    }
}
