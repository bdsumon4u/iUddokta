@extends('reseller.layout')

@section('content')
<div class="row">
    @iverified
    <div class="col-md-6">
        <div class="orders-table">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header"><strong>Pending Orders</strong></div>
                <div class="card-body">
                    <div class="table-responive">
                        <table class="table table-bordered table-striped table-hover datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr data-row-id="{{ $order->id }}">
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <strong>Name:</strong> {{ $order->data['customer_name'] }}
                                        <br>
                                        <strong>Phone:</strong> {{ $order->data['customer_phone'] }}
                                    </td>
                                    <td>{{ $order->created_at->format('d-M-Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="transactions-table">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header"><strong>Recent Transactions</strong></div>
                <div class="card-body">
                    <div class="table-responive">
                        <table class="table table-bordered table-striped table-hover datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr data-row-id="{{ $transaction->id }}">
                                    <td><a
                                            href="{{ route('reseller.transactions.show', $transaction->id) }}">{{ $transaction->id }}</a>
                                    </td>
                                    <td>{{ theMoney($transaction->amount) }}</td>
                                    <td>{{ $transaction->created_at->format('d-M-Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12"><hr></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Earnings</div>
            <div class="card-body p-2">
                <div class="row">
                    @foreach(array_reverse((new App\Services\EarningService(auth('reseller')->user()))->periods) ?? [] as $period)
                    <div class="col-md-4 col-xl-2">
                    <a href="{{ route('earnings', ['reseller_id' => auth('reseller')->user(), 'period' => $period]) }}" class="btn my-1 btn-sm btn-block btn-light text-center">{{ $period }}</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12"><hr></div>
    @else
    <div class="col-12">
        <div class="alert alert-warning">
            Assalamualikum,<br>
            Your Reseller Account is under processing.<br>
            We'll verify you soon so please go to setting option and prove your identity.<br>
            Create your shop and select your payment options.<br>
            After verifying your account, you'll be able to see products prices and others option.<br>
            Please contact us for any query.
        </div>
    </div>
    @endiverified
</div>
@endsection

@section('scripts')
<script>
$.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
    className: 'btn btn-sm'
});

$.extend(true, $.fn.dataTable.defaults, {
    language: {
        paginate: {
            previous: '<i class="fa fa-angle-left"></i>',
            first: '<i class="fa fa-angle-double-left"></i>',
            last: '<i class="fa fa-angle-double-right"></i>',
            next: '<i class="fa fa-angle-right"></i>',
        },
    },
    columnDefs: [{
        orderable: false,
        searchable: false,
        targets: -1
    }, ],
    select: {
        style: 'multi+shift',
        selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pagingType: 'numbers',
    pageLength: 25,
    dom: 'ft<"actions">',
});
$('.datatable').on('draw.dt', function() {
    $(this).css('width', '100%');
}).DataTable({});
</script>
@endsection