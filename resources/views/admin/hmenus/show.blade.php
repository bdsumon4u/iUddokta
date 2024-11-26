@extends('layouts.ready')

@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header">
                Menu Items <strong>[{{$hmenu->name}}]</strong>
                <div class="card-header-actions">
                    <a href="#create-menu-item" data-toggle="modal" class="card-header-action btn btn-sm btn-primary text-light">Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="alert-box" style="display: none;">
                    <div class="alert alert-success">Sort Successfull.</div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th width="10">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach($items as $item)
                            <tr data-index="{{ $item->id }}" data-order="{{ $item->order }}">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <form action="{{ route('admin.menuItems.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group btn-group-sm btn-group-inline d-flex justify-content-between">
                                            <a href="#edit-menu-item" data-toggle="modal" data-route="{{ route('admin.menuItems.update', $item->id) }}" data-title="{{ $item->title }}" data-url="{{ $item->url }}" class="btn btn-success rounded-0 mr-1">Edit</a>
                                            <button type="submit" class="btn btn-danger rounded-0 ml-1">Delete</button>
                                        </div>
                                    </form>
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

<div class="modal" id="create-menu-item">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <form action="{{ route('admin.menuItems.store') }}" method="post">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $hmenu->id }}">
                <div class="modal-header p-2">Create Menu Item</div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label><span class="text-danger">*</span>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="url">URL</label><span class="text-danger">*</span>
                        <input type="text" name="url" id="url" class="form-control">
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="edit-menu-item">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <form action="" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-header p-2">Edit Menu Item</div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label><span class="text-danger">*</span>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="url">URL</label><span class="text-danger">*</span>
                        <input type="text" name="url" id="url" class="form-control">
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        $('[href="#edit-menu-item"]').click(function () {
            $('#edit-menu-item').find('form').attr('action', $(this).data('route'));
            $('#edit-menu-item').find('[name="title"]').val($(this).data('title'));
            $('#edit-menu-item').find('[name="url"]').val($(this).data('url'));
        });

        $("#sortable").sortable({
            helper: function (e, ui) {
                ui.children().each(function () {
                    $(this).width($(this).width());
                });
                return ui;
            },
            update: function (event, ui) {
                $(this).children().each(function (index) {
                    if ($(this).attr('data-order') != index + 1) {
                        $(this).attr('data-order', index + 1).addClass('updated');
                    }
                });
                saveNewPositions();
            },
        });
        function saveNewPositions () {
            var positions = [];
            $('tr.updated').each(function () {
                positions.push([$(this).data('index'), $(this).attr('data-order')]);
            });
            $.ajax({
                url: "{{ route('admin.menuItems.sort', $hmenu->id) }}",
                method: 'POST',
                dataType: 'text',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    positions: positions,
                },
                success: function (response) {
                    $('.alert-box').show();
                    setTimeout(function () {
                        $('.alert-box').hide();
                    }, 3000);
                    $('tr.updated').each(function () {
                        $(this).removeClass('updated');
                    });
                },
                error : function (error) {
                    console.log(error);
                },
            });
        }
        $("#sortable").disableSelection();
    });
</script>
@endsection