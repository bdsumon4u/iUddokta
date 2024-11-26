@extends('reseller.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header py-2">Reseller <strong>Setting</strong></div>
            <div class="card-body p-2">
                <form action="{{ route('reseller.setting.payment') }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-sm-12">
                            <h4><small class="border-bottom mb-1">Transaction</small></h4>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" id="ways">
                                <label for="payment">Payment Method</label>
                                @forelse(auth('reseller')->user()->payment ?? [] as $payment)
                                <div class="row border mx-2 pt-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Method <span class="text-danger">*</span></label>
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
                                            <label for="">Bank Name <span class="text-danger">*</span></label>
                                            <input type="text" title="Bank Name" name="payment[{{ $loop->index }}][bank_name]" placeholder="Bank Name*" value="{{ old('payment.'.$loop->index.'.bank_name', $payment->bank_name ?? '') }}" class="bank_name form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4 {{ $payment->method == 'Bank' ? '' : 'd-none' }}" method="bank">
                                        <div class="form-group">
                                            <label for="">Account Name <span class="text-danger">*</span></label>
                                            <input type="text" title="Account Name" name="payment[{{ $loop->index }}][account_name]" placeholder="Account Name*" value="{{ old('payment.'.$loop->index.'.account_name', $payment->account_name ?? '') }}" class="account_name form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-2 {{ $payment->method == 'Bank' ? '' : 'd-none' }}" method="bank">
                                        <div class="form-group">
                                            <label for="">Branch <span class="text-danger">*</span></label>
                                            <input type="text" title="Branch" name="payment[{{ $loop->index }}][branch]" placeholder="Branch" value="{{ old('payment.'.$loop->index.'.branch', $payment->branch ?? '') }}" class="branch form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-2 {{ $payment->method == 'Bank' ? '' : 'd-none' }}" method="bank">
                                        <div class="form-group">
                                            <label for="">Routing No <span class="text-danger">*</span></label>
                                            <input type="text" title="Routing No" name="payment[{{ $loop->index }}][routing_no]" placeholder="Routing No*" value="{{ old('payment.'.$loop->index.'.routing_no', $payment->routing_no ?? '') }}" class="routing_no form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Account Type <span class="text-danger">*</span></label>
                                            <input type="text" title="Account Type" name="payment[{{ $loop->index }}][type]" placeholder="Account Type*" value="{{ old('payment.'.$loop->index.'.type', $payment->type) }}" class="form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Account Number <span class="text-danger">*</span></label>
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
                                <div class="row border mx-2 pt-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Method <span class="text-danger">*</span></label>
                                            <select name="payment[0][method]" class="form-control payment_method @error('payment.0.method') is-invalid @enderror">
                                                <option value="">Select Method*</option>
                                                @php $old_method = old('payment.0.method') @endphp
                                                @foreach(config('transaction.ways') as $way)
                                                    <option value="{{ $way }}" @if($way == $old_method) selected @endif>{{ $way }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-none" method="bank">
                                        <div class="form-group">
                                            <label for="">Bank Name <span class="text-danger">*</span></label>
                                            <input type="text" title="Bank Name" name="payment[0][bank_name]" placeholder="Bank Name*" value="{{ old('payment.0.bank_name') }}" class="bank_name form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-none" method="bank">
                                        <div class="form-group">
                                            <label for="">Account Name <span class="text-danger">*</span></label>
                                            <input type="text" title="Account Name" name="payment[0][account_name]" placeholder="Account Name*" value="{{ old('payment.0.account_name') }}" class="account_name form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-none" method="bank">
                                        <div class="form-group">
                                            <label for="">Branch <span class="text-danger">*</span></label>
                                            <input type="text" title="Branch" name="payment[0][branch]" placeholder="Branch" value="{{ old('payment.0.branch') }}" class="branch form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-none" method="bank">
                                        <div class="form-group">
                                            <label for="">Routing No <span class="text-danger">*</span></label>
                                            <input type="text" title="Routing No" name="payment[0][routing_no]" placeholder="Routing No*" value="{{ old('payment.0.routing_no') }}" class="routing_no form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Account Type <span class="text-danger">*</span></label>
                                            <input type="text" title="Account Type" name="payment[0][type]" placeholder="Account Type*" value="{{ old('payment.0.type') }}" class="form-control @error('payment_number') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Account Number <span class="text-danger">*</span></label>
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