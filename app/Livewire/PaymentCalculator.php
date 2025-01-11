<?php

namespace App\Livewire;

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

    public $order_ids;

    public function mount(Reseller $reseller, $amount = null, $method = null): void
    {
        $this->reseller = $reseller;
        $this->amount = $amount;
        $this->method = $method;
        $this->chMethod();
        $this->calc();

        $orders = $reseller->orders()
            ->where('status', 'DELIVERED')
            ->whereDoesntHave('transactions')
            ->get();

        $this->order_ids = $orders->pluck('id')->implode(',');

        $this->amount = $orders->sum(fn($item): int|float => $item->data['profit'] - $item->data['advanced']);
    }

    public function render()
    {
        return view('livewire.payment-calculator');
    }

    public function calc(): void
    {
        $this->balance = $this->reseller->balance - ($this->amount ?? 0);
    }

    public function chMethod(): void
    {
        if (! empty($this->method)) {
            $arr = Arr::first($this->reseller->payment, fn($payment): bool => $payment->method == $this->method);

            $this->bank_name = $arr->bank_name ?? '';
            $this->account_name = $arr->account_name ?? '';
            $this->type = $arr->type ?? '';
            $this->branch = $arr->branch ?? '';
            $this->routing_no = $arr->routing_no ?? '';
            $this->number = $arr->number;
        }
    }
}
