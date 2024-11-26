@extends('layouts.ready')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header">
                <strong>All Menus</strong>
                <div class="card-header-actions">
                    <a href="#create-menu" data-toggle="modal" class="card-header-action btn btn-sm btn-primary text-light">Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>
                                    <form action="{{ route('admin.hmenus.destroy', $menu->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group btn-group-sm btn-group-inline d-flex justify-content-between">
                                            <a href="{{ route('admin.hmenus.show', $menu->id) }}" class="btn btn-success rounded-0 mr-1">Build</a>
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

<div class="modal" id="create-menu">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <form action="{{ route('admin.hmenus.store') }}" method="post">
                @csrf
                <div class="modal-header p-2">Create New Menu</div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label><span class="text-danger">*</span>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="class">Class</label>
                        <input type="text" name="class" id="class" class="form-control">
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