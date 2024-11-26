@component('mail::message')
# Dear Valuable reseller,

Your <strong>Money Request #{{ $data['id'] }}</strong> For <strong>Amount {{ theMoney($data['amount']) }}</strong><br>
Via <strong>{{ $data['method'] }}{{ isset($data['bank_name']) ? ' [ '. $data['bank_name'] . ' ] ' : '' }}{{ isset($data['account_name']) ? ' [ '. $data['account_name'] . ' ] ' : '' }}
[ {{ $data['account_type'] }} ] [ {{ $data['account_number'] }} ]</strong><br>
Has Recieved.<br>
Stay With Us.<br>

Thank you for using our application!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
