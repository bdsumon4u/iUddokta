@extends('layouts.ready')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="orders-table">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header d-flex justify-content-between"><strong>Resellers</strong></div>
                <div class="card-body">
                    <div class="table-responive">
                        <table class="table table-bordered table-striped table-hover datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="30">ID</th>
                                    <th>Reseller</th>
                                    <!-- <th>Balance</th> -->
                                    <th width="125">Pay</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $payNow = 0 @endphp
                                @foreach($resellers as $reseller)
                                <tr data-row-id="{{ $reseller->id }}">
                                    <td></td>
                                    <td>{{ $reseller->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.resellers.show', $reseller->id) }}">
                                            <strong>Name:</strong> {{ $reseller->name }}
                                            <br>
                                            <strong>Phone:</strong> {{ $reseller->phone }}
                                        </a>
                                    </td>
                                    <!-- <td>{{ theMoney($reseller->balance) }}</td> -->
                                    <td><a class="btn btn-sm btn-block btn-primary" href="{{ route('admin.transactions.pay-to-reseller', [$reseller->id, 'amount' => $reseller->payNow]) }}">Pay {{ theMoney($reseller->payNow) }}</a></td>
                                </tr>
                                @php $payNow += $reseller->payNow @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.card-header').append('<span class="badge p-2 badge-info required-amount" style="font-size: 100%;">Required Amount: {{ theMoney($payNow) }}</span>')
    })

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
                className: 'select-checkbox',
                searchable: false,
                targets: 0,
            },
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
        dom: 'lBfrtip<"actions">',
        buttons: [
            {
                extend: 'selectAll',
                className: 'btn-primary',
                text: 'Select All',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'selectNone',
                className: 'btn-primary',
                text: 'Deselect All',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copy',
                className: 'btn-light',
                text: 'Copy',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                className: 'btn-light',
                text: 'CSV',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                className: 'btn-light',
                text: 'Excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                className: 'btn-light',
                text: 'Print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                className: 'btn-light',
                text: 'Columns',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
    });
    var dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    $('.datatable')
    .DataTable({
        buttons: dtButtons
    });
</script>
@endsection