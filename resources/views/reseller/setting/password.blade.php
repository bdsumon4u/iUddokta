@extends('reseller.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header py-2">Reseller <strong>Setting</strong></div>
            <div class="card-body p-2">
                <form action="{{ route('reseller.password.change') }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-sm-12">
                            <h4><small class="border-bottom mb-1">Change Password</small></h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label><span class="text-danger">*</span>
                                <input type="password" name="password" value="{{ old('password') }}" id="password" class="form-control @error('password') is-invalid @enderror">
                                {!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label><span class="text-danger">*</span>
                                <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                {!! $errors->first('password_confirmation', '<span class="invalid-feedback">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="old_password">Old Password</label><span class="text-danger">*</span>
                                <input type="password" name="old_password" value="{{ old('old_password') }}" id="old_password" class="form-control @error('old_password') is-invalid @enderror">
                                {!! $errors->first('old_password', '<span class="invalid-feedback">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success">Change Password</button>
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
    $(document).ready(function(){
        $('#setting-form').on('submit', function(e) {
            return e.which != 13;
        });
    });
</script>
@endsection