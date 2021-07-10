<?php

namespace App\Validations;

use App\Services\ProductService;

class ProductValidation implements ValidatorInterface
{

    /**
     * @return bool
     */
    public function validate($products): bool
    {
        $productsService = new ProductService($products);
        return empty(array_diff($productsService->getItems(), $productsService->getProductNames()));
    }
}
