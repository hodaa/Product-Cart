<?php

namespace App\Services;

use App\Contracts\CartInterface;
use App\Enums\DiscountPlans;
use App\Factories\DiscountPlansFactory;

class CartService implements CartInterface
{
    /**
     * @var array
     */
    private array $products= [];

    /**
     * @var array
     */
    private array $purchases;

    /**
     * CartService constructor.
     * @param $purchases
     */
    public function __construct($purchases)
    {
        $this->purchases =$purchases;
    }

    /**
     * @param $product
     */
    public function add($product) //addItem
    {
        $product->quantity= $this->purchases[$product->name];
        $this->products[]= $product;
    }

    /**
     * @return float
     */
    public function calculateSubTotal(): float
    {
        $total = 0.00;
        $callback = function ($product) use (&$total) {
            $total += ($product['price'] * $product['quantity']);
        };

        array_walk($this->products, $callback);

        return $total;
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
     * @return array
     * @throws \ReflectionException
     */
    public function calculateDiscounts(): array
    {
        $text ="";
        $discounts =0;

        $callback = function ($item) use (&$text, &$discounts) {
            $item=(object)$item;
            if (!empty($item->plan) && in_array($item->plan, DiscountPlans::getValues())) {
                $discountPlan =  DiscountPlans::getName($item->plan);
                $discountPlanObj = DiscountPlansFactory::create($discountPlan);
                $discounts+= $discountPlanObj->calculateDiscount($item, $this->purchases);
                if ($discounts) {
                    $text.= $discountPlanObj->setDiscountTemplate($item, $discounts)."\n";
                }
            }
        };

        array_walk($this->products, $callback);
        return ["totalDiscount"=>$discounts,"text"=>$text];
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
