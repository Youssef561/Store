<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    protected $guarded = [];



    // Events (Observers)
    // creating, created, updating, updated, saving, saved
    // deleting, deleted, restoring, restored, retrieved

    public static function booted()
    {
        // that observe when we insert to cart insert that uuid automatically
//        static::creating(function (Cart $cart) {
//            $cart->id = Str::uuid();
//        });
        static::observe(CartObserver::class);

        static::addGlobalScope('cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', '=', Cart::getCookieId());
        });

    }

    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }


    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous',
        ]);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


}
