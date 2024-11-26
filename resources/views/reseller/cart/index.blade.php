@extends('reseller.products.layout')

@section('content')
<div class="row">
    <div class="cart-list-wrapper clearfix">
        @livewire('live-cart', [
            'type' => 'cart',
            'cart' => $cart->toArray()
        ])
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        calculate();
        function calculate () {
            var shipping = parseInt($('[name="shipping"]').val()),
                buy_price = parseInt($('[name="buy_price"]').val()),
                sell = parseInt($('[name="sell"]').val()),
                packaging = parseInt($('[name="packaging"]').val()),
                delivery_charge = parseInt($('[name="delivery_charge"]').val()),
                additional = parseInt($('[name="cod_charge"]').val()),
                $profit = $('[name="profit"]');
            
            $profit.val(
                sell - buy_price - packaging - delivery_charge - additional + shipping
            );
        }
        $('[type="text"]').keyup(calculate);
    });
</script>
@endsection