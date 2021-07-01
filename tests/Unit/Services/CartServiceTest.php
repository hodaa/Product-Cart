<?php

namespace Tests\Unit\Services;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Offer;
use App\Services\CartService;
use App\Services\CurrencyService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Services;
use Mockery\MockInterface;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $cartService;
    private array $matchedProducts= [];

    public function setUp(): void
    {
        parent::setUp();
        Product::factory()->create(['name'=>'t-shirt','price' => 10.99]);
        Product::factory()->create(['name'=>'pants','price' => 14.99]);
        Product::factory()->create(['name'=>'jacket','price' => 19.99]);
        Product::factory()->create(['name'=>'shoes','price' => 24.99]);

        Offer::factory()->create(['product_id' => 1,'plan' => 2,'percent' => 50 , 'discount_on'=> 3, 'apply_when_count'=>2]);
        Offer::factory()->create(['product_id' => 2,'plan' => 1,'percent' => 10 , 'discount_on'=> 1, 'apply_when_count'=>1]);

        $this->cartService = new CartService(['jacket']);
    }

    public function getExchangeRate(string $currency): float
    {
        return  Currency::convert()->from('USD')->to($currency)->get();
    }


    public function testCalculateSubTotal()
    {
        $response= $this->cartService->calculateSubTotal(Product::all(), ['t-shirt'=>1,'pants'=>1,'jacket'=>1,'shoes'=>1]);
        $this->assertEquals($response, 70.96);


        config(['cart.currency' => 'EGP']);
        $this->mock(CurrencyService::class, function (MockInterface $mock) {
            $mock->shouldReceive('convertPrice')->andReturn(155.55);
        });

        $response= $this->cartService->calculateSubTotal(Product::all(), ['t-shirt'=>1,'pants'=>2,'jacket'=>1,'shoes'=>1]);
        $subTotal= 155.55* 5;

        $this->assertEquals(round($response, 2), round($subTotal, 2));
    }

    public function testCalculateTax()
    {
        $result= $this->cartService->calculateTax(100);
        $this->assertEquals(14, $result);

        config(['cart.tax' => '20']);
        $result= $this->cartService->calculateTax(100);
        $this->assertEquals(20, $result);
    }

    public function testCalculateDiscounts()
    {
        $productService= new ProductService(['Jacket','Pants']);
        $products= $productService->getMatchedProducts();
        $response = $this->cartService->calculateDiscounts($products, ['t-shirt'=>1]);
        $this->assertIsArray($response);
        $discountValue= (14.99* 10)/100;
        $this->assertEquals([
                  "message" => "\t10% off pants: -$$discountValue\n",
                  "discounts" => $discountValue
            ], $response);
    }

    public function testCalculateTotal()
    {
        $response = $this->cartService->calculateTotal(100, 200, 10);
        $this->assertIsFloat($response);
        $this->assertEquals(290, $response);
    }
}
