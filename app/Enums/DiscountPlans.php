<?php

namespace App\Enums;

class DiscountPlans extends Enum
{
    public const DISCOUNT_PER_ITEM = 1;
    public const BUY_ITEM_DISCOUNT_ON_ANOTHER = 2;
    public const BUY_ONE_GET_ONE = 3;
}
