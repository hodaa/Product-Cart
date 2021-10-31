<?php

namespace App\Console\Commands;

use App\Exceptions\ItemNotValid;
use App\Services\CartService;
use App\Services\ProductService;
use App\Validations\ValidatorInterface;
use App\ValueObjects\Currency;
use Illuminate\Console\Command;
use App\Validations\CurrencyValidation;
use App\Validations\ProductValidation;
use App\Services\BillService;

class CreateCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:cart {currency}{items*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add items to Cart then  calculate prices and print bill';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param ValidatorInterface $validator
     * @param $params
     * @param $exception
     * @throws ItemNotValid
     */
    public function validate(ValidatorInterface $validator, $params, $exception)
    {
        if (! $validator->validate($params)) {
            throw new ItemNotValid($exception);
        }
    }

    /**
     * Execute the console command.
     *
     * @return void $subTotal
     * @throws ItemNotValid
     */
    public function handle()
    {
        $items = $this->argument('items');
        $this->validate(new ProductValidation(), $items, "This Product is not valid");

        $currency = $this->argument('currency');
        $currency = new Currency($currency);
        config(['cart.currency' => $currency->isoCode()]);

        $productService=  new ProductService($items);
        $products = $productService->getMatchedProducts();
        $purchases = $productService->getSelectedItemCount();

        $cart = new CartService($purchases);
        foreach ($products as $product) {
            $cart->add($product);
        }
        $bill= new BillService($cart);
        print $bill->print();
    }
}
