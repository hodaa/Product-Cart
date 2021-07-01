<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CartInterface
{
    /**
     * @param Collection $matchedProducts
     * @param array $selectedProducts
     * @return float
     */
    public function calculateSubTotal(Collection $matchedProducts, array $selectedProducts): float;


    /**
     * @param array $matchedProducts
     * @param array $selectedProducts
     * @return array
     */
    public function calculateDiscounts(Collection $matchedProducts, array $selectedProducts): array;


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
