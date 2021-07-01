<?php

namespace App\Factories;

use App\Strategies\DiscountPlans\AbstractDiscountPlan;
use App\Exceptions\DiscountPlanException;

class DiscountPlansFactory
{
    public static function create($name)
    {
        $className = ucfirst(\Str::of($name)->camel());
        $class= "App\\Strategies\\DiscountPlans\\" . $className;
        $obj= new $class();

        if (! $obj instanceof AbstractDiscountPlan) {
            throw new DiscountPlanException("The Discount plan must be object of AbstractDiscountPlan");
        }
        return new $class();
    }
}
