<section class="checkout mb-5">
    <form method="POST" action="{{ route('reseller.order.store') }}" id="checkout-form">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Checkout Information</h4>
                    <p class="card-description"> Customer Info </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('customer_name') ? 'has-error': '' }}">
                                <label for="customer-name">
                                    Name<span>*</span>
                                </label>

                                <input type="text" name="customer_name" class="form-control" id="customer-name" value="{{ old('customer_name') }}">

                                {!! $errors->first('customer_name', '<span class="error-message">:message</span>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('customer_phone') ? 'has-error': '' }}">
                                <label for="customer-phone">
                                    Phone<span>*</span>
                                </label>

                                <input type="text" name="customer_phone" class="form-control" id="customer-phone" value="{{ old('customer_phone') }}">

                                {!! $errors->first('customer_phone', '<span class="error-message">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('customer_address') ? 'has-error': '' }}">
                                <label for="customer-address">
                                    Address<span>*</span>
                                </label>

                                <input type="text" name="customer_address" class="form-control" id="customer-address" value="{{ old('customer_address') }}">

                                {!! $errors->first('customer_address', '<span class="error-message">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <p class="card-description"> Order Info</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('shop') ? 'has-error': '' }}">
                                <label for="reseller-shop">
                                    Select Shop<span>*</span>
                                </label>

                                @if($shops->count() == 1)
                                <input type="text" name="shop" id="reseller-shop" class="form-control" value="{{ old('shop') ? $shops->find(old('shop'))->name : $shops->first()->name }}" readonly>
                                <input type="hidden" name="shop" value="{{ old('shop', $shops->first()->id) }}" readonly>
                                @else
                                <select name="shop" id="reseller-shop" class="form-control" @if($shops->count() == 1) readonly @endif>
                                    <option value="">Select Shop</option>
                                    @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}" @if(old('shop') == $shop->id) selected @endif>{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                                @endif

                                {!! $errors->first('shop', '<span class="error-message">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('delivery_method') ? 'has-error': '' }}">
                                <label for="delivery-method">
                                    Delivery Method<span>*</span>
                                </label>

                                @if(count($courier) == 1)
                                <input type="text" name="delivery_method" id="delivery_method" class="form-control" value="{{ old('delivery_method', reset($courier)) }}" readonly>
                                @else
                                <select name="delivery_method" id="delivery_method" class="form-control" @if(count($courier) == 1) readonly @endif>
                                    <option value="">Select Method</option>
                                    @foreach($courier as $name)
                                    <option value="{{ $name }}" @if(old('courier') == $name) selected @endif>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @endif
                                {!! $errors->first('delivery_method', '<span class="error-message">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note">Additional Note</label>
                                <textarea name="note" id="note" cols="30" rows="6" class="form-control">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    @include('reseller.cart.sidebar')
                    <button type="submit" class="btn btn-primary btn-checkout mt-3" data-loading="Loading">
                        Place Order
                    </button>
                  </div>
                </div>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-footer">
            @include('reseller.cart.table')
        </div>
    </div>
</section>