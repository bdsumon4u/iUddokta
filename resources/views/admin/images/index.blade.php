@extends('layouts.ready')

@section('styles')
<style>
    form#drop-imgs {
        margin-bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    th,
    td {
        vertical-align: middle !important;
    }
    table.dataTable tbody td.select-checkbox:before,
    table.dataTable tbody td.select-checkbox:after,
    table.dataTable tbody th.select-checkbox:before,
    table.dataTable tbody th.select-checkbox:after {
        top: 50%;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card rounded-0">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.images.store') }}" id="drop-imgs" class="dropzone" enctype="multipart/form-data">
                    @csrf
                </form>
            </div>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="table-responive">
                    <table class="table table-bordered table-striped table-hover datatable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th></th>
                                <th width="5">ID</th>
                                <th width="150">Preview</th>
                                <th>Filename</th>
                                <th>Mime</th>
                                <th>Size</th>
                                <th width="10">Action</th>
                            </tr>
                        </thead>
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
        pageLength: 10,
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
        ],
    });
    var dt_buttons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    var delete_button = {
        text: 'Bulk Delete',
        url: "{{ route('api.images.destroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
            var IDs = $.map(dt.rows({
                selected: true
            }).nodes(), function(entry) {
                return $(entry).data('entry-id')
            });

            if (IDs.length === 0) {
                alert('Select Rows First.')

                return;
            }

            if (confirm('Are You Sure To Delete?')) {
                $.ajax({
                    headers: {
                        'x-csrf-token': "{{ csrf_token() }}"
                    },
                    method: 'POST',
                    url: config.url,
                    data: {
                        IDs: IDs,
                        _method: 'DELETE'
                    }
                })
                .done(function() {
                    $('.datatable').DataTable().ajax.reload();
                })
            }
        }
    }
    dt_buttons.push(delete_button)

    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!! route('api.images.index') !!}",
        buttons: dt_buttons,
        columns: [
            { data: 'empty', name: 'empty' },
            { data: 'id', name: 'id' },
            { data: 'preview', name: 'preview' },
            { data: 'filename', name: 'filename' },
            { data: 'mime', name: 'mime' },
            { data: 'size', name: 'size' },
            { data: 'delete', name: 'delete' },
        ],
        order: [
            [1, 'desc']
        ],
    })
</script>
@endsection