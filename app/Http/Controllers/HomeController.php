<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Reseller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::has('reseller')->with('reseller')->status('PENDING')->latest()->take(10)->get();
        $transactions = Transaction::has('reseller')->with('reseller')->status('PENDING')->latest()->take(10)->get();
        $resellers = Reseller::whereNull('verified_at')->take(10)->get();
        return view('admin.dashboard', compact('orders', 'transactions', 'resellers'));
    }
}
