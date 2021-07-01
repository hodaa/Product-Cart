<?php

namespace Tests\Unit\Services;

use App\Models\Offer;
use App\Services\CartService;
use App\Services\CurrencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class CurrencyServiceTest extends TestCase
{
    use RefreshDatabase;

    private CurrencyService $currencyService;

    public function setUp(): void
    {
        parent::setUp();

        Product::factory()->create(['name' => 't-shirt', 'price' => 10.99]);
        Product::factory()->create(['name' => 'pants', 'price' => 14.99]);
        Product::factory()->create(['name' => 'jacket', 'price' => 19.99]);
        Product::factory()->create(['name' => 'shoes', 'price' => 24.99]);

        Offer::factory()->create(['product_id' => 1, 'plan' => 2, 'percent' => 50, 'discount_on' => 3, 'apply_when_count' => 2]);
        Offer::factory()->create(['product_id' => 2, 'plan' => 1, 'percent' => 10, 'discount_on' => 1, 'apply_when_count' => 1]);
    }

    public function testGetCurrencySymbol()
    {
        $currencyService = new CurrencyService();
        $response = $currencyService->getCurrencySymbol();
        $this->assertEquals('$', $response);

        config(['cart.currency' => 'EGP']);

        $currencyService = new CurrencyService();
        $response = $currencyService->getCurrencySymbol();

        $this->assertEquals('e£', $response);
    }
}
