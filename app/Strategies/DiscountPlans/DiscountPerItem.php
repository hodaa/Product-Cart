<?php

namespace  App\Strategies\DiscountPlans;
use App\Models\Product;

/**
 * Class DiscountPerItem
 * @package App\Strategies\DiscountPlans
 */

class DiscountPerItem extends AbstractDiscountPlan
{
    /**
     * @param Product $item
     * @param array $selectedProducts
     * @return float
     */
    public function calculateDiscount(Product $item, array $selectedProducts): float
    {
        $discount= ($item['price'] * $item['percent'])/100;
        return  $discount;

    }
}
