<?php

namespace App\Providers;

use App\Helpers\Currency;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        AliasLoader::getInstance()->alias('Currency', Currency::class);             // Alias for currency
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // testing
        //ini_set('max_execution_time',300);
        Paginator::useBootstrapFive();          // for pagination
    }
}
