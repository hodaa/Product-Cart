<?php

namespace App\Validations;

use App\Services\ProductService;

class ProductValidation implements ValidatorInterface
{
    /**
     * @var array;
     */
    private array $products ;

    /**
     * ProductValidation constructor.
     * @param string $products
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $productsService = new ProductService($this->products);
        return empty(array_diff($productsService->getItems(), $productsService->getProductNames()));
    }
}
