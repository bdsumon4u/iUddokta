<?php

namespace App\Http\Controllers\Reseller;

use App\Events\NewOrderRecieved;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:reseller');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->filter ?? [];

        $orders = auth('reseller')->user()->orders()->where($filter)->latest()->get();

        return view('reseller.orders.list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reseller = auth('reseller')->user();
        $data = $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'nullable',
            'customer_phone' => 'required',
            'customer_address' => 'required|string',
            'shop' => 'required|integer',
            'delivery_method' => 'required|string',
            'note' => 'nullable',
            'sell' => 'required|integer',
            'shipping' => 'required|integer',
            'advanced' => 'required|integer',
        ], [
            'sell.required' => 'The :key field must be at least 0.',
            'shipping.required' => 'The :key field must be at least 0.',
            'advanced.required' => 'The :key field must be at least 0.',
        ]);
        $data['payable'] = $data['sell'] + $data['shipping'] - $data['advanced'];

        $cart = CartFacade::session($reseller->id);
        $data['price'] = $cart->getTotal();
        $products = $cart->getContent()
            ->map(function ($item) {
                $product = $item->attributes->product;
                $arr['id'] = $item->id;
                $arr['quantity'] = is_numeric($product->stock) && $product->stock < $item->quantity ? $product->stock : $item->quantity;
                $arr['name'] = $product->name;
                $arr['code'] = $product->code;
                $arr['slug'] = $product->slug;
                $arr['wholesale'] = $product->wholesale;
                $arr['retail'] = $product->retail;

                return $arr;
            });
        $data['products'] = $products->toArray();

        $order = Order::create([
            'reseller_id' => $reseller->id,
            'data' => $data,
        ]);

        if ($order) {
            $cart->getContent()
                ->map(function ($item) {
                    $product = Product::findOrFail($item->attributes->product->id);
                    $product->stock = is_numeric($product->stock) ? ($product->stock >= $item->quantity ? $product->stock - $item->quantity : 0) : $product->stock;

                    return $product->save();
                });

            $user_id = auth('reseller')->user()->id;
            CartFacade::session($user_id)->clear();
            event(new NewOrderRecieved($order, $reseller));
        }

        return redirect()->route('reseller.product.index')->with('success', 'Order Success. Order ID# '.$order->id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        switch ($order->status) {
            case 'pending':
                $variant = 'secondary';
                break;
            case 'processing':
                $variant = 'warning';
                break;
            case 'shipping':
                $variant = 'primary';
                break;
            case 'completed':
                $variant = 'success';
                break;
            case 'returned':
                $variant = 'danger';
                break;

            default:
                // code...
                break;
        }
        // if($order->status == 'completed' | $order->status == 'returned') {
        $products = Product::withTrashed()->whereIn('id', array_keys($order->data['products']))->get();
        $cp = $order->current_price();

        return view('reseller.orders.show', compact('order', 'products', 'cp', 'variant'));
        // }
        // return redirect()->back()->with('error', 'You Can not view the order until status completed/returned.');
    }

    public function invoice(Order $order)
    {
        switch ($order->status) {
            case 'pending':
                $variant = 'secondary';
                break;
            case 'processing':
                $variant = 'warning';
                break;
            case 'shipping':
                $variant = 'primary';
                break;
            case 'completed':
                $variant = 'success';
                break;
            case 'returned':
                $variant = 'danger';
                break;

            default:
                $variant = '';
                break;
        }

        // if($order->status == 'completed' | $order->status == 'returned') {
        return view('reseller.orders.invoice', compact('order', 'variant'));

        // }
        return redirect()->back()->with('error', 'You Can not view the invoice until status completed/returned.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if ($order->status == 'pending') {
            foreach ($order->data['products'] as $item) {
                $product = Product::findOrFail($item['id']);
                $product->stock = is_numeric($product->stock) ? $product->stock + $item['quantity'] : $product->stock;
                $product->save();
            }
            $order->delete();

            return redirect()->route('reseller.order.index')->with('success', 'Order Cancelled.');
        }

        return redirect()->route('reseller.order.index')->with('error', "Order Can\'t be Cancelled.");
    }

    public function cancel(Order $order)
    {
        if ($order->status == 'pending') {
            foreach ($order->data['products'] as $item) {
                $product = Product::findOrFail($item['id']);
                $product->stock = is_numeric($product->stock) ? $product->stock + $item['quantity'] : $product->stock;
                $product->save();
            }
            $order->delete();

            return redirect()->back()->with('success', 'Order Cancelled');
        }

        return redirect()->back()->with('error', "Order Can\'t be Cancelled.");
    }
}
