@extends('reseller.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header py-2">Reseller <strong>Setting</strong></div>
            <div class="card-body p-2">
                <form action="{{ route('reseller.setting.profile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    @php $user = auth('reseller')->user() @endphp
                    @php $verified_at = $user->verified_at ?? 0 @endphp
                    @php $photo = optional($user->documents)->photo @endphp
                    @php $nid_front = optional($user->documents)->nid_front @endphp
                    @php $nid_back = optional($user->documents)->nid_back @endphp
                    <input type="hidden" name="verified_at" value="{{ old('verified_at', $user->verified_at ?? 0) }}">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4><small class="border-bottom mb-1">General</small></h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label><span class="text-danger">*</span>
                                        <input name="name" value="{{ old('name', $user->name) }}" id="name" cols="30" rows="10" class="form-control @error('name') is-invalid @enderror" disabled>
                                        {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label><span class="text-danger">*</span>
                                        <input name="email" value="{{ old('email', $user->email) }}" id="email" cols="30" rows="10" class="form-control @error('email') is-invalid @enderror" disabled>
                                        {!! $errors->first('email', '<span class="invalid-feedback">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="phone">Phone</label><span class="text-danger">*</span>
                                        <input name="phone" value="{{ old('phone', $user->phone) }}" id="phone" cols="30" rows="10" class="form-control @error('phone') is-invalid @enderror">
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
                                        @unless($verified_at)
                                        <input type="file" name="photo" value="{{ old('photo', $photo) }}" id="photo" cols="30" rows="10" class="@error('photo') is-invalid @enderror">
                                        @endunless
                                        <img src="{{ asset($photo) }}" alt="Photo" style="@unless($photo) display: none; @endunless width: 40mm; height: 50mm; margin-top: 2mm;">
                                        {!! $errors->first('photo', '<span class="invalid-feedback">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nid-front" class="d-block">NID Front<span class="text-danger">*</span></label>
                                @unless($verified_at)
                                <input type="file" name="nid[front]" value="{{ old('nid.front', $nid_front) }}" id="nid-front" cols="30" rows="10" class="@error('nid.front') is-invalid @enderror">
                                @endunless
                                <img src="{{ asset($nid_front) }}" alt="Photo" style="@unless($nid_front) display: none; @endunless width: 8.5cm; height: 5.5cm; margin-top: 2mm;">
                                {!! $errors->first('nid.front', '<span class="invalid-feedback">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nid-back" class="d-block">NID Back<span class="text-danger">*</span></label>
                                @unless($verified_at)
                                <input type="file" name="nid[back]" value="{{ old('nid.back', $nid_back) }}" id="nid-back" cols="30" rows="10" class="@error('nid.back') is-invalid @enderror">
                                @endunless
                                <img src="{{ asset($nid_back) }}" alt="Photo" style="@unless($nid_back) display: none; @endunless width: 8.5cm; height: 5.5cm; margin-top: 2mm;">
                                {!! $errors->first('nid.back', '<span class="invalid-feedback">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success">Submit</button>
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

        $('#photo').on('change', function (e) {
            renderPhoto(this);
        });
        $('#nid-front').on('change', function (e) {
            renderPhoto(this);
        });
        $('#nid-back').on('change', function (e) {
            renderPhoto(this);
        });

        function renderPhoto(input) {
            console.log('rendering')
            if(input.files.length) {
                console.log('has length')
                var reader = new FileReader;
                reader.readAsDataURL(input.files[0]);
                reader.onload = function(e) {
                    console.log('onload')
                    $(input).next('img').show().attr('src', e.target.result);
                }
            }
        }
    });
</script>
@endsection