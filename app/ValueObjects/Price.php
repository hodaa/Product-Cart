<?php

namespace App\ValueObjects;

use App\Services\CurrencyService;

final class Price
{
    private float $amount;
    private int $precision;
    private string $currency;


    public function __construct(float $amount)
    {
        if (!is_float($amount)) {
            throw new \InvalidArgumentException('Amount must be an float');
        }
        if ($amount < 0) {
            throw new \InvalidArgumentException("Amount should be a positive value: {$amount}.");
        }

        $this->amount = $amount;
        $this->precision = config('cart.precision');
        $this->currency = app(CurrencyService::class)->getCurrencySymbol();
    }

    public function getAmount(): float
    {
        return  round($this->amount, $this->precision);
    }

    public function getCurrency(): string
    {
        return app(CurrencyService::class)->getCurrencySymbol();
    }
}
