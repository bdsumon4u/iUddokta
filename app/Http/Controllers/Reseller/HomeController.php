<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:reseller');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::where('reseller_id', auth('reseller')->user()->id)->status('pending')->latest()->take(10)->get();
        $transactions = Transaction::where('reseller_id', auth('reseller')->user()->id)->status('paid')->latest()->take(10)->get();

        return view('reseller.dashboard', compact('orders', 'transactions'));
    }
}
