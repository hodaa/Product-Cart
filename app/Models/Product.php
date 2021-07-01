<?php

namespace App\Models;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Services\CurrencyService;
use App\ValueObjects\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * @param $value
     * @return string
     */
    public function getNameAttribute($value): string
    {
        return strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getPriceAttribute($value): string
    {
        return app(CurrencyService::class)->convertPrice($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function offer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Offer::class);
    }

}
