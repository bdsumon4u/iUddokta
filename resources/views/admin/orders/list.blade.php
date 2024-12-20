@extends('layouts.ready')

@section('styles')
<style>
    .dt-buttons.btn-group > .btn + .btn {
        border-left: 1px solid;
    }
    .card-header select, .status-column {
        height: calc(1.5em + .5rem + 2px);
        padding: .25rem .5rem;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="orders-table">
            <div class="shadow-sm card rounded-0">
                <div class="p-2 card-header">
                    <div class="px-3 row justify-content-between align-items-center">
                        <div>All Orders</div>
                        <div>
                            <a href="" class="btn btn-sm btn-primary">New Order</a>
                            <a href="" class="ml-1 btn btn-sm btn-primary">Pathao CSV</a>
                        </div>
                    </div>
                    <div class="row d-none" style="row-gap: .25rem;">
                        <div class="col-auto pr-0 d-flex align-items-center" check-count></div>
                        <div class="col-auto px-1">
                            <select name="status" id="status" onchange="changeStatus()" class="text-white form-control form-control-sm bg-primary">
                                <option value="">Change Status</option>
                                @foreach(config('order.statuses', []) as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        @unless(request('status') == 'SHIPPING')
                        <div class="col-auto px-1">
                            <select name="courier" id="courier" onchange="changeCourier()" class="text-white form-control form-control-sm bg-primary">
                                <option value="">Change Courier</option>
                                @foreach(['Pathao', 'SteadFast', 'Other'] as $provider)
                                <option value="{{ $provider }}">{{ $provider }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endunless
                        <div class="col-auto pl-0 ml-auto">
                            @if(request('status') == 'CONFIRMED')
                            <button onclick="printInvoice()" id="invoice" class="ml-1 btn btn-sm btn-primary">Print Invoice</button>
                            @elseif(request('status') == 'INVOICED')
                            <button onclick="courier()" id="courier" class="ml-1 btn btn-sm btn-primary">Send to Courier</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responive">
                        <table class="table table-bordered table-striped table-hover datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="max-width: 5%">
                                        <input type="checkbox" class="form-control" name="check_all" style="min-height: 20px;min-width: 20px;max-height: 20px;max-width: 20px;">
                                    </th>
                                    <th>ID</th>
                                    <th>Reseller</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Ordered At</th>
                                    <th>Completed At</th>
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
    var checklist = new Set();
    function updateBulkMenu() {
        $('[name="check_all"]').prop('checked', true);
        $(document).find('[name="order_id[]"]').each(function () {
            if (checklist.has($(this).val())) {
                $(this).prop('checked', true);
            } else {
                $('[name="check_all"]').prop('checked', false);
            }
        });

        if (checklist.size > 0) {
            $('[check-count]').text(checklist.size + 'x');
            $('.card-header > .row:last-child').removeClass('d-none');
            $('.card-header > .row:first-child').addClass('d-none');
        } else {
            $('[check-count]').text('');
            $('.card-header > .row:last-child').addClass('d-none');
            $('.card-header > .row:first-child').removeClass('d-none');
        }
    }
    $('[name="check_all"]').on('change', function () {
        if ($(this).prop('checked')) {
            $(document).find('[name="order_id[]"]').each(function () {
                checklist.add($(this).val());
            });
        } else {
            $(document).find('[name="order_id[]"]').each(function () {
                checklist.delete($(this).val());
            });
        }
        $('[name="order_id[]"]').prop('checked', $(this).prop('checked'));
        updateBulkMenu();
    });


    
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
        dom: 'lBfrtip<"actions">',
        buttons: [
            @foreach(config('order.statuses', []) as $status)
            {
                text: '{{ $status }}',
                className: 'px-1 py-1 {{ request('status') == $status ? 'btn-primary' : 'btn-outline-primary' }}',
                action: function ( e, dt, node, config ) {
                    window.location = '{!! request()->fullUrlWithQuery(['status' => $status]) !!}'
                }
            },
            @endforeach
            {
                text: 'All',
                className: 'px-1 py-1 {{ request('status') == '' ? 'btn-primary' : 'btn-outline-primary' }}',
                action: function ( e, dt, node, config ) {
                    window.location = '{!! request()->fullUrlWithQuery(['status' => '']) !!}'
                }
            },
        ],
    });

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
        columns: [
            { data: 'checkbox', name: 'checkbox', searchable: false, sortable: false },
            { data: 'id', name: 'id' },
            { data: 'reseller', name: 'reseller' },
            { data: 'customer', name: 'customer' },
            { data: 'status', name: 'status' },
            { data: 'price', name: 'price' },
            { data: 'ordered_at', name: 'ordered_at' },
            { data: 'completed_at', name: 'completed_at' },
        ],
        drawCallback: function () {
            updateBulkMenu();
            $(document).on('change', '[name="order_id[]"]', function () {
                if ($(this).prop('checked')) {
                    checklist.add($(this).val());
                } else {
                    checklist.delete($(this).val());
                }
                updateBulkMenu();
            });
        },
        order: [
            [1, 'desc']
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

    $(document).on('change', '.status-column', changeStatus);

    function changeStatus() {
        $('[name="status"]').prop('disabled', true);

        var order_id = Array.from(checklist);
        var status = $('[name="status"]').val();
        if ($(this).data('id')) {
            order_id = [$(this).data('id')];
            status = $(this).val();
        }

        $.post({
            url: '{{ route('admin.order.status') }}',
            data: {
                _token: '{{ csrf_token() }}',
                order_id: order_id,
                status: status,
            },
            success: function (response) {
                checklist.clear();
                updateBulkMenu();
                table.draw();

                $.notify('Status updated successfully', 'success');
            },
            complete: function () {
                $('[name="status"]').prop('disabled', false);
                $('[name="status"]').val('');
            }
        });
    }
</script>
@endsection