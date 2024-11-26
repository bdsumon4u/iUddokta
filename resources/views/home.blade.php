@extends('layouts.yellow.master')

@section('content')

            @include('partials.slides')

<div class="block">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card flex-grow-1 mb-md-0">
                    <div class="card-body">
                        <h3 class="card-title">{{ $form_title->login ?? 'Login' }}</h3>
                        <form action="{{route('reseller.login')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Email Address</label> <span class="text-danger">*</span>
                                <input class="form-control" type="email" name="email" placeholder="Enter Email" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label> <span class="text-danger">*</span>
                                <input class="form-control" type="password" name="password" placeholder="Password" />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">
                                    <a href="{{ route('reseller.password.request') }}">Forgot Password?</a>
                                </small>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <span class="form-check-input input-check">
                                        <span class="input-check__body">
                                            <input class="input-check__input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="input-check__box"></span>
                                            <svg class="input-check__icon" width="9px" height="7px">
                                                <use xlink:href="{{ asset('strokya/images/sprite.svg#check-9x7') }}"></use>
                                            </svg>
                                        </span>
                                    </span>
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Login</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex mt-4 mt-md-0">
                <div class="card flex-grow-1 mb-0">
                    <div class="card-body">
                        <h3 class="card-title">{{ $form_title->registration ?? 'Register' }}</h3>
                        <form action="{{route('reseller.register')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Name</label> <span class="text-danger">*</span>
                                        <input class="form-control" name="name" placeholder="Enter Your Name" />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Email Address</label> <span class="text-danger">*</span>
                                    <input class="form-control" type="email" name="email" placeholder="Enter Email" />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone Number</label> <span class="text-danger">*</span>
                                    <input class="form-control" name="phone" placeholder="Enter Phone Number" value="+880" />
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Password</label> <span class="text-danger">*</span>
                                    <input class="form-control" type="password" name="password" placeholder="Password" />
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Confirm Password</label> <span class="text-danger">*</span>
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Retype Password" />
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<style>
h1 {
  text-align: center;
  margin: 2rem 0;
  font-size: 2.5rem;
}
.accordion-item {
  background-color: #fff;
  color: #111;
  margin: 1rem 0;
  border-radius: 0.5rem;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.25);
}
.accordion-item-header {
  padding: 0.5rem 3rem 0.5rem 1rem;
  min-height: 3.5rem;
  line-height: 1.25rem;
  font-weight: bold;
  display: flex;
  align-items: center;
  position: relative;
  cursor: pointer;
}
.accordion-item-header::after {
  content: "\002B";
  font-size: 2rem;
  position: absolute;
  right: 1rem;
}
.accordion-item-header.active::after {
  content: "\2212";
}
.accordion-item-body {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
.accordion-item-body-content {
  padding: 1rem 1.5rem;
  line-height: 1.5rem;
  border-top: 1px solid;
  border-image: linear-gradient(to right, transparent, #34495e, transparent) 1;
}

@media (max-width: 767px) {
  html {
    font-size: 14px;
  }
}
</style>
<h1>FAQ'S</h1>

<div class="accordion">
    @foreach($faqs as $faq)
  <div class="accordion-item">
    <div class="accordion-item-header">
      {{ $faq->question }}
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
        {!! $faq->answer !!}
      </div>
    </div>
  </div>
  @endforeach
</div>
<script>
    const accordionItemHeaders = document.querySelectorAll(
  ".accordion-item-header"
);

accordionItemHeaders.forEach((accordionItemHeader) => {
  accordionItemHeader.addEventListener("click", (event) => {
    // Uncomment in case you only want to allow for the display of only one collapsed item at a time!

    const currentlyActiveAccordionItemHeader = document.querySelector(
      ".accordion-item-header.active"
    );
    if (
      currentlyActiveAccordionItemHeader &&
      currentlyActiveAccordionItemHeader !== accordionItemHeader
    ) {
      currentlyActiveAccordionItemHeader.classList.toggle("active");
      currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
    }
    accordionItemHeader.classList.toggle("active");
    const accordionItemBody = accordionItemHeader.nextElementSibling;
    if (accordionItemHeader.classList.contains("active")) {
      accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
    } else {
      accordionItemBody.style.maxHeight = 0;
    }
  });
});
</script>
    </div>
</div>
@endsection