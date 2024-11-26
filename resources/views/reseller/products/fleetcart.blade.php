<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @section('title')
    <title>{{ $company->name ?? config('app.name') }} - {{ $company->tagline ?? 'Make Your Business More Profitable.' }}</title>
    @show

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Rubik:400,500" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/fleetcart.css') }}">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://tonnicollection.com/themes/storefront/public/css/app.css?v=1.1.9"> -->
    <!-- <link rel="stylesheet" href="{{ asset('css/shop.css') }}"> -->
    <link rel="shortcut icon"
        href="{{ asset($logo->favicon ?? '') ?? '' }}"
        type="image/x-icon">
    <style>
        #overlayer {
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 7100;
            background: #fff;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        .loader {
            z-index: 7700;
            position: fixed;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        @-webkit-keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
        }

        @keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
        }
        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner-border 0.75s linear infinite;
            animation: spinner-border 0.75s linear infinite;
        }

        .mini-cart-title a {
            text-decoration: none;
        }
        .search-area .mobile-search .dropdown-menu {
            min-width: 280px;
        }
        .category-menu-wrapper.show .fa-angle-down {
            transform: rotate(180deg);
        }
        @media screen and (min-width: 681px)
        {
            .product-list-result .grid-products .product-card:nth-child(-n+4) {
                margin-top: 20px;
            }
        }
        @media screen and (min-width: 991px)
        {
            .product-list-result .grid-products {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        .product-card .image-holder,
        .product-card .image-placeholder {
            /* border: 2px solid #ddd; */
        }
        .base-image-inner img {
            height: 100% !important;
            width: 100% !important;
        }
        .cart-list .table-responsive td:nth-child(6) {
            width: auto;
        }
        .charge-box {
            display: flex;
            align-items: center;
            margin-right: 0;
        }
        .charge-box input {
            width: 100px;
            margin-left: auto;
            padding: 2px 5px;
            max-height: 35px !important;
        }
    </style>
    @yield('styles')
</head>

<body class="theme-navy-blue slider_with_banners ltr">
    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!--[if lt IE 8]>
            <p>You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="main">
        <div class="wrapper">
            @include('reseller.products.inc.sidebar')
            @include('reseller.products.inc.topbar')
            @include('reseller.products.inc.header')
            
            @include('reseller.products.partials.mega-menu')

            <div class="content-wrapper clearfix ">
                <div class="container">
                    
                    @unless (request()->routeIs('home') || request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('reset') || request()->routeIs('reset.complete'))
                        @include('reseller.products.partials.notification')
                    @endunless

                    @yield('content')

                </div>
            </div>


            @include('reseller.products.inc.footer')

            <a class="scroll-top" href="#">
                <i class="fa fa-angle-up" aria-hidden="true"></i>
            </a>

        </div>

        <div class="modal fade" id="quick-view-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body clearfix">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- Latest compiled JavaScript -->
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
    <!-- <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script> -->
    <!-- <script src="https://tonnicollection.com/themes/storefront/public/js/app.js?v=1.1.9"></script> -->
    <script src="{{ asset('js/fleetcart.js') }}"></script>
    @yield('scripts')
    <script>
        $(document).ready(function(){
            $(".loader").delay(1000).fadeOut("slow"); $("#overlayer").delay(1000).fadeOut("slow");
        });
    </script>
</body>

</html>
