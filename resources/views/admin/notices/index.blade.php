@extends('layouts.ready')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="shadow-sm card rounded-0">
                <div class="card-header">Post <strong>Notice</strong></div>
                <div class="card-body">
                    <form action="{{ route('admin.notice') }}" method="post">
                        @method('PATCH')
                        <div class="tab-content">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea editor name="content" id="" cols="30" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content', $notice->content) }}</textarea>
                                        {!! $errors->first('content', '<span class="invalid-feedback">:message</span>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-0 form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
