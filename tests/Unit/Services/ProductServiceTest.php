<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProductService $productService;

    public function setUp(): void
    {
        parent::setUp();
        Product::factory()->create(['name'=>'t-shirt','price' => 10.99]);
        Product::factory()->create(['name'=>'pants','price' => 14.99]);
        Product::factory()->create(['name'=>'jacket','price' => 19.99]);
        Product::factory()->create(['name'=>'shoes','price' => 24.99]);
    }

    public function testGetProductNames()
    {
        $this->productService = new ProductService([]);
        $response = $this->productService->getProductNames();
        $this->assertIsArray($response);
        $this->assertEquals(["jacket" ,"pants" ,"shoes" ,"t-shirt"], $response);
    }

    public function testGetMatchedProducts()
    {
        $this->productService = new ProductService(['jacket','Pants']);
        $response = $this->productService->getMatchedProducts();
        $this->assertCount(2, $response);
        $this->assertInstanceOf(Product::class, $response->first());
    }

    public function testGetSelectedItemCount()
    {
        $this->productService = new ProductService(['jacket','Pants','Pants','Pants']);
        $response= $this->productService->getSelectedItemCount();
        $this->assertEquals([
                "jacket" => 1,
                "pants" => 3
            ], $response);
    }
}
