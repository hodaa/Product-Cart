<?php

namespace App\Services;

use App\Enums\DiscountPlans;
use App\Factories\DiscountPlansFactory;
use App\Contracts\CartInterface;
use App\Composite\Discount;
use App\Composite\Bill;
use Illuminate\Database\Eloquent\Collection;

class CartService implements CartInterface
{

    /**
     * @para\m Collection $matchedProducts
     * @param array $selectedProducts
     * @return float
     */
    public function calculateSubTotal(Collection $matchedProducts, array $selectedProducts): float
    {
        $result=[];
        foreach ($matchedProducts as  $item) {
            $itemCount = $selectedProducts[$item->name];
            $result[$item->name] =  $item->price * $itemCount;
        }
        return array_sum($result);
    }


    /**
     * @param $subTotal
     * @return float
     */
    public function calculateTax($subTotal): float
    {
        return $subTotal * config('cart.tax') / 100;
    }

    /**
     * @param Collection $matchedProducts
     * @param array $selectedProducts
     * @return array
     * @throws \ReflectionException
     */
    public function calculateDiscounts(Collection $matchedProducts, array $selectedProducts): array
    {
        $discounts = 0 ;
        $bill = new Bill();

        foreach ($matchedProducts as $item) {

            if (!empty($item->plan) && in_array($item->plan, DiscountPlans::getValues())) {

                $discountPlan =  DiscountPlans::getName($item['plan']);
                $discountPlanObj = DiscountPlansFactory::create($discountPlan);

                $discountValue = $discountPlanObj->calculateDiscount($item, $selectedProducts);
                $discounts+= $discountValue;

                if ($discountValue) {
                    $result = $discountPlanObj->setDiscountTemplate($item, $discountValue);
                    $bill->addElement(new Discount($result));
                }
            }
        }
        return ['message' => $bill->print() ,'discounts' => $discounts];
    }


    /**
     * @param float $subTotal
     * @param float $tax
     * @param float $discounts
     * @return mixed
     */
    public function calculateTotal(float $subTotal, float $tax, float $discounts): float
    {
        return  $subTotal + $tax - $discounts;
    }
}
