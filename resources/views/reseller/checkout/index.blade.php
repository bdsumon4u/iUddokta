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
        'cart' => $cart->toArray(),
    ])
@endsection

@push('scripts')
    @livewireScripts
@endpush
