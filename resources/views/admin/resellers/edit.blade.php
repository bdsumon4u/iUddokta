@extends('layouts.ready')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header">Edit <strong>Reseller</strong></div>
            <div class="card-body">
                <form action="{{ route('admin.resellers.update', $reseller->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label><span class="text-danger">*</span>
                                        <input name="name" value="{{ old('name', $reseller->name) }}" id="name" cols="30" rows="10" class="form-control @error('name') is-invalid @enderror">
                                        {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label><span class="text-danger">*</span>
                                        <input name="email" value="{{ old('email', $reseller->email) }}" id="email" cols="30" rows="10" class="form-control @error('email') is-invalid @enderror">
                                        {!! $errors->first('email', '<span class="invalid-feedback">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="phone">Phone</label><span class="text-danger">*</span>
                                        <input name="phone" value="{{ old('phone', $reseller->phone) }}" id="phone" cols="30" rows="10" class="form-control @error('phone') is-invalid @enderror">
                                        {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="photo" class="d-block">Photo<span class="text-danger">*</span></label>
                                        <img src="{{ asset(optional($reseller->documents)->photo) }}" alt="Photo" style="width: 40mm; height: 50mm; margin-top: 2mm;">
                                        {!! $errors->first('photo', '<span class="invalid-feedback">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="verified" id="verified" class="custom-control-input" @if($reseller->verified_at) checked @endif>
                                    <label for="verified" class="custom-control-label">Verified</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-12"><h4 class="text-center">NID Photo</h4></div>
                        <div class="col-md-6 border">
                            <img class="m-2" src="{{ asset(optional($reseller->documents)->nid_front) }}" alt="NID Front" style="height: 100%; max-height: 5.5cm; width: 100%; max-width: 8.5cm;">
                        </div>
                        <div class="col-md-6 border">
                            <img class="m-2" src="{{ asset(optional($reseller->documents)->nid_back) }}" alt="NID Back" style="height: 100%; max-height: 5.5cm; width: 100%; max-width: 8.5cm;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection