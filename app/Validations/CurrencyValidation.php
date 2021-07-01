<?php

namespace App\Validations;

class CurrencyValidation implements ValidatorInterface
{
    /**
     * @var string
     */
    private string $currency ;


    /**
     * CurrencyValidation constructor.
     * @param string $currency
     */
    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $allCurrencies= collect(config('currencies'))->map(function ($item) {
            return $item['code'];
        })->all();

        return in_array($this->currency, $allCurrencies);
    }
}
