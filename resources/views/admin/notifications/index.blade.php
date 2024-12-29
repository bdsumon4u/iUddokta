@extends('layouts.ready')

@push('styles')
    <style>
        .border-top-red {
            border-top: 2px solid red;
        }

        .border-top-green {
            border-top: 2px solid green;
        }

        .border-red {
            border: 2px solid red;
        }

        .border-green {
            border: 2px solid green;
        }

        nav>ul.pagination {
            justify-content: space-between;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="shadow-sm card rounded-0">
                <div class="card-header"><strong>Activity Logs</strong>
                    @if ($notifications->count())
                        <div class="card-header-actions">
                            <form class="d-inline-block" action="{{ route('admin.notifications.update') }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Mark All As Seen</button>
                            </form>
                            <!-- <form class="d-inline-block" action="{{ route('admin.notifications.destroy') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="delete" value="unread">
                            <button type="submit" class="btn btn-sm btn-danger">Delete Unread</button>
                        </form>
                        <form class="d-inline-block" action="{{ route('admin.notifications.destroy') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="delete" value="read">
                            <button type="submit" class="btn btn-sm btn-danger">Delete Read</button>
                        </form>
                        <form class="d-inline-block" action="{{ route('admin.notifications.destroy') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete All</button>
                        </form> -->
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @forelse($notifications as $notification)
                        @php $unread = $notification->unread() @endphp
                        <div class="shadow-sm card rounded-0">
                            <div class="card-header p-2 {{ $unread ? 'border-red' : 'border--green' }}">
                                <span class="p-1 bg-secondary text-light"
                                    style="width: 60px; display: inline-block; text-align: center;">Arrived</span>
                                {{ $notification->created_at->format('F j, Y - h:i A') }}
                                <span class="float-right">{{ $notification->created_at->format('h:i A') }}</span>
                            </div>
                            @unless ($unread)
                                <div class="p-2 card-header">
                                    <span class="p-1 bg-secondary text-light"
                                        style="width: 60px; display: inline-block; text-align: center;">Seen</span>
                                    {{ $notification->updated_at->format('F j, Y - h:i A') }}
                                    <span class="float-right">{{ $notification->updated_at->format('h:i A') }}</span>
                                </div>
                            @endunless
                            <div class="p-2 card-body">
                                @php $data = $notification->data @endphp
                                @switch($data['notification'])
                                    @case('money-request-recieved')
                                        A New <strong>Money Request #{{ $data['transaction_id'] }}</strong> For <strong>Amount
                                            {{ theMoney($data['amount']) }}</strong><br>
                                        @php $reseller = \App\Models\Reseller::findOrFail($data['reseller_id']) @endphp
                                        From Reseller <a
                                            href="{{ route('admin.resellers.show', $reseller->id) }}">{{ $reseller->name }}</a> [
                                        Balance: <strong>{{ theMoney($reseller->balance) }}</strong> ]<br>
                                        Via <strong>{{ $data['method'] }}{{ $data['bank_name'] ? ' [ ' . $data['bank_name'] . ' ] ' : '' }}<br>
                                            {{ $data['account_name'] ? ' [ ' . $data['account_name'] . ' ] ' : '' }} [
                                            {{ $data['account_type'] }} ] [ {{ $data['account_number'] }} ]</strong><br>
                                        Has Recieved.<br>
                                        @php $transaction = \App\Models\Transaction::findOrFail($data['transaction_id']) @endphp
                                        <hr class="my-1">
                                        <div class="d-flex justify-content-center">
                                            @if ($transaction->status == 'pending')
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('admin.transactions.pay-to-reseller', [
                                                        $data['reseller_id'],
                                                        'transaction_id' => $transaction->id,
                                                        'amount' => $data['amount'],
                                                        'method' => $data['method'],
                                                        'bank_name' => $data['bank_name'],
                                                        'account_name' => $data['account_name'],
                                                        'branch' => $data['branch'],
                                                        'routing_no' => $data['routing_no'],
                                                        'account_type' => $data['account_type'],
                                                        'account_number' => $data['account_number'],
                                                    ]) }}">Pay
                                                    Now</a>
                                            @else
                                                <span class="p-2 badge badge-secondary text-light">Paid</span>
                                            @endif
                                        </div>
                                    @break

                                    @case('new-order-recieved')
                                        @if ($order = \App\Models\Order::find($data['order_id']))
                                            A New Order From Reseller <a
                                                href="{{ route('admin.resellers.show', $data['reseller_id']) }}">{{ $data['reseller_name'] }}</a>
                                            [ Phone: <strong>{{ $data['reseller_phone'] }}</strong> ] [ Balance:
                                            <strong>{{ theMoney($data['reseller_balance']) }}</strong> ]<br>
                                            For Products:
                                            <ul class="my-2">
                                                @foreach ($order->data['products'] as $product)
                                                    <li><a
                                                            href="{{ route('admin.products.show', $product['id']) }}">{{ $product['name'] }}</a>
                                                        [Qty: {{ $product['quantity'] }}]</li>
                                                @endforeach
                                            </ul>
                                            Has Recieved.<br>
                                            <hr class="my-1">
                                            <div class="d-flex justify-content-center">
                                                @if ($order->status == 'pending')
                                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                                        class="btn btn-sm btn-primary">View Details</a>
                                                @else
                                                    <span class="p-2 badge badge-secondary text-light">Accepted</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-danger">A New Order Has Cancelled.</span>
                                        @endif
                                    @break
                                @endswitch
                            </div>
                            @if ($unread)
                                {{-- After Pagination To Log --}}
                                <div class="p-2 card-footer">
                                    <div class="d-flex justify-content-between">
                                        <!-- <div class="col-md-6"> -->
                                        @if ($unread)
                                            <form action="{{ route('admin.notifications.update', $notification->id) }}"
                                                method="post">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success">Mark As Seen</button>
                                            </form>
                                        @endif
                                        <!-- </div> -->
                                        <!-- <div class="col-md-6"> -->
                                        <!-- <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form> -->
                                        <!-- </div> -->
                                    </div>
                                </div>
                            @endif
                        </div>
                        @empty
                            <div class="mb-0 alert alert-danger"><strong>Log Box Is Empty!</strong></div>
                        @endforelse
                        {!! $notifications->links() !!}
                    </div>
                </div>
            </div>
        </div>
    @endsection
