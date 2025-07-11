<?php

namespace App\Helpers;

use NumberFormatter;

class Currency
{

    // invoke is magic method, we call it if we call the class as a function
    public function __invoke(...$params)
    {
        return static::format(...$params);
    }

    public static function format($amount, $currency = null)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        if ($currency === null) {
            $currency = config('app.currency', 'USD');
        }
        return $formatter->formatCurrency($amount, $currency);

    }
}
