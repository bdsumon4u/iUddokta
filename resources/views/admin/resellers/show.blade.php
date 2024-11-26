@extends('layouts.ready')

@section('content')
<div class="row fade-in justify-content-center">
    <div class="col-md-8">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header">Profile: <strong>{{ $reseller->name }}</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <h5>Personal Info</h5>
                            <table class="table table-sm table-borderless table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $reseller->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $reseller->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $reseller->phone }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img class="m-2" src="{{ asset(optional($reseller->documents)->photo) }}" alt="Photo" style="height: 100%; max-height: 200px; width: 100%; max-width: 200px;">
                    </div>
                </div>
                <div class="table-responsive">
                    <h5>Account Info</h5>
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <tbody>
                            <tr>
                                <th class="text-nowrap">Total Orders:</th>
                                <td>{{ theMoney($reseller->total_sell) }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap"><a href="{{ route('admin.order.index', ['status' => 'pending', 'reseller' => $reseller->id]) }}">Pending Orders</a>:</th>
                                <td>{{ theMoney($reseller->pending_sell) }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap"><a href="{{ route('admin.order.index', ['status' => 'processing', 'reseller' => $reseller->id]) }}">Processing Orders</a>:</th>
                                <td>{{ theMoney($reseller->processing_sell) }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap"><a href="{{ route('admin.order.index', ['status' => 'shipping', 'reseller' => $reseller->id]) }}">Shipping Orders</a>:</th>
                                <td>{{ theMoney($reseller->shipping_sell) }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap"><a href="{{ route('admin.order.index', ['status' => 'completed', 'reseller' => $reseller->id]) }}">Completed Orders</a>:</th>
                                <td>{{ theMoney($reseller->completed_sell) }}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap"><a href="{{ route('admin.order.index', ['status' => 'returned', 'reseller' => $reseller->id]) }}">Returned Orders</a>:</th>
                                <td>{{ theMoney($reseller->returned_sell) }}</td>
                            </tr>
                            <tr>
                                <th><a href="{{ route('admin.transactions.index', ['status' => 'paid', 'reseller' => $reseller->id]) }}">Total Paid</a>:</th>
                                <td>{{ theMoney($reseller->paid) }}</td>
                            </tr>
                            @if($reseller->lastPaid->created_at)
                            <tr>
                                <th class="text-nowrap">Last Paid:</th>
                                <td>{{ theMoney($reseller->lastPaid->amount) }}</td>
                            </tr>
                            @endif
                            <!-- <tr>
                                <th class=text-nowrap>Current Balance:</th>
                                <td>{{ theMoney($reseller->balance) }}</td>
                            </tr> -->
                            <tr>
                                <th class="text-nowrap">Earning Status:</th>
                                <td class="d-flex" style="flex-wrap: wrap-reverse;">
                                    @foreach((new App\Services\EarningService($reseller))->periods as $period)
                                        <a class="badge badge-primary m-1 p-2" href="{{ route('earnings', ['reseller_id' => $reseller, 'period' => $period]) }}">{{ $period }}</a>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th class="text-nowrap" style="vertical-align: middle;">Payment Methods:</th>
                                <td>
                                    <div>
                                        <table class="table mb-0 table-bordered">
                                            @forelse($reseller->payment ?? [] as $payment)
                                            <tr>
                                                <th>Method</th>
                                                <td>{{$payment->method}}</td>
                                            </tr>
                                            @if($payment->method == 'Bank')
                                                <tr>
                                                    <th>Bank Name</th>
                                                    <td>{{ $payment->bank_name ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Account Name</th>
                                                    <td>{{$payment->account_name ?? ''}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Branch</th>
                                                    <td>{{ $payment->branch ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Routing No</th>
                                                    <td>{{ $payment->routing_no ?? '' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Account Type</th>
                                                <td>{{$payment->type}}</td>
                                            </tr>
                                            <tr>
                                                <th>Account Number</th>
                                                <td>{{$payment->number}}</td>
                                            </tr>
                                            @if($loop->index) <tr><th colspan="2"></th></tr> @endif
                                            @empty
                                            <tr>
                                                <th>N / A</th>
                                            </tr>
                                            @endforelse
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-12"><h4 class="text-center">NID Photo</h4></div>
                    <div class="col-md-6 border">
                        <img class="m-2" src="{{ asset(optional($reseller->documents)->nid_front) }}" alt="NID Front" style="height: 100%; max-height: 5.5cm; width: 100%; max-width: 8.5cm;">
                    </div>
                    <div class="col-md-6 border">
                        <img class="m-2" src="{{ asset(optional($reseller->documents)->nid_back) }}" alt="NID Back" style="height: 100%; max-height: 5.5cm; width: 100%; max-width: 8.5cm;">
                    </div>
                </div>
                <hr>
                @php $shops = $reseller->shops @endphp
                <h5>Shops [{{ $shops->count() }}]</h5>
                <ul class="list-unstyled">
                    @foreach($shops as $shop)
                    <li>{{ $shop->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
