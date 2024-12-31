
<h3>Cart Totals</h3>

<h5 class="item-amount">
    <label for="">Buy Price</label>
    <span>{{ $subTotal }}</span>
</h5>

<div>
    <div class="form-group charge-box @error('sell') mb-0 has-error @enderror">
        <label for="sell-price">Sell Price: <span>*</span></label>
        <input type=" text" class="form-control" name="sell" value="{{ old('sell', $sell) }}" id="sell-price" onfocus="$(this).select();">
    </div>
    {!! $errors->first('sell', '<div class="error-message" style="margin-top: 0; margin-bottom: .5rem;">:message</div>') !!}
</div>
<div class="form-group">
    <label for="shipping-charge">Shipping Cost: <span>*</span></label>
    <div class="h-auto form-control">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="inside-dhaka" name="shipping_area" value="inside_dhaka" checked>
            <label class="custom-control-label" for="inside-dhaka">ঢাকা শহর ({{auth('reseller')->user()->shop->inside_dhaka}} টাকা) </label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="outside-dhaka" name="shipping_area" value="outside_dhaka">
            <label class="custom-control-label" for="outside-dhaka">ঢাকার বাইরে ({{auth('reseller')->user()->shop->outside_dhaka}} টাকা) </label>
        </div>
    </div>
</div>
<div>
    <div class="form-group charge-box @error('advanced') mb-0 has-error @enderror">
        <label for="advanced">Advanced: <span>*</span></label>
        <input type=" text" class="form-control" name="advanced" value="{{ old('advanced', $advanced ?? 0) }}" id="advanced" onfocus="$(this).select();">
    </div>
    {!! $errors->first('advanced', '<div class="error-message" style="margin-top: 0; margin-bottom: .5rem;">:message</div>') !!}
</div>
<div>
    <div class="form-group charge-box @error('discount') mb-0 has-error @enderror">
        <label for="discount">Discount: <span>*</span></label>
        <input type=" text" class="form-control" name="discount" value="{{ old('discount', $discount ?? 0) }}" id="discount" onfocus="$(this).select();">
    </div>
    {!! $errors->first('discount', '<div class="error-message" style="margin-top: 0; margin-bottom: .5rem;">:message</div>') !!}
</div>