@extends('layouts.welcome')

@section('content')
<!--====== HEADER PART START ======-->

    <section class="header_area">
        

        <div id="home" class="header_hero bg-gray relative z-10 overflow-hidden lg:flex items-center">
            <div class="hero_shape shape_1">
                <img src="assets/images/shape/shape-1.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_2">
                <img src="assets/images/shape/shape-2.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_3">
                <img src="assets/images/shape/shape-3.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_4">
                <img src="assets/images/shape/shape-4.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_6">
                <img src="assets/images/shape/shape-1.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_7">
                <img src="assets/images/shape/shape-4.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_8">
                <img src="assets/images/shape/shape-3.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_9">
                <img src="assets/images/shape/shape-2.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_10">
                <img src="assets/images/shape/shape-4.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_11">
                <img src="assets/images/shape/shape-1.svg" alt="shape">
            </div><!-- hero shape -->
            <div class="hero_shape shape_12">
                <img src="assets/images/shape/shape-2.svg" alt="shape">
            </div><!-- hero shape -->

            <div class="container">
                <div class="row">
                    <div class="w-full lg:w-1/2">
                        <div class="header_hero_content pt-150 lg:pt-0">
                            <h2 class="hero_title text-2xl sm:text-4xl md:text-5xl lg:text-4xl xl:text-5xl font-extrabold">{{ $company->tagline ?? 'Make Your Business More Profitable' }}</h2>
                            <div class="hero_btn text-center mt-10">
                                <a class="main-btn" href="{{ route('reseller.register') }}">Become a Reseller</a>
                                <div class="mt-4 flex lg:block justify-center" style="gap:2rem;">
                                    {{-- Phone Number --}}
                                    <a href="tel:{{ $contact->phone ?? '' }}" style="display:flex; color:crimson; gap:1rem;">
                                        <svg width="30" hight="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"></path></svg>
                                        <strong class="hidden lg:block" style="font-size: 30px;">{{ $contact->phone ?? '' }}</strong>
                                    </a>
                                    {{-- Email Address --}}
                                    <a href="mailto:{{ $company->email ?? '' }}" style="display:flex; color:crimson; gap:1rem;">
                                        <svg width="30" hight="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M2.24283 6.85419L11.4895 1.30843C11.8062 1.11848 12.2019 1.11855 12.5185 1.30862L21.7573 6.85416C21.9079 6.94453 22 7.10726 22 7.28286V19.9998C22 20.5521 21.5523 20.9998 21 20.9998H3C2.44772 20.9998 2 20.5521 2 19.9998V7.28298C2 7.10732 2.09218 6.94454 2.24283 6.85419ZM4 8.13244V18.9998H20V8.13197L12.0037 3.33221L4 8.13244ZM12.0597 13.6981L17.3556 9.23515L18.6444 10.7645L12.074 16.3016L5.36401 10.7715L6.63599 9.22813L12.0597 13.6981Z"></path></svg>
                                        <strong class="hidden lg:block" style="font-size: 30px;">{{ $company->email ?? '' }}</strong>
                                    </a>
                                    {{-- Facebook --}}
                                    <a href="{{ $social->facebook->link ?? '' }}" style="display:flex; color:crimson; gap:1rem;">
                                        <svg width="30" hight="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M14 19H19V5H5V19H12V14H10V12H12V10.3458C12 9.00855 12.1392 8.52362 12.4007 8.03473C12.6622 7.54584 13.0458 7.16216 13.5347 6.9007C13.9174 6.69604 14.3922 6.57252 15.2217 6.51954C15.551 6.49851 15.9771 6.52533 16.5 6.6V8.5H16C15.0827 8.5 14.7042 8.54332 14.4779 8.66433C14.3376 8.73939 14.2394 8.83758 14.1643 8.97793C14.0433 9.20418 14 9.42853 14 10.3458V12H16.5L16 14H14V19ZM4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3Z"></path></svg>
                                        <strong class="hidden lg:block" style="font-size: 30px;">{{ $social->facebook->link ?? '' }}</strong>
                                    </a>
                                </div>
                            </div>
                        </div> <!-- header hero content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            <div class="header_shape hidden lg:block"></div>

            <div class="header_image flex items-center">
                <div class="image 2xl:pl-25">
                    <img src="{{ asset('assets/images/header-image.svg') }}" alt="Header Image">
                </div>
            </div> <!-- header image -->
        </div> <!-- header hero -->
    </section>

    <!--====== HEADER PART ENDS ======-->

    <!--====== LOGIN PART START ======-->

    <!--====== FOOTER PART START ======-->

    <footer id="footer" class="footer_area bg-black relative z-10">
        <div class="container">
            <div class="footer_copyright pt-3 pb-6 border-t-2 border-solid border-white border-opacity-10 sm:flex justify-between">
                <div class="footer_social pt-4 mx-3 text-center">
                    <ul class="social flex justify-center sm:justify-start">
                        <li class="mr-3"><a href="{{ $social->facebook->link ?? '' }}"><i class="lni lni-facebook-filled"></i></a></li>
                        <li class="mr-3"><a href="{{ $social->twitter->link ?? '' }}"><i class="lni lni-twitter-filled"></i></a></li>
                        <li class="mr-3"><a href="{{ $social->instagram->link ?? '' }}"><i class="lni lni-instagram-original"></i></a></li>
                        <li class="mr-3"><a href="{{ $social->youtube->link ?? '' }}"><i class="lni lni-youtube"></i></a></li>
                    </ul>
                </div> <!-- footer social -->
                <div class="footer_copyright_content pt-4 text-center">
                    <p class="text-white">Developed by <a href="https://cyber32.com" rel="nofollow" class="text-white hover:text-theme-color" style="color:red;">Cyber 32</a></p>
                </div> <!-- footer copyright content -->
            </div> <!-- footer copyright -->
        </div> <!-- container -->
    </footer>

    <!--====== FOOTER PART ENDS ======-->
    
    <!--====== BACK TOP TOP PART START ======-->

    <a href="#" class="scroll-top"><i class="lni lni-chevron-up"></i></a>

    <!--====== BACK TOP TOP PART ENDS ======-->    

    <!--====== PART START ======-->

<!--
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-">
                    
                </div>
            </div>
        </div>
    </section>
-->

    <!--====== PART ENDS ======-->
@endsection