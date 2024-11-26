@extends('reseller.layout')

@section('styles')
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
    nav > ul.pagination {
        justify-content: space-between;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header"><strong>Activity Logs</strong>
                @if($notifications->count())
                <div class="card-header-actions">
                    <form class="d-inline-block" action="{{ route('reseller.notifications.update') }}" method="post">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success">Mark All As Seen</button>
                    </form>
                    <!-- <form class="d-inline-block" action="{{ route('reseller.notifications.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="delete" value="unread">
                        <button type="submit" class="btn btn-sm btn-danger">Delete Unread</button>
                    </form>
                    <form class="d-inline-block" action="{{ route('reseller.notifications.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="delete" value="read">
                        <button type="submit" class="btn btn-sm btn-danger">Delete Read</button>
                    </form>
                    <form class="d-inline-block" action="{{ route('reseller.notifications.destroy') }}" method="post">
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
                    <div class="card shadow-sm rounded-0">
                        <div class="card-header p-2 {{ $unread ? 'border-red' : 'border--green' }}">
                            <span class="bg-secondary p-1 text-light" style="width: 60px; display: inline-block; text-align: center;">Arrived</span> {{ $notification->created_at->format('F j, Y - h:i A') }}
                            <span class="float-right">{{ $notification->created_at->format('h:i A') }}</span>
                        </div>
                        @unless($unread)
                        <div class="card-header p-2">
                            <span class="bg-secondary p-1 text-light" style="width: 60px; display: inline-block; text-align: center;">Seen</span> {{ $notification->updated_at->format('F j, Y - h:i A') }}
                            <span class="float-right">{{ $notification->updated_at->format('h:i A') }}</span>
                        </div>
                        @endunless
                        <div class="card-body p-2">
                            @php $data = $notification->data @endphp
                            @switch($data['notification'])
                                @case('order-status-changed')
                                    Dear Valuable Reseller,<br>
                                    Your <a target="_blank" href="{{ route('reseller.order.show', $data['order_id']) }}">Order #{{ $data['order_id'] }}</a> Status Has Changed From "{{ ucwords($data['before']) }}" To "{{ ucwords($data['after']) }}".<br>
                                    Stay With Us.<br>
                                    Thank You.
                                @break

                                @case('money-request-recieved')
                                    Dear Valuable Reseller,<br>
                                    Your <strong>Money Request #{{ $data['transaction_id'] }}</strong> For <strong>Amount {{ theMoney($data['amount']) }}</strong><br>
                                    Via <strong>{{ $data['method'] }}{{ $data['bank_name'] ? ' [ '. $data['bank_name'] . ' ] ' : '' }}<br>
                                    {{ $data['account_name'] ? ' [ '. $data['account_name'] . ' ] ' : '' }} [ {{ $data['account_type'] }} ] [ {{ $data['account_number'] }} ]</strong><br>
                                    Has Recieved.<br>
                                    Stay With Us.<br>
                                    Thank You.
                                @break

                                @case('transaction-completed')
                                    Dear Valuable Reseller,<br>
                                    @if($data['type'] == 'request')
                                    Your <strong>Money Request #{{ $data['transaction_id'] }}</strong> For <strong>Amount {{ theMoney($data['amount']) }}</strong><br>
                                    Has Paid.<br>
                                    @else
                                    You're Paid <strong>Amount {{ theMoney($data['amount']) }}</strong><br>
                                    @endif
                                    Via <strong>{{ $data['method'] }}{{ $data['bank_name'] ? ' [ '. $data['bank_name'] . ' ] ' : '' }}<br>
                                    {{ $data['account_name'] ? ' [ '. $data['account_name'] . ' ] ' : '' }} [ {{ $data['account_type'] }} ] [ {{ $data['account_number'] }} ]</strong><br>
                                    Based On Your Completed & Returned Orders<br>
                                    From {{ date('d-M-Y', strtotime($timezone[0])) }} To {{ date('d-M-Y', strtotime($timezone[1])) }}<br>
                                    Stay With Us.<br>
                                    Thank You.
                                @break
                            @endswitch
                        </div>
                        @if($unread) {{-- After Pagination To Log --}}
                        <div class="card-footer p-2">
                            <div class="d-flex justify-content-between">
                                <!-- <div class="col-md-6"> -->
                                    @if($unread)
                                    <form action="{{ route('reseller.notifications.update', $notification->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Mark As Seen</button>
                                    </form>
                                    @endif
                                <!-- </div> -->
                                <!-- <div class="col-md-6"> -->
                                    <!-- <form action="{{ route('reseller.notifications.destroy', $notification->id) }}" method="post">
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
                <div class="alert alert-danger mb-0"><strong>Log Box Is Empty!</strong></div>
                @endforelse
                {!! $notifications->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection