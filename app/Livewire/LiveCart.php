<?php

namespace App\Livewire;

use App\Models\Order;
use App\Pathao\Facade\Pathao;
use Cart;
use Darryldecode\Cart\Facades\CartFacade;
use Livewire\Component;

class LiveCart extends Component
{
    public Order $order;

    public $city_id = 0;
    public $area_id = 0;

    public $type;

    public $cart;

    public $user_id;

    public $subTotal;

    public $total;

    public $payable;

    public $sell;

    public $shipping;

    public $advanced;

    public $discount;

    public $shops;

    public $success;

    public $delete;

    public function mount($type, $cart, $sell = 0, $shipping = 100, $advanced = 100, $discount = 0)
    {
        $this->order = new Order();
        $this->type = $type;
        $this->cart = $cart;
        $this->user_id = auth('reseller')->user()->id;
        $this->sell = $sell;
        $this->shipping = $shipping;
        $this->advanced = $advanced;
        $this->discount = $discount;
        $this->theMoney();
        $this->shops = auth('reseller')->user()->shops;
    }

    public function increment($id)
    {
        $cart = CartFacade::session($this->user_id);
        $cart->update($id, [
            'quantity' => 1,
        ]);
        $this->cart = $cart->getContent()->toArray();

        $this->sell = $this->retail();
        $this->theMoney();
    }

    public function decrement($id)
    {
        $cart = CartFacade::session($this->user_id);
        $cart->update($id, [
            'quantity' => -1,
        ]);
        $this->cart = $cart->getContent()->toArray();

        $this->sell = $this->retail();
        $this->theMoney();
    }

    public function changed()
    {
        $this->theMoney();
    }

    public function remove($id)
    {
        Cart::session($this->user_id)->remove($id);
        unset($this->cart[$id]);
        $this->sell = $this->retail();
        $this->theMoney();
        $this->success = 'Cart Item Removed.';
    }

    public function render()
    {
        return view('livewire.live-cart');
    }

    protected function retail()
    {
        return Cart::session($this->user_id)
            ->getContent()
            ->sum(function ($item) {
                return $item->attributes->product->retail * $item->quantity;
            });
    }

    protected function theMoney()
    {
        $this->sell = $this->sell > 0
                        ? $this->sell
                        : $this->retail();
        $this->subTotal = theMoney(Cart::session($this->user_id)->getSubTotal());
        $this->total = theMoney(Cart::session($this->user_id)->getTotal());
        $this->payable = $this->sell
                        + (empty($this->shipping) ? 0 : round($this->shipping))
                        - (empty($this->advanced) ? 0 : round($this->advanced))
                        - (empty($this->discount) ? 0 : round($this->discount));
    }


    public function getCityList()
    {
        $exception = false;
        $cityList = cache()->remember('pathao_cities', now()->addDay(), function () use (&$exception) {
            try {
                return Pathao::area()->city()->data;
            } catch (\Exception $e) {
                $exception = true;
                return [];
            }
        });

        if ($exception) cache()->forget('pathao_cities');

        return $cityList;
    }

    public function getAreaList()
    {
        $areaList = [];
        $exception = false;
        if ($this->city_id ?? false) {
            $areaList = cache()->remember('pathao_areas:' . $this->city_id, now()->addDay(), function () use (&$exception) {
                try {
                    return Pathao::area()->zone($this->city_id)->data;
                } catch (\Exception $e) {
                    $exception = true;
                    return [];
                }
            });
        }

        if ($exception) cache()->forget('pathao_areas:' . $this->city_id);

        return $areaList;
    }
}
