@extends('layouts.ready')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header py-2">Add New <strong>Page</strong></div>
            <div class="card-body p-2">
                <form action="{{ route('admin.pages.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Page Title</label><span class="text-danger">*</span>
                        <input type="text" name="title" value="{{ old('title') }}" id="title" data-target="#slug" class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label><span class="text-danger">*</span>
                        <input type="text" name="slug" value="{{ old('slug') }}" id="slug" class="form-control @error('slug') is-invalid @enderror">
                        @error('slug')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="content">Content</label><span class="text-danger">*</span>
                                <textarea editor name="content" id="" cols="30" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                                {!! $errors->first('content', '<span class="invalid-feedback">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group mb-0">
                            <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('[name="title"]').keyup(function () {
        $($(this).data('target')).val(slugify($(this).val()));
    });
});
</script>
@endsection