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
use App\ValueObjects\Price;

class BillService implements BillInterface
{
    /**
     * @var CartInterface
     */
    private CartInterface $cartService;

    /**
     * @var ProductService
     */
    private ProductService $productService;

    /**
     * CartService constructor.
     * @param CartInterface $cartService
     * @param ProductService $productService
     */
    public function __construct(CartInterface $cartService, ProductService $productService)
    {
        $this->cartService = $cartService;
        $this->productService = $productService;
    }

    /**
     * @return string
     */
    public function print(): string
    {

        $matchedProducts = $this->productService->getMatchedProducts();
        $selectedProducts = $this->productService->getSelectedItemCount();

        $subTotal = $this->cartService->calculateSubTotal($matchedProducts, $selectedProducts);
        $taxes = $this->cartService->calculateTax($subTotal);
        $discountData = $this->cartService->calculateDiscounts($matchedProducts, $selectedProducts);
        $total = $this->cartService->calculateTotal($subTotal, $taxes, $discountData['discounts']);

        $bill = new Bill();

        $bill->addElement(new SubTotal(new Price($subTotal)));
        $bill->addElement(new Tax(new Price($taxes)));
        $bill->addElement(new DiscountBag($discountData['message']));
        $bill->addElement(new Total(new Price($total)));

        // You can add here whatever section You want to add to the bill ex:service

        return $bill->print();
    }
}
