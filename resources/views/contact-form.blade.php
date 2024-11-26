<div class="row">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-8">
                <div class="box-wrapper contact-left clearfix">
                    {{-- <div class="box-header">
                        <h4>Send Us a Message</h4>
                    </div> --}}

                    <div class="box-body">
                        <form method="POST" action="{{ route('contact') }}" class="clearfix">
                            @csrf
                            <div class="form-group ">
                                <label for="email">Email<span>*</span></label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @endif" id="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="text-danger invalid-feedback">{{ $message }}</span>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="subject">Subject<span>*</span></label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @endif" id="subject" value="{{ old('subject') }}">
                                @error('email')
                                <span class="text-danger invalid-feedback">{{ $message }}</span>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="message">Message<span>*</span></label>
                                <textarea name="message" cols="30" rows="10" id="message" class="form-control @error('message') is-invalid @endif">{{ old('message') }}</textarea>
                                @error('message')
                                <span class="text-danger invalid-feedback">{{ $message }}</span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit pull-right" data-loading="">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-right clearfix">
                    <div class="contact-info">
                        <div class="contact-text">
                            <h4>Phone</h4>
                            <span>{{ $contact->phone ?? '' }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="contact-info">
                        <div class="contact-text">
                            <h4>Email</h4>
                            <span>{{ $company->email ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>