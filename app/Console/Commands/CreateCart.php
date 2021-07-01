<?php

namespace App\Console\Commands;

use App\Exceptions\CurrencyNotValid;
use App\Exceptions\ProductNotValid;
use App\Services\BillService;
use App\Services\CartService;
use App\Services\CurrencyService;
use App\Services\ProductService;
use Illuminate\Console\Command;
use App\Validations\CurrencyValidation;
use App\Validations\ProductValidation;

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
     * Execute the console command.
     *
     * @return void $subTotal
     * @throws ProductNotValid|CurrencyNotValid
     */
    public function handle()
    {
        $items =$this->argument('items');
        $currency = $this->argument('currency');

        $currencyValidation = new CurrencyValidation($currency);
        if (!$currencyValidation->validate()) {
            throw  new CurrencyNotValid("This Currency is not valid");
        }


        $productsValidation = new ProductValidation($items);
        if (! $productsValidation->validate()) {
            throw  new ProductNotValid("This Product is not valid");
        }

        config(['cart.currency' => $currency]);

        $bill = new BillService(new CartService(), new ProductService($items));
        echo $bill->print();
    }
}
