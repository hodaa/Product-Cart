<?php

namespace  App\Composite;

use App\Contracts\BillInterface;
use App\ValueObjects\Price;

class SubTotal implements BillInterface
{
    /**
     * @var float
     */
    private Price $price;


    /**
     * Total constructor.
     * @param Price $price
     */
    public function __construct(Price $price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function print(): string
    {
        return 'Subtotal: '. $this->price->getCurrency(). $this->price->getAmount() . PHP_EOL;
    }
}
