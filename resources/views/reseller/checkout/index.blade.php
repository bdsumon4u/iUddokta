@extends('reseller.products.layout')

@section('styles')
@livewireStyles
@endsection

@section('content')
@livewire('live-cart', [
    'type' => 'checkout',
    'sell' => $sell,
    'shipping' => $shipping,
    'advanced' => $advanced,
    'cart' => $cart->toArray()
])
@endsection

@section('scripts')
@livewireScripts
@endsection