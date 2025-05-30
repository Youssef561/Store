<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;
    // we used construct instead of calling the repo every time in the function constructor
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()             // we can use if we define it in a service container
    {
        return view('front.cart', ['cart' => $this->cart]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'required|int|min:1',
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $this->cart->add($product, $request->post('quantity'));

        if($request->expectsJson()){
            return response()->json([
                'message' => 'Product added to cart',
            ], 201);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|int|min:1',
        ]);

        $this->cart->update($id, $request->post('quantity'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cart->delete($id);
        return [
            'message' => 'Product deleted successfully!'
        ];
    }
}
