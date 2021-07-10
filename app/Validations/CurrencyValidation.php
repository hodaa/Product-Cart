<?php

namespace App\Validations;

class CurrencyValidation implements ValidatorInterface
{


    /**
     * @return bool
     */
    public function validate($currency): bool
    {
        $allCurrencies= collect(config('currencies'))->map(function ($item) {
            return $item['code'];
        })->all();

        return in_array($currency, $allCurrencies);
    }
}
