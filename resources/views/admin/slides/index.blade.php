@extends('layouts.ready')
@section('title', 'Slides')

@section('breadcrumb-title')
<h3>Slides</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Slides</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header p-3">Upload Images</div>
                <div class="card-body p-3">
                    <form method="post" action="{{ route('admin.slides.store') }}" id="drop-slides" class="dropzone" enctype="multipart/form-data">
                        @csrf
                        <div class="dz-message needsclick">
                            <i class="icon-cloud-up"></i>
                            <h6>Drop files here or click to upload.</h6>
                            <span class="note needsclick">(Recommended <strong>840x395</strong> dimension.)</span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-5">
                <div class="card-header p-3">Current Slides</div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($slides as $slide)
                                <tr>
                                    <td width="10">{{ $slide->id }}</td>
                                    <td width="200">
                                        <img src="{{ asset($slide->mobile_src) }}" width="200" height="100" alt="">
                                    </td>
                                    <td>{{ $slide->title }}</td>
                                    <td width="10">
                                        @if($slide->is_active)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td width="80">
                                        <form method="post" action="{{ route('admin.slides.destroy', $slide) }}">
                                            @method('DELETE')
                                            @csrf
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-primary" href="{{ route('admin.slides.edit', $slide) }}">Edit</a>
                                                <button class="btn btn-danger" type="submit">Delete</button>
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
</div>
@endsection
