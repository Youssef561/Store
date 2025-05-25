<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'store_id', 'user_id', 'payment_method', 'status', 'payment_status', 'shipping', 'tax', 'discount', 'total'
    ];

    public static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        // select max number from orders
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');

        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)
            ->withDefault([
                'name' => 'Guest Customer',
            ]);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
            ->using(OrderItem::class) // use this model for pivot table, and the model should extend Pivot
            ->withPivot('product_name', 'price', 'quantity', 'options');
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        // this return model
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', 'billing');

        // this return collection, would be better if I want to get more than one address
        //return $this->addresses()->where('type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', 'shipping');
    }


}
