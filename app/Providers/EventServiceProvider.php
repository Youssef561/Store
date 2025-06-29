<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\DeductProductQuantity;
use App\Listeners\EmptyCart;
use Illuminate\Support\Facades\Event;
//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;    // now we have access to the protected $listen


class EventServiceProvider extends ServiceProvider
{

    // here we use event class
    protected $listen = [
        OrderCreated::class => [
            DeductProductQuantity::class,
            EmptyCart::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // here we use string in the event.
//        Event::listen('order.created', DeductProductQuantity::class);
//        Event::listen('order.created', EmptyCart::class);
    }
}
