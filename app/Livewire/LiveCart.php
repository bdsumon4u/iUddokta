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

    public $city_id;

    public $area_id;

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

    public function mount($type, $cart, $sell = 0, $shipping = 100, $advanced = 100, $discount = 0): void
    {
        $this->order = new Order;
        $this->type = $type;
        $this->cart = $cart;
        $this->user_id = auth('reseller')->user()->id;
        $this->sell = $sell;
        $this->shipping = $shipping;
        $this->advanced = $advanced;
        $this->discount = $discount;
        $this->theMoney();
        $this->shops = auth('reseller')->user()->shops;
        $this->city_id = old('city_id');
        $this->area_id = old('area_id');
    }

    public function increment($id): void
    {
        $cart = CartFacade::session($this->user_id);
        $cart->update($id, [
            'quantity' => 1,
        ]);
        $this->cart = $cart->getContent()->toArray();

        $this->sell = $this->retail();
        $this->theMoney();
    }

    public function decrement($id): void
    {
        $cart = CartFacade::session($this->user_id);
        $cart->update($id, [
            'quantity' => -1,
        ]);
        $this->cart = $cart->getContent()->toArray();

        $this->sell = $this->retail();
        $this->theMoney();
    }

    public function changed(): void
    {
        $this->theMoney();
    }

    public function remove($id): void
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
            ->sum(fn($item): int|float => $item->attributes->product->retail * $item->quantity);
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
            } catch (\Exception) {
                $exception = true;

                return [];
            }
        });

        if ($exception) {
            cache()->forget('pathao_cities');
        }

        return $cityList;
    }

    public function getAreaList()
    {
        $areaList = [];
        $exception = false;
        if ($this->city_id ?? false) {
            $areaList = cache()->remember('pathao_areas:'.$this->city_id, now()->addDay(), function () use (&$exception) {
                try {
                    return Pathao::area()->zone($this->city_id)->data;
                } catch (\Exception) {
                    $exception = true;

                    return [];
                }
            });
        }

        if ($exception) {
            cache()->forget('pathao_areas:'.$this->city_id);
        }

        return $areaList;
    }
}
