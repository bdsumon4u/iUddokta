@extends('reseller.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card rounded-0">
            <div class="card-header">
                <strong>Transaction Completed [{{ date('d-M-Y', strtotime($data['created_at'])) }}]</strong>
            </div>
            <div class="card-body">
                <strong>Dear Valuable reseller</strong>,

                You're Paid <strong>Amount {{ theMoney($data['amount']) }}</strong><br>
                Via <strong>{{ $data['method'] }}{{ isset($data['bank_name']) ? ' [ '. $data['bank_name'] . ' ] ' : '' }}<br>
                {{ isset($data['account_name']) ? ' [ '. $data['account_name'] . ' ] ' : '' }}
                [ {{ $data['account_type'] }} ] [ {{ $data['account_number'] }} ]</strong><br>
                Based On Your Completed & Returned Orders
                From {{ date('d-M-Y', strtotime($timezone[0])) }} To {{ date('d-M-Y', strtotime($timezone[1])) }}<br>
                <h5 class="mt-2">Orders:</h5>
                @include('transaction')
                Stay With Us.<br>

                Thank you for using our application!

                Thanks,<br>
                {{ config('app.name') }}
            </div>
        </div>
    </div>
</div>
@endsection