<?php

namespace App\Services;

use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class CurrencyService
{
    /**
     * @var string|Repository|Application|mixed
     */
    private string $currency;

    /**
     * @var string|Repository|Application|mixed
     */
    private string $defaultCurrency;


    /**
     * Concurrency constructor.
     */
    public function __construct()
    {
        $this->currency = config('cart.currency');
        $this->defaultCurrency = config('cart.default_currency');
    }


    /**$this->currencyService
     * @return string
     */
    public function getCurrencySymbol(): string
    {
        $currency = $this->currency;
        return collect(config('currencies'))->filter(function ($item) use ($currency) {
            return $item['code'] == $currency;
        })->first()['symbol'];
    }

    /**
     * @param float $price
     * @return float
     */
    public function convertPrice(float $price): float
    {
        return Currency::convert()->from($this->defaultCurrency)->to($this->currency)->amount($price)->throw()->get();
    }




}
