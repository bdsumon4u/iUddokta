@extends('reseller.layout')

@section('styles')
<style>
    table th,
    table td {
        /* vertical-align: middle !important; */
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="orders-table">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header"><strong>All Orders</strong></div>
                <div class="card-body">
                    <div class="table-responive">
                        <table class="table table-bordered table-striped table-hover datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="10">ID</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Ordered At</th>
                                    <th>Completed/Returned</th>
                                    <th width="15">Action</th>
                                </tr>
                            </thead>
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
    var dt_buttons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!! route('api.orders.reseller', [auth('reseller')->user()->id]) !!}",
        buttons: dt_buttons,
        columns: [
            { data: 'empty', name: 'empty' },
            { data: 'id', name: 'id' },
            { data: 'customer', name: 'customer' },
            { data: 'status', name: 'status' },
            { data: 'price', name: 'price' },
            { data: 'ordered_at', name: 'ordered_at' },
            { data: 'completed_returned_at', name: 'completed_returned_at' },
            { data: 'action', name: 'action' },
        ],
        order: [
            [1, 'desc']
        ],
    });
</script>
@endsection