<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * @var array
     */
    private array $items;

    /**
     * ProductService constructor.
     * @param array $selectedProducts
     */
    public function __construct(array $selectedProducts)
    {
        $this->items =  collect($selectedProducts)->map(function ($item) {
            return strtolower($item);
        })->all();
    }


    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return mixed
     */
    public function getProductNames(): array
    {
        return  Product::select('name')->pluck('name')->toArray();
    }


    /**
     * Get all data matched to given items from DB
     * @return mixed
     */
    public function getMatchedProducts()
    {
        return Product::select('products.id', 'price', 'name', 'percent', 'plan', 'discount_on', 'apply_when_count')
            ->leftjoin('offers', 'offers.product_id', '=', 'products.id')
            ->whereIn('name', $this->items)
            ->get();
    }

    public function getSelectedItemCount(): array
    {
        return array_count_values($this->items);
    }
}
