<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChargeCalculator extends Component
{
    public $order;

    public $quantity;

    public $cp;

    public $shipping;

    public $advanced;

    public $buy_price;

    public $sell;

    public $packaging;

    public $delivery_charge;

    public $cod_charge;

    public $loss;

    public $booking_number;

    public $payable;

    public $profit;

    public function mount($order, $quantity, $cp)
    {
        $this->order = $order;
        $this->quantity = $quantity;
        $this->cp = $cp;

        $this->shipping = $order->data['shipping'];
        $this->advanced = $order->data['advanced'];

        $this->buy_price = $order->data['buy_price'] ?? $order->data['price'];
        $this->sell = $order->data['sell'];

        $this->packaging = $order->data['packaging'] ?? $quantity * 10;
        $this->delivery_charge = $order->data['delivery_charge'] ?? 100;
        $this->cod_charge = $order->data['cod_charge'] ?? 0;

        $this->loss = $this->packaging + $this->delivery_charge + $this->cod_charge;

        $this->booking_number = $order->data['booking_number'] ?? null;
    }

    public function render()
    {
        $this->theMoney();

        return view('livewire.charge-calculator');
    }

    public function changed()
    {
        $this->theMoney();
    }

    public function theMoney()
    {
        $this->payable = (empty($this->sell) ? 0 : round($this->sell))
                        + (empty($this->shipping) ? 0 : round($this->shipping))
                        - (empty($this->advanced) ? 0 : round($this->advanced));
        $this->profit = (empty($this->sell) ? 0 : round($this->sell))
                        - (empty($this->buy_price) ? 0 : round($this->buy_price))
                        - (empty($this->delivery_charge) ? 0 : round($this->delivery_charge))
                        + (empty($this->shipping) ? 0 : round($this->shipping))
                        - (empty($this->packaging) ? 0 : round($this->packaging))
                        - (empty($this->cod_charge) ? 0 : round($this->cod_charge));
    }
}
