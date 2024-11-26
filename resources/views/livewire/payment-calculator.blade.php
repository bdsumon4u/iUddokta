<div class="card rounded-0 shadow-sm">
    @php $is_reseller = ($user = auth('reseller')->user()) && ($user->id ?? 0) == request()->user('reseller')->id @endphp
    <div class="card-header">Pay To <strong>{{ $reseller->name }}</strong></div>
    <div class="card-body">
        <form action="{{ route($is_reseller ? 'reseller.transactions.store' : 'admin.transactions.pay.store') }}" method="post">
            @csrf
            <!-- <h4 class="text-center balance">Balance: {{ $balance }}</h4> -->
            <input type="hidden" name="reseller_id" value="{{ $reseller->id }}">
            <input type="hidden" name="transaction_id" value="{{ request('transaction_id', 0) }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" data-balance="{{ $reseller->balance }}" value="{{ old('amount', request('amount', $amount)) }}" class="form-control @error('amount') is-invalid @enderror" @if(!empty(request('method'))) readonly @endif>
                        @error('amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="method">Method</label>
                        <input type="hidden" name="method" value="{{ old('method', request('method')) }}">
                        <!-- <input type="text" name="method" wire:model.debounce.250ms="method" value="{{ old('method', $method) }}" class="form-control @error('method') is-invalid @enderror"> -->
                        <select name="method" wire:model.debounce.250ms="method" value="{{ old('method', request('method', $method)) }}" wire:change="chMethod" class="form-control @error('method') is-invalid @enderror" @if(!empty(request('method'))) disabled @endif>
                            <option value="">Select Method</option>
                            @if($reseller->payment_methods)
                                @foreach($reseller->payment_methods as $payment)
                                <option value="{{ $payment->method }}">{{ $payment->method }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('method')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if(request('method', $method) == 'Bank')
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', request('bank_name', $bank_name)) }}" class="form-control @error('bank_name') is-invalid @enderror" @if(!empty(request('method'))) readonly @endif>
                        @error('bank_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="account_name">Account Name</label>
                        <input type="text" name="account_name" value="{{ old('account_name', request('account_name', $account_name)) }}" class="form-control @error('account_name') is-invalid @enderror" @if(!empty(request('method'))) readonly @endif>
                        @error('account_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="branch">Branch</label>
                        <input type="text" name="branch" value="{{ old('branch', request('branch', $branch)) }}" class="form-control @error('branch') is-invalid @enderror" @if(!empty(request('method'))) readonly @endif>
                        @error('branch')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="routing_no">Routing No</label>
                        <input type="text" name="routing_no" value="{{ old('routing_no', request('routing_no', $routing_no)) }}" class="form-control @error('routing_no') is-invalid @enderror" @if(!empty(request('method'))) readonly @endif>
                        @error('routing_no')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @endif
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="account_type">Account Type</label>
                        <input type="text" name="account_type" value="{{ old('account_type', request('account_type', $type)) }}" class="form-control @error('account_type') is-invalid @enderror" @if(!empty(request('method'))) readonly @endif>
                        @error('account_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" name="account_number" value="{{ old('account_number', request('account_number', $number)) }}" class="form-control @error('account_number') is-invalid @enderror" @if(!empty(request('method'))) readonly @endif>
                        @error('account_number')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @unless($is_reseller)
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="transaction_number">Transaction Number</label>
                        <input type="text" name="transaction_number" value="{{ old('transaction_number') }}" class="form-control @error('transaction_number') is-invalid @enderror">
                        @error('transaction_number')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @endif
            </div>
            <button type="submit" class="btn btn-sm btn-success ml-auto d-block">{{ $is_reseller ? 'Request' : 'Paid' }}</button>
        </form>
    </div>
</div>