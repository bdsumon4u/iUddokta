@extends('reseller.products.layout')

@push('styles')
    @livewireStyles
@endpush

@section('content')
    @livewire('live-cart', [
        'type' => 'checkout',
        'sell' => $sell,
        'shipping' => $shipping,
        'advanced' => $advanced,
        'discount' => $discount,
        'cart' => $cart->toArray(),
    ])
@endsection

@push('scripts')
    @livewireScripts
@endpush
