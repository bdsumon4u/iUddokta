@extends('reseller.layout')

@section('styles')
@livewireStyles
<style>
    .nav-tabs {
        border: 2px solid #ddd;
    }
    .nav-tabs li:hover a,
    .nav-tabs li a.active {
        border-radius: 0;
        border-bottom-color: #ddd !important;
    }
    .nav-tabs li a.active {
        background-color: #f0f0f0 !important;
    }
    .nav-tabs li a:hover {
        border-bottom: 1px solid #ddd;
        background-color: #f7f7f7;
    }

    .is-invalid + .SumoSelect + .invalid-feedback {
        display: block;
    }


    .input-group {
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        padding: 5px;
        box-sizing: content-box;
    }
    .input-group * {
        border-radius: 0;
    }
    .input-group-append {
        cursor: pointer;
    }
    .input-group input, .input-group select {
        /* margin-right: 1rem; */
    }
    /* @media (max-width: 768px) { */
        .input-group input, .input-group select {
            min-width: 250px !important;
            max-width: 450px !important;
        }
    /* } */
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header py-2">Reseller <strong>Setting</strong></div>
            <div class="card-body p-2">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <ul class="nav nav-tabs list-group" role="tablist">
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('photo')) text-danger @endif active" data-toggle="tab" href="#item-1">General</a></li>
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('nid.front') || $errors->has('nid.back')) text-danger @endif" data-toggle="tab" href="#item-2">Documents</a></li>
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('payment_method') || $errors->has('payment_number')) text-danger @endif" data-toggle="tab" href="#item-3">Transaction</a></li>
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('password') || $errors->has('old_password') || $errors->has('password_confirmation')) text-danger @endif" data-toggle="tab" href="#item-4">Password</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-8 col-xl-9">
                        <div class="row">
                            <div class="col">
                                <form id="setting-form" action="{{ route('reseller.setting.update') }}" method="post" enctype="multipart/form-data">
                                    <div class="tab-content">
                                        @csrf
                                        @method('PATCH')
                                        
                                        @php $verified_at = $user->verified_at ?? 0 @endphp
                                        @php $photo = optional($user->documents)->photo @endphp
                                        @php $nid_front = optional($user->documents)->nid_front @endphp
                                        @php $nid_back = optional($user->documents)->nid_back @endphp
                                        <input type="hidden" name="verified_at" value="{{ old('verified_at', $user->verified_at ?? 0) }}">

                                        <div class="tab-pane active" id="item-1" role="tabpanel">
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
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="item-2" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">Documents</small></h4>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
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
                                        </div>
                                        <div class="tab-pane" id="item-3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">Transaction</small></h4>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group" id="ways">
                                                        <label for="payment">Payment Methods</label>
                                                        <!-- <a href="" id="add-way" class="btn btn-primary btn-sm float-right mb-1"><strong>Add New</strong></a> -->
                                                        @forelse($user->payment ?? [] as $payment)
                                                        <div class="row border pt-2">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="">Method</label>
                                                                    <select name="payment[{{ $loop->index }}][method]" class="form-control payment_method @error('payment.'.$loop->index.'.method') is-invalid @enderror">
                                                                        <option value="">Select Method*</option>
                                                                        @php $old_method = old('payment.'.$loop->index.'.method', $payment->method ?? '') @endphp
                                                                        @foreach(config('transaction.ways') as $way)
                                                                            <option value="{{ $way }}" @if($way == $old_method) selected @endif>{{ $way }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 {{ $payment->method == 'Bank' ? '' : 'd-none' }}" method="bank">
                                                                <div class="form-group">
                                                                    <label for="">Bank Name</label>
                                                                    <input type="text" title="Bank Name" name="payment[{{ $loop->index }}][bank_name]" placeholder="Bank Name*" value="{{ old('payment.'.$loop->index.'.bank_name', $payment->bank_name ?? '') }}" class="bank_name form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 {{ $payment->method == 'Bank' ? '' : 'd-none' }}" method="bank">
                                                                <div class="form-group">
                                                                    <label for="">Account Name</label>
                                                                    <input type="text" title="Account Name" name="payment[{{ $loop->index }}][account_name]" placeholder="Account Name*" value="{{ old('payment.'.$loop->index.'.account_name', $payment->account_name ?? '') }}" class="account_name form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 {{ $payment->method == 'Bank' ? '' : 'd-none' }}" method="bank">
                                                                <div class="form-group">
                                                                    <label for="">Branch</label>
                                                                    <input type="text" title="Branch" name="payment[{{ $loop->index }}][branch]" placeholder="Branch" value="{{ old('payment.'.$loop->index.'.branch', $payment->branch ?? '') }}" class="branch form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 {{ $payment->method == 'Bank' ? '' : 'd-none' }}" method="bank">
                                                                <div class="form-group">
                                                                    <label for="">Routing No</label>
                                                                    <input type="text" title="Routing No" name="payment[{{ $loop->index }}][routing_no]" placeholder="Routing No*" value="{{ old('payment.'.$loop->index.'.routing_no', $payment->routing_no ?? '') }}" class="routing_no form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="">Account Type</label>
                                                                    <input type="text" title="Account Type" name="payment[{{ $loop->index }}][type]" placeholder="Account Type*" value="{{ old('payment.'.$loop->index.'.type', $payment->type) }}" class="form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Account Number</label>
                                                                    <input type="text" title="Account Number" name="payment[{{ $loop->index }}][number]" placeholder="Account Number*" value="{{ old('payment.'.$loop->index.'.number', $payment->number) }}" class="form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            @if (count($reseller->payment ?? []) > 1)
                                                            <div class="col-12">
                                                                <button class="form-group btn btn-danger float-right remove-way">Remove</button>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        @empty
                                                        <div class="row border pt-2">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="">Method</label>
                                                                    <select name="payment[0][method]" class="form-control payment_method @error('payment.0.method') is-invalid @enderror">
                                                                        <option value="">Select Method*</option>
                                                                        @php $old_method = old('payment.0.method') @endphp
                                                                        @foreach(config('transaction.ways') as $way)
                                                                            <option value="{{ $way }}" @if($way == $old_method) selected @endif>{{ $way }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" method="bank" style="display: none;">
                                                                <div class="form-group">
                                                                    <label for="">Bank Name</label>
                                                                    <input type="text" title="Bank Name" name="payment[0][bank_name]" placeholder="Bank Name*" value="{{ old('payment.0.bank_name') }}" class="bank_name form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" method="bank" style="display: none;">
                                                                <div class="form-group">
                                                                    <label for="">Account Name</label>
                                                                    <input type="text" title="Account Name" name="payment[0][account_name]" placeholder="Account Name*" value="{{ old('payment.0.account_name') }}" class="account_name form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" method="bank" style="display: none;">
                                                                <div class="form-group">
                                                                    <label for="">Branch</label>
                                                                    <input type="text" title="Branch" name="payment[0][branch]" placeholder="Branch" value="{{ old('payment.0.branch') }}" class="branch form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" method="bank" style="display: none;">
                                                                <div class="form-group">
                                                                    <label for="">Routing No</label>
                                                                    <input type="text" title="Routing No" name="payment[0][routing_no]" placeholder="Routing No*" value="{{ old('payment.0.routing_no') }}" class="routing_no form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="">Account Type</label>
                                                                    <input type="text" title="Account Type" name="payment[0][type]" placeholder="Account Type*" value="{{ old('payment.0.type') }}" class="form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Account Number</label>
                                                                    <input type="text" title="Account Number" name="payment[0][number]" placeholder="Account Number*" value="{{ old('payment.0.number') }}" class="form-control @error('payment_number') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="item-4" role="tabpanel">
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
                                                    <button type="submit" formaction="{{ route('reseller.password.update') }}" class="btn btn-success">Change Password</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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

        $('#add-way').click(function(e) {
            e.preventDefault();
            var last = $('#ways').children('.input-group').last();
            var id = 0;
            if(last.length) {
                id = last.data('id') + 1;
            }


            $('#ways').append(`<div class="input-group" data-id="`+id+`">
                <select name="payment[`+id+`][method]" class="payment_method form-control @error('payment.`+id+`.method') is-invalid @enderror">
                    <option value="">Select Method*</option>
                    @php $old_method = old('payment.`+id+`.method', $payment->method ?? '') @endphp
                    @foreach(config('transaction.ways') as $way)
                        <option value="{{ $way }}">{{ $way }}</option>
                    @endforeach
                </select>
                <input type="text" name="payment[`+id+`][type]" placeholder="Account Type*" value="{{ old('payment.`+id+`.type') }}" class="form-control @error('payment_number') is-invalid @enderror">
                <input type="text" name="payment[`+id+`][number]" placeholder="Account Number*" value="{{ old('payment.`+id+`.number') }}" class="form-control @error('payment_number') is-invalid @enderror">
                <div class="input-group-append">
                    <span class="input-group-text bg-danger remove-way">&minus;</span>
                </div>
            </div>`);
        });

        $(document).on('click','.remove-way', function(e) {
            e.preventDefault();
            $(this).closest('.row').fadeOut(300, function(){
                $(this).remove();
            })
        });

        $(document).on('change', '.payment_method', function(){
            if($(this).val() == 'Bank') {
                $('[method="Bank"]').removeClass('d-none');
            } else {
                $('[method="Bank"]').addClass('d-none');
            }
        })
    });
</script>
@endsection