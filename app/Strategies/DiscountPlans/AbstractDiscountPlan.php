<?php

namespace App\Strategies\DiscountPlans;

use App\Models\Product;
use App\Services\CurrencyService;

abstract class AbstractDiscountPlan
{
    /**
     * @param Product $item
     * @param float $discountValues
     * @return string
     */
    public function setDiscountTemplate(Product $item, float $discountValues): string
    {
        $currency = app(CurrencyService::class)->getCurrencySymbol();
        return  "\t".$item->percent.'% off '. $item->name .': -'.$currency . $discountValues;
    }

    /**
     * @param Product $item
     * @param array $selectedProducts
     * @return float
     */
    abstract public function calculateDiscount(Product $item, array $selectedProducts): float;
}
