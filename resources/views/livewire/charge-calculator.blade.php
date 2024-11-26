<div class="wizard">
    @php $is_reseller = ($user = auth('reseller')->user()) && ($user->id ?? 0) == request()->user('reseller')->id @endphp
    <form action="{{ route('admin.order.update', $order->id) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shipping">
                        Shipping<span>*</span>
                    </label>

                    <input type="text" name="shipping" class="form-control" id="shipping" value="{{ $shipping }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="advanced">
                        Advanced<span>*</span>
                    </label>

                    <input type="text" name="advanced" class="form-control" id="advanced" value="{{ $advanced }}" readonly>
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

                    <input type="text" name="buy_price" wire:model.debounce.250ms="buy_price" wire:change="changed" class="form-control" id="buy-price" value="{{ old('buy_price') }}" {{ $is_reseller ? 'readonly' : '' }}>

                    {!! $errors->first('buy_price', '<span class="error-message">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('sell') ? 'has-error': '' }}">
                    <label for="sell-price">
                        Sell<span>*</span>
                    </label>

                    <input type="text" name="sell" wire:model.debounce.250ms="sell" class="form-control" id="sell-price" value="{{ old('sell') }}" readonly>

                    {!! $errors->first('sell', '<span class="error-message">:message</span>') !!}
                </div>
            </div>
            @if(! $is_reseller || ($is_reseller && ($order->status == 'completed' | $order->status == 'returned')))
                <div class="col-sm-12 box-header">
                    <h5><span>Charges</span></h5>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('packaging') ? 'has-error': '' }}">
                        <label for="packaging-charge">
                            Packaging
                        </label>
                        
                        <input type="text" name="packaging" wire:model.debounce.250ms="packaging" wire:change="changed" class="form-control" id="packaging-charge" value="{{ old('packaging', $packaging) }}" {{ $is_reseller ? 'readonly' : '' }}>
                        
                        {!! $errors->first('packaging', '<span class="error-message">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('delivery_charge') ? 'has-error': '' }}">
                        <label for="delivery-charge">
                            Delivery<span>*</span>
                        </label>

                        <input type="text" name="delivery_charge" wire:model.debounce.250ms="delivery_charge" wire:change="changed" class="form-control" id="delivery-charge" value="{{ old('delivery_charge') }}" {{ $is_reseller ? 'readonly' : '' }}>

                        {!! $errors->first('delivery_charge', '<span class="error-message">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('cod_charge') ? 'has-error': '' }}">
                        <label for="cod-charge">
                            Additional<span>*</span>
                        </label>

                        <input type="text" name="cod_charge" wire:model.debounce.250ms="cod_charge" wire:change="changed" class="form-control" id="cod-charge" value="{{ old('cod_charge', $cod_charge) }}" {{ $is_reseller ? 'readonly' : '' }}>

                        {!! $errors->first('cod_charge', '<span class="error-message">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('payable') ? 'has-error': '' }}">
                        <label for="payable">
                            Payable
                        </label>

                        <input type="text" name="payable" class="form-control" id="payable" value="{{ old('payable', $payable) }}" readonly>

                        {!! $errors->first('payable', '<span class="error-message">:message</span>') !!}
                    </div>
                </div>
                @unless($order->status == 'returned')
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('profit') ? 'has-error': '' }}">
                            <label for="profit">
                                Profit
                            </label>

                            <input type="text" name="profit" class="form-control" id="profit" value="{{ old('profit', $profit) }}" readonly>

                            {!! $errors->first('profit', '<span class="error-message">:message</span>') !!}
                        </div>
                    </div>
                    @else
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loss">
                                Loss
                            </label>

                            <input type="text" name="loss" class="form-control bg-danger" id="loss" value="{{ old('loss', $loss) }}" readonly>
                        </div>
                    </div>
                @endunless
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
                <div class="d-flex mt-2 justify-content-between">
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
                    @method('DELETE')
                    <button type="submit" formaction="{{ route('reseller.order.destroy', $order->id) }}" class="btn btn-danger ml-1">Cancel</button>
                @endunless
            </div>
            @endunless
        </div>
    </form>
</div>