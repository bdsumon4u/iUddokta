@section('styles')
<style>
    .box-header h5 {
        margin: 0 5px 15px 5px;
    }
    .box-header h5 span {
        border-bottom: 3px double #d9d9d9;
    }
</style>
@endsection

@section('content')
@php
    $is_reseller = ($user = auth('reseller')->user()) && ($user->id ?? 0) == request()->user('reseller')->id;
    $a_only = $is_reseller ? 'readonly' : '';
    $r_only = $is_reseller ? '' : 'readonly';

    $data = $order->data;
    unset($data['products']);
    extract($data);
    $buy_price = $buy_price ?? $price;
    $delivery_charge = $delivery_charge ?? 100;
    $cod_charge = $cod_charge ?? 0;
    $profit = $profit ?? 0;
    $booking_number = $booking_number ?? '';
@endphp
<form action="{{ route('admin.order.update', $order->id) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-8 mx-auto mb-5">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <strong>Order Details</strong>
                    <span class="badge text-uppercase badge-{{$variant}}">{{ $order->status }}</span>
                    <a href="{{ url()->current() }}/invoice" class="btn btn-sm btn-primary card-header-action">Invoice</a>
                </div>
                <div class="card-body">
                    <div class="wizard">
                        <div id="" class="" role="tabpanel">
                            <div class="row box-wrapper address clearfix">
                                <div class="col-sm-12 box-header">
                                    <h5><span>Reseller Info</span></h5>
                                </div>
                                @php $reseller = $order->reseller @endphp
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('reseller_name') ? 'has-error': '' }}">
                                        <label for="reseller-name">
                                            Name
                                        </label>

                                        <input type="text" name="reseller_name" class="form-control" id="reseller-name" value="{{ old('reseller_name', $reseller->name) }}" readonly>

                                        {!! $errors->first('reseller_name', '<span class="error-message">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('shop') ? 'has-error': '' }}">
                                        <label for="reseller-shop">
                                            Shop
                                        </label>

                                        <input type="text" name="shop" class="form-control" id="reseller-shop" value="{{ $order->shop->name }}" readonly>

                                        {!! $errors->first('shop', '<span class="error-message">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('reseller_email') ? 'has-error': '' }}">
                                        <label for="reseller-email">
                                            Email
                                        </label>

                                        <input type="text" name="reseller_email" class="form-control" id="reseller-email" value="{{ old('reseller_email', $reseller->email) }}" readonly>

                                        {!! $errors->first('reseller_email', '<span class="error-message">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('reseller_phone') ? 'has-error': '' }}">
                                        <label for="reseller-phone">
                                            Phone
                                        </label>

                                        <input type="text" name="reseller_phone" class="form-control" id="reseller-phone" value="{{ old('reseller_phone', $reseller->phone) }}" readonly>

                                        {!! $errors->first('reseller_phone', '<span class="error-message">:message</span>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row box-wrapper address clearfix">
                                        <div class="col-sm-12 box-header">
                                            <h5><span>Customer Info</span></h5>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group {{ $errors->has('customer_name') ? 'has-error': '' }}">
                                                <label for="customer-name">
                                                    Name
                                                </label>

                                                <input type="text" name="customer_name" class="form-control" id="customer-name" value="{{ old('customer_name', $order->data['customer_name']) }}" {{ $a_only }}>

                                                {!! $errors->first('customer_name', '<span class="error-message">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group {{ $errors->has('customer_phone') ? 'has-error': '' }}">
                                                <label for="customer-phone">
                                                    Phone
                                                </label>

                                                <input type="text" name="customer_phone" class="form-control" id="customer-phone" value="{{ old('customer_phone', $order->data['customer_phone']) }}" {{ $a_only }}>

                                                {!! $errors->first('customer_phone', '<span class="error-message">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group {{ $errors->has('customer_address') ? 'has-error': '' }}">
                                                <label for="customer-address">
                                                    Address
                                                </label>

                                                <input type="text" name="customer_address" class="form-control" id="customer-address" value="{{ old('customer_address', $order->data['customer_address']) }}" {{ $a_only }}>

                                                {!! $errors->first('customer_address', '<span class="error-message">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group {{ $errors->has('note') ? 'has-error': '' }}">
                                                <label for="note">
                                                    Additional Note
                                                </label>

                                                <textarea name="note" class="form-control" id="note" rows="6" cols="30" {{ $a_only }}>{{ old('note', $order->data['note'] ?? '') }}</textarea>

                                                {!! $errors->first('note', '<span class="error-message">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shipping">
                                                    Shipping<span>*</span>
                                                </label>

                                                <input type="text" name="shipping" class="form-control" id="shipping" value="{{ $shipping }}" {{ $a_only }}>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="advanced">
                                                    Advanced<span>*</span>
                                                </label>

                                                <input type="text" name="advanced" class="form-control" id="advanced" value="{{ $advanced }}" {{ $a_only }}>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 box-header">
                                            <h5><span>Prices</span></h5>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="current-price">
                                                    Current
                                                </label>

                                                <input type="text" name="" class="form-control" id="current-price" value="{{ $cp }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('buy_price') ? 'has-error': '' }}">
                                                <label for="buy-price">
                                                    Buy<span>*</span>
                                                </label>

                                                <input type="text" name="buy_price" wire:model.debounce.250ms="buy_price" wire:change="changed" class="form-control" id="buy-price" value="{{ old('buy_price', $buy_price) }}" {{ $a_only }}>

                                                {!! $errors->first('buy_price', '<span class="error-message">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('sell') ? 'has-error': '' }}">
                                                <label for="sell-price">
                                                    Sell<span>*</span>
                                                </label>

                                                <input type="text" name="sell" wire:model.debounce.250ms="sell" class="form-control" id="sell-price" value="{{ old('sell', $sell) }}" {{ $a_only }}>

                                                {!! $errors->first('sell', '<span class="error-message">:message</span>') !!}
                                            </div>
                                        </div>
                                        @if(! $is_reseller || ($is_reseller && ($order->status == 'completed' | $order->status == 'returned')))
                                            @php $quantity = 0; foreach ($order->data['products'] as $item) $quantity += $item['quantity']; @endphp
                                            <div class="col-sm-12 box-header">
                                                <h5><span>Charges</span></h5>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {{ $errors->has('packaging') ? 'has-error': '' }}">
                                                    <label for="packaging-charge">
                                                        Packaging
                                                    </label>

                                                    <input type="text" name="packaging" wire:model.debounce.250ms="packaging" wire:change="changed" class="form-control" id="packaging-charge" value="{{ old('packaging', $packaging ?? $quantity * 20) }}" {{ $a_only }}>

                                                    {!! $errors->first('packaging', '<span class="error-message">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {{ $errors->has('delivery_charge') ? 'has-error': '' }}">
                                                    <label for="delivery-charge">
                                                        Delivery Charge
                                                    </label>

                                                    <input type="text" name="delivery_charge" wire:model.debounce.250ms="delivery_charge" wire:change="changed" class="form-control" id="delivery-charge" value="{{ old('delivery_charge', $delivery_charge) }}" {{ $a_only }}>

                                                    {!! $errors->first('delivery_charge', '<span class="error-message">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {{ $errors->has('cod_charge') ? 'has-error': '' }}">
                                                    <label for="cod-charge">
                                                        COD / Return
                                                    </label>

                                                    <input type="text" name="cod_charge" wire:model.debounce.250ms="cod_charge" wire:change="changed" class="form-control" id="cod-charge" value="{{ old('cod_charge', $cod_charge) }}" {{ $a_only }}>

                                                    {!! $errors->first('cod_charge', '<span class="error-message">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {{ $errors->has('payable') ? 'has-error': '' }}">
                                                    <label for="payable">
                                                        Payable
                                                    </label>

                                                    <input type="text" name="payable" class="form-control" id="payable" value="{{ old('payable', $payable) }}" readonly>

                                                    {!! $errors->first('payable', '<span class="error-message">:message</span>') !!}
                                                </div>
                                            </div>
                                            @php $loss = ($packaging ?? $quantity * 20) + $delivery_charge + $cod_charge - $data['advanced'] @endphp
                                            @unless($order->status == 'returned')
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('profit') ? 'has-error': '' }}">
                                                        <label for="profit">
                                                            Profit
                                                        </label>

                                                        <input type="text" name="profit" class="form-control" id="profit" value="{{ old('profit', $profit) }}" readonly>

                                                        {!! $errors->first('profit', '<span class="error-message">:message</span>') !!}
                                                    </div>
                                                </div>
                                                @else
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="loss">
                                                            Loss
                                                        </label>

                                                        <input type="text" name="loss" class="form-control bg-danger" id="loss" value="{{ old('loss', $loss) }}" readonly>
                                                    </div>
                                                </div>
                                            @endunless
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="receivable">
                                                        Receivable
                                                    </label>

                                                    <input type="text" name="receivable" class="form-control" id="receivable" data-loss="{{ $loss }}" data-status="{{ $order->status }}" value="{{ old('receivable', $order->status == 'returned' ? - ($loss + $order->data['advanced']) : ($profit - $order->data['advanced'])) }}" readonly>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <div class="form-group {{ $errors->has('delivery_method') ? 'has-error': '' }}">
                                                <label for="delivery-method">
                                                    Delivery Method
                                                </label>

                                                @if(count($courier) == 1)
                                                <input type="text" name="delivery_method" id="delivery_method" class="form-control" value="{{ old('delivery_method', reset($courier)) }}" readonly>
                                                @else
                                                <select name="delivery_method" id="delivery_method" class="form-control" @if(count($courier) == 1) readonly @endif @if($is_reseller) disabled @endif>
                                                    <option value="">Select Method</option>
                                                    @foreach($courier as $name)
                                                    <option value="{{ $name }}" @if(old('delivery_method', $order->data['delivery_method']) == $name) selected @endif>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                                {!! $errors->first('delivery_method', '<span class="error-message">:message</span>') !!}
                                            </div>
                                        </div>
                                        @unless($order->status == 'pending')
                                        <div class="col-md-12">
                                            <div class="form-group {{ $errors->has('booking_number') ? 'has-error': '' }}">
                                                <label for="booking_number">
                                                    Booking Number
                                                </label>

                                                <input type="text" name="booking_number" class="form-control" id="booking_number" value="{{ old('booking_number', $booking_number) }}" @if($is_reseller) readonly @endif>

                                                {!! $errors->first('booking_number', '<span class="error-message">:message</span>') !!}
                                            </div>
                                        </div>
                                        @endunless
                                        @unless($order->status == 'completed' || $order->status == 'returned')
                                        <div class="col-md-12">
                                            @unless($is_reseller)
                                            <div class="d-flex justify-content-end">
                                                @if($order->status == 'pending')
                                                <input type="hidden" name="status" value="processing">
                                                @else
                                                <select name="status" id="status" class="form-control mr-1">
                                                    @foreach(config('order.statuses') as $status)
                                                    <option value="{{ $status }}" @if($status == $order->status) selected @endif class="text-capitalize">{{ ucfirst($status) }}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                                <button type="submit" class="btn btn-success ml-1">{{ $order->status == 'pending' ? 'Accept' : 'Update' }}</button>
                                            </div>
                                            @elseif($order->status == 'pending')
                                                <div class="d-flex justify-content-end">
                                                    @method('DELETE')
                                                    <button type="submit" formaction="{{ route('reseller.order.destroy', $order->id) }}" class="btn btn-danger ml-1">Cancel</button>
                                                </div>
                                            @endunless
                                        </div>
                                        @endunless
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card rounded-sm border-0">
                <div class="card-body">
                    <div class="row box-wrapper address clearfix">
                        <div class="col-sm-12 box-header">
                            <br>
                            <h5><span>Ordered Products</span></h5>
                        </div>
                        <div class="order-products table-responsive">
                            <table class="table table-bordered table-stripped table-hover table-narrow">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Price[<small class="uppercase">WHOLESALE</small>]</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->data['products'] as $item)
                                    @php
                                        $quantity = 0;
                                        $pw = $products->find($item['id'])->wholesale;
                                        $iw = $item['wholesale'];
                                    @endphp
                                    <tr>
                                        <td><a class="text-uppercase" href="{{ $is_reseller ? route('reseller.product.show', $item['slug']) : route('admin.products.show', $item['id']) }}">{{ $item['code'] }}</a></td>
                                        <td>
                                            <strong>Buy: </strong>{{ $iw }}
                                            @if($iw != $pw)
                                            <br>
                                            <strong>Current: </strong>{{ $pw }}
                                            @endif
                                        </td>
                                        <td>
                                            @php $quantity += $item['quantity'] @endphp
                                            {{ $item['quantity'] }}
                                        </td>
                                        <td>
                                            <strong>Buy: </strong>{{ $iw * $item['quantity'] }}
                                            @if($iw != $pw)
                                            <br>
                                            <strong>Current: </strong>{{ $pw * $item['quantity'] }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"><strong class="float-right">Total[<small class="uppercase">WHOLESALE</small>]</strong></td>
                                        <td>
                                            <strong>Buy: </strong>{{ $order->data['price'] }}
                                            @if($order->data['price'] != $cp)
                                            <br>
                                            <strong>Current:</strong> {{ $cp }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        calculate();
        function calculate () {
            var advanced = $('[name="advanced"]').val()
                shipping = parseInt($('[name="shipping"]').val()),
                buy_price = parseInt($('[name="buy_price"]').val()),
                sell = parseInt($('[name="sell"]').val()),
                packaging = parseInt($('[name="packaging"]').val()),
                delivery_charge = parseInt($('[name="delivery_charge"]').val()),
                additional = parseInt($('[name="cod_charge"]').val()),
                $profit = $('[name="profit"]'),
                $receivable = $('[name="receivable"]')
                status = $receivable.data('status');

            $profit.val(
                sell - buy_price - packaging - delivery_charge - additional + shipping
            );

            $receivable.val(
                status == 'returned' ? -(Number(advanced) + $receivable.data('loss')) : (Number($profit.val()) - Number(advanced))
            )
        }
        $('[type="text"]').keyup(calculate);
    });
</script>
@endsection
