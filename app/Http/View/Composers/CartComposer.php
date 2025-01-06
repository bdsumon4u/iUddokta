<?php

namespace App\Http\View\Composers;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view): void
    {
        $user_id = auth('reseller')->user()->id;
        $cart = Cart::session($user_id)->getContent();
        $view->with('cart', $cart);
    }
}
