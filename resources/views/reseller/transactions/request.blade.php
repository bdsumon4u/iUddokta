@extends('reseller.layout')

@section('styles')
@livewireStyles
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @livewire('payment-calculator', [
            'reseller' => $reseller,
        ])
    </div>
</div>
@endsection

@section('scripts')
@livewireScripts
@endsection