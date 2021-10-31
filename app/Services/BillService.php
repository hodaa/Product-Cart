<?php

namespace App\Services ;

use App\Composite\Bill;
use App\Composite\DiscountBag;
use App\Composite\Service;
use App\Composite\SubTotal;
use App\Composite\Tax;
use App\Composite\Total;
use App\Contracts\BillInterface;
use App\Contracts\CartInterface;
use App\ValueObjects\Currency;
use App\ValueObjects\Money;
use App\ValueObjects\Price;

class BillService implements BillInterface
{
    /**
     * @var CartInterface
     */
    private CartInterface $cartService;

    /**
     * CartService constructor.
     * @param CartInterface $cartService
     */
    public function __construct(CartInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @return string
     */
    public function print(): string
    {
        $subTotal = $this->cartService->calculateSubTotal();
        $taxes = $this->cartService->calculateTax($subTotal);
        $discountData = $this->cartService->calculateDiscounts();
        $total = $this->cartService->calculateTotal($subTotal, $taxes, $discountData['totalDiscount']);

        $bill = new Bill();

        $bill->addElement(new SubTotal(new Price($subTotal)));
        $bill->addElement(new Tax(new Price($taxes)));
        $bill->addElement(new DiscountBag($discountData['text']));
        $bill->addElement(new Total(new Price($total)));

        // You can add here whatever section You want to add to the bill ex:service

        return $bill->print();
    }
}
