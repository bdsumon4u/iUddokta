@component('mail::message')
# Dear Valuable reseller,

@if($type == 'request')
Your <strong>Money Request #{{ $data['id'] }}</strong> For <strong>Amount {{ theMoney($data['amount']) }}</strong><br>
Has Paid.<br>
@else
You're Paid <strong>Amount {{ theMoney($data['amount']) }}</strong><br>
@endif
Via <strong>{{ $data['method'] }}{{ isset($data['bank_name']) ? ' [ '. $data['bank_name'] . ' ] ' : '' }}<br>
{{ isset($data['account_name']) ? ' [ '. $data['account_name'] . ' ] ' : '' }}
[ {{ $data['account_type'] }} ] [ {{ $data['account_number'] }} ]</strong><br>
Based On Your Completed & Returned Orders
From {{ date('d-M-Y', strtotime($timezone[0])) }} To {{ date('d-M-Y', strtotime($timezone[1])) }}<br>
### Orders:
@component('mail::table')
| ID           | Status      | Date |
| :----------- | :-------------:| ------------:|
@foreach($orders as $order)
|[{{$order->id}}]({{route('reseller.order.show',$order->id)}})| {{ucwords($order->status)}} | {{date('d-M-Y',strtotime($order->data[$order->status . '_at']))}} |
@endforeach
@endcomponent
Stay With Us.<br>

Thank you for using our application!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
