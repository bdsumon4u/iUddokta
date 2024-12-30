@extends('reseller.layout')

@push('styles')
    @livewireStyles
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @livewire('payment-calculator', [
                'reseller' => $reseller,
                'method' => current($reseller->payment_methods ?? [])->method ?? null,
            ])
        </div>
    </div>
@endsection

@push('scripts')
    @livewireScripts
@endpush
