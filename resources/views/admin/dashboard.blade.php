@extends('layouts.ready')

@section('content')
<div class="row">
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
                                    <th>Reseller</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr data-row-id="{{ $order->id }}">
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.resellers.show', $order->reseller->id) }}">
                                            <strong>Name:</strong> {{ $order->reseller->name }}
                                            <br>
                                            <strong>Phone:</strong> {{ $order->reseller->phone }}
                                        </a>
                                    </td>
                                    <td>{{ $order->created_at->format('d-M-Y') }}</td>
                                    <td><a class="btn btn-sm btn-block btn-primary" href="{{ route('admin.order.show', $order->id) }}">View</a></td>
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
                                    <th>Reseller</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr data-row-id="{{ $transaction->id }}">
                                    <td><a href="{{ route('admin.transactions.show', $transaction->id) }}">{{ $transaction->id }}</a></td>
                                    <td>
                                        <a href="{{ route('admin.resellers.show', $transaction->reseller->id) }}">
                                            <strong>Name:</strong> {{ $transaction->reseller->name }}
                                            <br>
                                            <strong>Phone:</strong> {{ $transaction->reseller->phone }}
                                        </a>
                                    </td>
                                    <td>{{ theMoney($transaction->amount) }}</td>
                                    <td>{{ $transaction->created_at->format('d-M-Y') }}</td>
                                    <!-- <td>
                                        <a class="btn btn-sm btn-block btn-primary" href="{{ route('admin.transactions.pay-to-reseller', [$transaction->reseller->id,
                                            'transaction_id' => $transaction->id,
                                            'amount' => $transaction->amount,
                                            'method' => $transaction->method,
                                            'bank_name' => $transaction->bank_name,
                                            'account_name' => $transaction->account_name,
                                            'branch' => $transaction->branch,
                                            'routing_no' => $transaction->routing_no,
                                            'account_type' => $transaction->account_type,
                                            'account_number' => $transaction->account_number,
                                        ]) }}">Pay</a>
                                    </td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="pending-resellers">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header"><strong>Non-Verified</strong> Resellers</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover datatable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resellers as $reseller)
                            <tr>
                                <td>{{ $reseller->id }}</td>
                                <td>
                                    <a href="{{ route('admin.resellers.show', $reseller->id) }}">{{ $reseller->name }}</a>
                                </td>
                                <td>{{ $reseller->email }}</td>
                                <td>{{ $reseller->phone }}</td>
                                <td><span class="badge badge-{{ $reseller->verified_at ? 'success' : 'secondary' }}">{{ $reseller->verified_at ? 'Verified' : 'Non-Verified' }}</span></td>
                                <td>
                                    <a href="{{ route('admin.resellers.edit', $reseller->id) }}" class="btn btn-sm btn-light">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn btn-sm' });
    
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            paginate: {
                previous: '<i class="fa fa-angle-left"></i>',
                first: '<i class="fa fa-angle-double-left"></i>',
                last: '<i class="fa fa-angle-double-right"></i>',
                next: '<i class="fa fa-angle-right"></i>',
            },
        },
        columnDefs: [
            {
                orderable: false,
                searchable: false,
                targets: -1
            },
        ],
        select: {
            style:    'multi+shift',
            selector: 'td:first-child'
        },
        order: [],
        scrollX: true,
        pagingType: 'numbers',
        pageLength: 25,
        dom: 'lft<"actions">',
    });
    $('.datatable').DataTable({
    });
</script>
@endsection