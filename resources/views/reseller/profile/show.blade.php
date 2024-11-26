@extends('reseller.layout')

@section('content')
<div class="row fade-in justify-content-center">
    <div class="col-md-6">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header">Profile: <strong>{{ $reseller->name }}</strong></div>
            <div class="card-body">
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
                <div class="table-responsive">
                    <h5>Account Info</h5>
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <tbody>
                            <tr>
                                <th>Total Sell:</th>
                                <td>{{ theMoney($reseller->total_sell) }}</td>
                            </tr>
                            <tr>
                                <th>Pending Sell:</th>
                                <td>{{ theMoney($reseller->pending_sell) }}</td>
                            </tr>
                            <tr>
                                <th>Processing Sell:</th>
                                <td>{{ theMoney($reseller->processing_sell) }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Sell:</th>
                                <td>{{ theMoney($reseller->shipping_sell) }}</td>
                            </tr>
                            <tr>
                                <th>Completed Sell:</th>
                                <td>{{ theMoney($reseller->completed_sell) }}</td>
                            </tr>
                            <tr>
                                <th>Returned Sell:</th>
                                <td>{{ theMoney($reseller->returned_sell) }}</td>
                            </tr>
                            <tr>
                                <th>Total Paid:</th>
                                <td>{{ theMoney($reseller->paid) }}</td>
                            </tr>
                            @if($reseller->lastPaid->created_at)
                            <tr>
                                <th>Last Paid:</th>
                                <td>{{ theMoney($reseller->lastPaid->amount) }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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