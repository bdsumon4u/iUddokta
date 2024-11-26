<div>
    @if($success)
    <div class="alert alert-success fade in clearfix">
        <button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
        <div class="alert-icon">
            <i class="fa fa-check" aria-hidden="true"></i>
        </div>
        <span class="alert-text">{{ $success }}</span>
    </div>
    @endif
    @if(count($cart) == 0)
    <h2 class="text-center">Your Cart is Empty!</h2>
    @else
        @switch($type)
            @case('cart')
                @include('reseller.cart.content')
                @break
            @case('checkout')
                @include('reseller.checkout.content')
                @break
        @endswitch
    @endif
</div>