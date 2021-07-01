<?php

namespace App\Strategies\DiscountPlans;

use App\Models\Product;

class BuyItemDiscountOnAnother extends AbstractDiscountPlan
{
    /**
     * @param Product $item
     * @param array $selectedProducts
     * @return float
     */
    public function calculateDiscount(Product $item, array $selectedProducts): float
    {
        $discountOnItem = isset($selectedProducts[$item->offer->discountOn->name])?? 0;
        $isValidOffer = $selectedProducts[$item->name] >= $item->apply_when_count && $discountOnItem;

        return $isValidOffer ? ($item->offer->discountOn->price * $item->percent) /100 : 0;
    }
}
