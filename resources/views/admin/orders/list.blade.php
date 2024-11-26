@extends('layouts.ready')

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
                                    <th>ID</th>
                                    <th>Reseller</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Ordered At</th>
                                    <th>Completed/Returned</th>
                                    <th>Action</th>
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
    // $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn btn-sm' });
    
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
            // {
            //     orderable: false,
            //     className: 'select-checkbox',
            //     searchable: false,
            //     targets: 0,
            // },
            {
                orderable: false,
                searchable: false,
                targets: -1
            },
            {
                orderable: false,
                targets: [2, 3, 4, 5, 6, 7],
            },
            // {
            //     searchable: false,
            //     targets: [2, 3, 4, 5, 6, 7],
            // },
        ],
        // select: {
        //     style:    'multi+shift',
        //     selector: 'td:first-child'
        // },
        order: [],
        scrollX: true,
        pagingType: 'numbers',
        pageLength: 25,
        dom: 'lfrtip<"actions">',
        // buttons: [
        //     {
        //         extend: 'selectAll',
        //         className: 'btn-primary',
        //         text: 'Select All',
        //         exportOptions: {
        //             columns: ':visible'
        //         }
        //     },
        //     {
        //         extend: 'selectNone',
        //         className: 'btn-primary',
        //         text: 'Deselect All',
        //         exportOptions: {
        //             columns: ':visible'
        //         }
        //     },
        //     {
        //         extend: 'csv',
        //         className: 'btn-light',
        //         text: 'CSV',
        //         exportOptions: {
        //             columns: ':visible'
        //         }
        //     },
        //     {
        //         extend: 'excel',
        //         className: 'btn-light',
        //         text: 'Excel',
        //         exportOptions: {
        //             columns: ':visible'
        //         }
        //     },
        //     {
        //         extend: 'print',
        //         className: 'btn-light',
        //         text: 'Print',
        //         exportOptions: {
        //             columns: ':visible'
        //         }
        //     },
        //     {
        //         extend: 'colvis',
        //         className: 'btn-light',
        //         text: 'Columns',
        //         exportOptions: {
        //             columns: ':visible'
        //         }
        //     },
        // ],
    });
    // var dt_buttons = $.extend(true, [], $.fn.dataTable.defaults.buttons);


    var table = $('.datatable').DataTable({
        search: [
            {
                bRegex: true,
                bSmart: false,
            },
        ],
        processing: true,
        serverSide: true,
        ajax: "{!! route('api.orders.admin', request()->only(['status', 'reseller'])) !!}",
        // buttons: dt_buttons,
        columns: [
            // { data: 'empty', name: 'empty' },
            { data: 'id', name: 'id' },
            { data: 'reseller', name: 'reseller' },
            { data: 'customer', name: 'customer' },
            { data: 'status', name: 'status' },
            { data: 'price', name: 'price' },
            { data: 'ordered_at', name: 'ordered_at' },
            { data: 'completed_returned_at', name: 'completed_returned_at' },
            { data: 'action', name: 'action' },
        ],
        order: [
            [0, 'desc']
        ],
    });

    
    // $('.datatable thead tr').clone(true).appendTo( '.datatable thead' );
    // $('.datatable thead tr th').each( function (i) {
    //     if ($.inArray(i, [1]) != -1) {
    //         var title = $(this).text();
    //         $(this).removeClass('sorting').addClass('p-1').html( '<input class="form-control" type="text" placeholder="'+title+'" size="10" />' );
    
    //         $( 'input', this ).on( 'keyup change', function (e) {
    //             if (e.keyCode == 13 && table.column(i).search() !== this.value ) {
    //                 table
    //                     .column(i)
    //                     .search('^'+ (this.value.length ? this.value : '.*') +'$', true, false)
    //                     .draw();
    //             }
    //         } );
    //     }
    // } );
</script>
@endsection