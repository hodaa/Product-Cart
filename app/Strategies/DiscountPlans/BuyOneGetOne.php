<?php

namespace App\Strategies\DiscountPlans;


use App\Models\Product;

class BuyOneGetOne extends AbstractDiscountPlan
{
    /**
     * @param Product $item
     * @param array $selectedProducts
     * @return float
     */
    public function calculateDiscount(Product $item, array $selectedProducts): float
    {
        if (isset($selectedProducts[$item->name]) > $item->apply_when_count) {
            return $item->price;
        }
    }
}
