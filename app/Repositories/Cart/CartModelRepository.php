<?php

namespace App\Repositories\Cart;


use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    protected $item;

    public function __construct()
    {
        $this->item = collect([]);
    }

    public function get() : Collection
    {
        // using the construct, now we create only 1 query instead of creating the same query every time in every request
       if (!$this->item->count()) {
           $this->item = Cart::with('product')->get();
       }
       return $this->item;
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', $product->id)
            ->first();

        if (!$item) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
            $this->item->push($cart);
            return $cart;
        }

        return $item->increment('quantity', $quantity);

    }


    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)

            ->update([
            'quantity' => $quantity,
        ]);
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->delete();
    }

    public function empty()
    {
        Cart::query()->delete();
    }

    public function total(): float
    {
        // we add (float) as type casting caz maybe the total is null, so we used casting to avoid errors
//        return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
//            ->selectRaw('SUM(products.price * carts.quantity) as total')
//            ->value('total');
        return $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

}
