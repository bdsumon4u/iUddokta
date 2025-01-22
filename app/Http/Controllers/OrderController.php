<?php

namespace App\Http\Controllers;

use App\Events\OrderStatusChanged;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $filter = $request->filter ?? [];

        // $orders = Order::where($filter)->latest()->get();

        return view('admin.orders.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $variant = $this->variant($order->status);
        $products = Product::withTrashed()->whereIn('id', array_keys($order->data['products']))->get();
        $cp = $order->current_price();

        return view('admin.orders.show', compact('order', 'products', 'cp', 'variant'));
    }

    public function status(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'order_id' => 'required|array',
        ]);

        $data['status'] = $request->status;
        $data['completed_at'] = strtolower($request->status) === 'delivered' ? now()->toDateTimeString() : '';
        $data['returned_at'] = strtolower($request->status) === 'failed' ? now()->toDateTimeString() : '';
        $orders = Order::whereIn('id', $request->order_id)->where('status', '!=', $request->status)->get();

        $orders->each->update($data);

        return redirect()->back()->withSuccess('Order Status Has Been Updated.');
    }

    public function invoice(Order $order)
    {
        $variant = $this->variant($order->status);

        return view('admin.orders.invoice', compact('order', 'variant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // dump($order->data);
        if ($order->status == 'DELIVERED' || $order->status == 'FAILED') {
            return back()->with('error', 'Order Can\'t be Updated');
        }

        tap($request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'nullable',
            'customer_phone' => 'required',
            'customer_address' => 'required|string',
            'note' => 'nullable',
            'shipping' => 'required',
            'advanced' => 'required',
            'buy_price' => 'required',
            'payable' => 'required',
            'profit' => 'required',
            'packaging' => 'required',
            'delivery_charge' => 'required',
            'cod_charge' => 'required',
            'sell' => 'required',
            'delivery_method' => 'required',
            'booking_number' => 'nullable',
            'status' => 'required',
            'city_id' => 'required|integer',
            'area_id' => 'required|integer',
        ]), function ($data) use ($order): void {
            $before = $order->status;
            $data['profit'] = $data['sell'] - ($data['buy_price'] ?? $data['price']) - ($data['packaging'] + $data['delivery_charge'] + $data['cod_charge']) + $data['shipping'];
            $order->status = $data['status'];
            $data['completed_at'] = $data['status'] == 'delivered' ? now()->toDateTimeString() : null;
            $data['returned_at'] = $data['status'] == 'failed' ? now()->toDateTimeString() : null;
            unset($data['status']);
            foreach ($order->data as $key => $val) {
                $data[$key] ??= $val;
            }
            // dd($data);
            $order->data = $data;
            if ($order->save()) {
                event(new OrderStatusChanged(['order' => $order, 'before' => $before]));
                foreach ($order->data['products'] as $item) {
                    $product = Product::findOrFail($item['id']);
                    $product->stock = $product->stock ? $product->stock + $item['quantity'] : $product->stock;
                    $product->save();
                }
            }
        });

        return back()->with('success', 'Order Updated');
    }

    public function invoices(Request $request)
    {
        $request->validate(['order_id' => 'required']);
        $order_ids = explode(',', $request->order_id);
        $order_ids = array_map('trim', $order_ids);
        $order_ids = array_filter($order_ids);

        $orders = Order::whereIn('id', $order_ids)->get();

        return view('admin.orders.invoices', compact('orders'));
    }

    public function cancel(Order $order)
    {
        if (in_array($order->status, ['DELIVERED', 'FAILED'])) {
            return redirect()->back()->with('error', "Order Can\'t be Cancelled.");
        }

        foreach ($order->data['products'] as $item) {
            $product = Product::findOrFail($item['id']);
            $product->stock = $product->stock ? $product->stock + $item['quantity'] : $product->stock;
            $product->save();
        }
        $order->delete();

        return redirect()->back()->with('success', 'Order Cancelled');
    }

    private function variant($status): string
    {
        return match (strtolower((string) $status)) {
            'pending' => 'secondary',
            'processing' => 'warning',
            'invoiced' => 'info',
            'shipping' => 'primary',
            'completed' => 'success',
            'failed' => 'danger',
            default => 'default',
        };
    }
}
