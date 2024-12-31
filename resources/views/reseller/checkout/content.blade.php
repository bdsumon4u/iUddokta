<section class="mb-5 checkout">
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
                    <input type="hidden" name="shop" value="{{ old('shop', $shops->first()->id) }}" readonly>
                    <input type="hidden" name="delivery_method" id="delivery_method" class="form-control" value="Pathao" readonly>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">City</label><span>*</span>
                            <select name="city_id" class="form-control" wire:model.live="city_id">
                                <option value="" selected>Select City</option>
                                @foreach ($this->getCityList() as $city)
                                    <option value="{{ $city->city_id }}">
                                        {{ $city->city_name }}
                                    </option>
                                @endforeach
                            </select>
                            {!! $errors->first('city_id', '<span class="error-message">:message</span>') !!}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Area</label><span>*</span>
                            <div wire:loading.class="d-flex" wire:target="city_id" class="d-none h-100 align-items-center">
                                Loading Area...
                            </div>
                            <input type="hidden" name="area_id" value="{{ old('area_id', $area_id ?? '') }}">
                            <select wire:loading.remove wire:target="city_id" class="form-control" wire:model.live="area_id">
                                <option value="" selected>Select Area</option>
                                @foreach ($this->getAreaList() as $area)
                                    <option value="{{ $area->zone_id }}">
                                        {{ $area->zone_name }}
                                    </option>
                                @endforeach
                            </select>
                            {!! $errors->first('area_id', '<span class="error-message">:message</span>') !!}
                        </div>
                        <div class="col-md-4">
                            <label for="weight" class="mb-0">Weight</label>
                            <input type="number" value="0.5" class="form-control" placeholder="Weight in KG">
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
                    <button type="submit" class="mt-3 btn btn-primary btn-checkout" data-loading="Loading">
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