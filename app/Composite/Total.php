<?php

namespace  App\Composite;

use App\Contracts\BillInterface;
use App\ValueObjects\Price;

class Total implements BillInterface
{
    /**
     * @var float
     */
    private Price $price;


    /**
     * @var string
     */
    private string $currency;

    /**
     * Total constructor.
     * @param Price $price
     */
    public function __construct(Price $price)
    {
        $this->price =$price;
    }

    /**
     * @return string
     */

    public function print(): string
    {
        return 'Total: '. $this->price->getCurrency(). $this->price->getAmount() . PHP_EOL;
    }
}
