@extends('layouts.ready')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="orders-table">
                <div class="card rounded-0 shadow-sm">
                    <div class="card-header"><strong>Resellers</strong></div>
                    <div class="card-body">
                        <div class="table-responive">
                            <table class="table table-bordered table-striped table-hover datatable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
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

@push('scripts')
    <script>
        $(document).ready(function() {
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
                    style: 'multi+shift',
                    selector: 'td:first-child'
                },
                order: [],
                scrollX: true,
                pagingType: 'numbers',
                pageLength: 25,
                dom: 'lBfrtip<"actions">',
                buttons: [{
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
            var dt_buttons = $.extend(true, [], $.fn.dataTable.defaults.buttons);



            var table = $('.datatable')
                .DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: "{!! route('api.resellers.index') !!}",
                    dom: 'lBfrtip<"actions">',
                    // dom: '<"lf"lf><"B"B>rt<"ip"ip><"clear">',
                    columnDefs: [{
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
                    order: [],
                    orderCellsTop: true,
                    pagingType: 'numbers',
                    columns: [{
                            data: 'empty',
                            name: 'empty'
                        },
                        {
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                    order: [
                        [1, 'desc']
                    ],
                    buttons: dt_buttons,
                });
        });
    </script>
@endpush
