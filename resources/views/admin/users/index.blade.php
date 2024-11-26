@extends('layouts.ready')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header">All <strong>Admins</strong></div>
            <div class="card-body">
                <a href="{{ route('admin.admins.create') }}" class="btn mb-2 btn-success">Add New</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <tr>
                                <th>ID</th>
                                <th>Super</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th width="20">Action</th>
                            </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->is_super ? 'Yes' : 'No' }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="post">
                                    <div class="btn-group">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-primary rounded-0">Edit</a>
                                        <button type="submit" class="btn btn-sm btn-danger rounded-0">Delete</button>
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
@endsection