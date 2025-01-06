<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:reseller');
    }

    /**
     * Cart Index
     */
    public function index()
    {
        if (auth('reseller')->user()->shops->isEmpty()) {
            return redirect()->route('reseller.home')->with('error', 'Create Shop First.');
        }

        return view('reseller.cart.index');
    }

    /**
     * Add Item
     */
    public function add(Request $request, Product $product)
    {
        if (auth('reseller')->user()->shops->isEmpty()) {
            return redirect()->route('reseller.home')->with('error', 'Create Shop First.');
        }
        $data = $request->has('qty') ? ['quantity' => $request->qty] : [];
        $data += [
            'quantity' => 1,
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->wholesale,
            'attributes' => [
                'product' => $product,
            ],
        ];

        $user_id = auth('reseller')->user()->id;
        Cart::session($user_id)->add($data);

        return redirect()->back()->with('success', 'Item Added To Cart.');
    }

    /**
     * Remove Item
     */
    public function remove(Product $product)
    {
        $user_id = auth('reseller')->user()->id;
        Cart::session($user_id)->remove($product->id);

        return redirect()->back()->with('success', 'Item Removed From Cart.');
    }

    /**
     * Clear Cart
     */
    public function clear()
    {
        $user_id = auth('reseller')->user()->id;
        Cart::session($user_id)->clear();

        return redirect()->route('reseller.product.index')->with('success', 'Cart Cleared.');
    }

    /**
     * Checkout
     */
    public function checkout(Request $request)
    {
        if (auth('reseller')->user()->shops->isEmpty()) {
            return redirect()->route('reseller.home')->with('error', 'Create Shop First.');
        }

        return view('reseller.checkout.index', [
            'sell' => $request->sell,
            'shipping' => $request->shipping,
            'advanced' => $request->advanced,
            'discount' => $request->discount,
        ]);
    }
}
