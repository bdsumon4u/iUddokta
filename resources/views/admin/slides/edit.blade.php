@extends('layouts.ready')
@section('title', 'Edit Slide')

@section('breadcrumb-title')
<h3>Edit Slide</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">
    <a href="{{ route('admin.slides.index') }}">Slides</a>
</li>
<li class="breadcrumb-item">Edit Slide</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-3">Edit Slide</div>
                <div class="card-body p-3">
                    <form method="post" action="{{ route('admin.slides.update', $slide) }}" has-files>
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $slide->title) }}">
                            @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Text</label>
                            <textarea name="text" id="text" class="form-control">{{ old('text', $slide->text) }}</textarea>
                            @error('text')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                {{-- <x-checkbox name="is_active" value="1" :checked="$slide->is_active" />
                                <x-label for="is_active" /> --}}
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" value="1" @if($slide->is_active) checked @endif>
                                <label for="is_active" class="mb-0 ml-2">Is Active</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="btn_name">Button Text</label>
                                    <input type="text" name="btn_name" id="btn_name" class="form-control" value="{{ old('btn_name', $slide->btn_name) }}">
                                    @error('btn_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="btn_href">Button Link</label>
                                    <input type="text" name="btn_href" id="btn_href" class="form-control" value="{{ old('btn_href', $slide->btn_href) }}">
                                    @error('btn_href')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
