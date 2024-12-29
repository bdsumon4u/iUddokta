@extends('reseller.layout')

@push('styles')
    @livewireStyles
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @livewire('payment-calculator', [
                'reseller' => $reseller,
            ])
        </div>
    </div>
@endsection

@push('scripts')
    @livewireScripts
@endpush
