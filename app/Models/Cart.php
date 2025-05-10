<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    protected $guarded = [];



    // Events (Observers)
    // creating, created, updating, updated, saving, saved
    // deleting, deleted, restoring, restored, retrieved

    public static function booted()
    {
        // when we insert to cart insert that uuid automatically
//        static::creating(function (Cart $cart) {
//            $cart->id = Str::uuid();
//        });
        static::observe(CartObserver::class);
    }

    public function users(){
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous',
        ]);
    }

    public function products(){
        return $this->belongsTo(Product::class);
    }


}
