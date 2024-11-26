<div class="card-body">
    <div class="row mb-2">
        <div class="col-sm-7">
            <div class="shop-logo">
                @if($logo = $shop->logo)
                <img src="{{ asset($logo) }}" alt="" class="img-responsive">
                @else
                <h1 class="my-2">{{ $shop->name }}</h1>
                @endif
            </div>
            <h2 class="my-2"><strong>INVOICE</strong></h2>
        </div>

        <div class="col-sm-5">
            <div><strong>{{ $shop->name }}</strong></div>
            @if($shop->address)
            <div><strong>Address:</strong> {{ $shop->address }}</div>
            @endif
            <div><strong>Email:</strong> {{ $shop->email }}</div>
            <div><strong>Phone</strong> {{ $shop->phone }}</div>
        </div>

    </div>

    <div class="row mb-3">
        <div class="col-sm-7">
            <strong>To,</strong>
            <br>
            <div><strong>{{ $order->data['customer_name'] }}</strong></div>
            <div><strong>Address:</strong> {{ $order->data['customer_address'] }}</div>
            <div><strong>Phone</strong> {{ $order->data['customer_phone'] }}</div>
        </div>
        <div class="col-sm-5">
            <!-- <div><strong>Invoice ID:</strong> {{ $shop->id .'-'. $order->id }}</div> -->
            <!-- <div><strong>Invoice Date:</strong> {{ date('F j, Y') }}</div> -->
            <div><strong>Order ID:</strong> {{ $order->id }}</div>
            <div><strong>Order Date:</strong> {{ date('F j, Y', strtotime($order->created_at)) }}</div>
            <div><strong>Delivery Method:</strong> {{ $order->data['delivery_method'] }}</div>
            <div><strong>Payment Status:</strong> {{ $order->data['payable'] ? "Incomplete" : 'Completed' }}</div>
        </div>
    </div>

    <div class="table-responsive-sm">
        <table class="table table-sm table-bordered table-hover table-striped mb-0">
            <thead>
                <tr class="head-row">
                    <th class="center">#</th>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th class="center">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->data['products'] as $product)
                <tr>
                    <td class="center">{{ $loop->index + 1 }}</td>
                    <td class="left">{{ $product['name'] }}</td>
                    <td class="center text-uppercase">{{ $product['code'] }}</td>
                    <td class="right">{{ $product['quantity'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-1">
        <div class="col-lg-4 col-sm-5">
            <div class="qr-code">
                {!! $qrcode ?? '' !!}
            </div>
            <p class="my-1 font-weight-bold">Additional Note:</p>
            {!! $order->data['note'] ?? '' !!}
        </div>
        <div class="col-lg-4 col-sm-5 ml-auto">
            <table class="table table-bordered table-sm table-hover table-striped table-sm mb-0">
                <tbody>
                    <tr class="subtotal">
                        <td class="left"><strong>Subtotal</strong></td>
                        <td class="right"><strong>{{ $order->data['sell'] }}</strong></td>
                    </tr>
                    <tr>
                        <td class="left"><strong>Shipping</strong></td>
                        <td class="right">{{ $order->data['shipping'] }}</td>
                    </tr>
                    <tr>
                        <td class="left"><strong>Total</strong></td>
                        <td class="right"><strong>{{ $order->data['sell'] + $order->data['shipping'] }}</strong></td>
                    </tr>
                    <tr>
                        <td class="left"><strong>Advanced</strong></td>
                        <td class="right">{{ $order->data['advanced'] }}</td>
                    </tr>
                    <tr class="payable">
                        <td class="left"><strong>Payable</strong></td>
                        <td class="right"><strong>{{ $order->data['payable'] }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>