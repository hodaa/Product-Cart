<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CartInterface
{
    /**
     * @return float
     */
    public function calculateSubTotal(): float;


    /**
     * @return array
     */
    public function calculateDiscounts(): array;


    /**
     * @param float $subTotal
     * @return float
     */
    public function calculateTax(float $subTotal): float;


    /**
     * @param float $subTotal
     * @param float $tax
     * @param float $discounts
     * @return float
     */
    public function calculateTotal(float $subTotal, float $tax, float $discounts): float;
}
