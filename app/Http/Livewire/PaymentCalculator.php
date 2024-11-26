<?php

namespace App\Http\Livewire;

use App\Models\Reseller;
use Illuminate\Support\Arr;
use Livewire\Component;

class PaymentCalculator extends Component
{
    public $reseller;

    public $balance;

    public $amount;

    public $method;

    public $bank_name;

    public $account_name;

    public $branch;

    public $routing_no;

    public $type;

    public $number;

    public function mount(Reseller $reseller, $amount = null, $method = null)
    {
        $this->reseller = $reseller;
        $this->amount = $amount;
        $this->method = $method;
        $this->calc();
    }

    public function render()
    {
        return view('livewire.payment-calculator');
    }

    public function calc()
    {
        $this->balance = $this->reseller->balance - (is_numeric($this->amount) ? $this->amount : 0);
    }

    public function chMethod()
    {
        if (! empty($this->method)) {
            $arr = Arr::first($this->reseller->payment, function ($payment) {
                return $payment->method == $this->method;
            });

            // dd($arr);
            $this->bank_name = $arr->bank_name ?? '';
            $this->account_name = $arr->account_name ?? '';
            $this->type = $arr->type ?? '';
            $this->branch = $arr->branch ?? '';
            $this->routing_no = $arr->routing_no ?? '';
            $this->number = $arr->number;
        }
    }
}
