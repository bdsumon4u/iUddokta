@extends('layouts.ready')

@push('styles')
    @livewireStyles
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @livewire('payment-calculator', [
                'reseller' => $reseller,
                'amount' => request('amount'),
                'method' => request('method'),
            ])
        </div>
    </div>
@endsection

@push('scripts')
    @livewireScripts
    <script>
        $(document).ready(function() {
            $(document).on('keyup', '[name="amount"]', function() {
                $('.balance').text('Balance: ' + (Number($(this).data('balance')) - Number($(this).val())))
            });
        });
    </script>
@endpush
