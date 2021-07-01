<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Services\BillService;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var BillService
     */
    private BillService $billService;

    public function setUp(): void
    {
        parent::setUp();

        $this->billService = new BillService(new CartService(), new ProductService(['jacket']));
    }

    public function testPrint()
    {
        $response = $this->billService->print();
        $this->assertStringContainsString('Subtotal', $response);
        $this->assertStringContainsString('Total', $response);
        $this->assertStringContainsString('Taxes', $response);

    }
}
