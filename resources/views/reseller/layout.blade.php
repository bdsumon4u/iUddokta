<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- plugins:css -->
    <!-- <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css"> -->
    <style>
        /*
 * Container style
 */

        @media print {
            .container-fluid.page-body-wrapper {
                padding-top: 0 !important;
            }

            nav.sidebar,
            nav.navbar {
                display: none !important;
            }
        }

        .ps {
            overflow: hidden !important;
            overflow-anchor: none;
            -ms-overflow-style: none;
            touch-action: auto;
            -ms-touch-action: auto;
        }

        /*
 * Scrollbar rail styles
 */
        .ps__rail-x {
            display: none;
            opacity: 0;
            transition: background-color .2s linear, opacity .2s linear;
            -webkit-transition: background-color .2s linear, opacity .2s linear;
            height: 15px;
            /* there must be 'bottom' or 'top' for ps__rail-x */
            bottom: 0px;
            /* please don't change 'position' */
            position: absolute;
        }

        .ps__rail-y {
            display: none;
            opacity: 0;
            transition: background-color .2s linear, opacity .2s linear;
            -webkit-transition: background-color .2s linear, opacity .2s linear;
            width: 15px;
            /* there must be 'right' or 'left' for ps__rail-y */
            right: 0;
            /* please don't change 'position' */
            position: absolute;
        }

        .ps--active-x>.ps__rail-x,
        .ps--active-y>.ps__rail-y {
            display: block;
            background-color: transparent;
        }

        .ps:hover>.ps__rail-x,
        .ps:hover>.ps__rail-y,
        .ps--focus>.ps__rail-x,
        .ps--focus>.ps__rail-y,
        .ps--scrolling-x>.ps__rail-x,
        .ps--scrolling-y>.ps__rail-y {
            opacity: 0.6;
        }

        .ps .ps__rail-x:hover,
        .ps .ps__rail-y:hover,
        .ps .ps__rail-x:focus,
        .ps .ps__rail-y:focus,
        .ps .ps__rail-x.ps--clicking,
        .ps .ps__rail-y.ps--clicking {
            background-color: #eee;
            opacity: 0.9;
        }

        /*
 * Scrollbar thumb styles
 */
        .ps__thumb-x {
            background-color: #aaa;
            border-radius: 6px;
            transition: background-color .2s linear, height .2s ease-in-out;
            -webkit-transition: background-color .2s linear, height .2s ease-in-out;
            height: 6px;
            /* there must be 'bottom' for ps__thumb-x */
            bottom: 2px;
            /* please don't change 'position' */
            position: absolute;
        }

        .ps__thumb-y {
            background-color: #aaa;
            border-radius: 6px;
            transition: background-color .2s linear, width .2s ease-in-out;
            -webkit-transition: background-color .2s linear, width .2s ease-in-out;
            width: 6px;
            /* there must be 'right' for ps__thumb-y */
            right: 2px;
            /* please don't change 'position' */
            position: absolute;
        }

        .ps__rail-x:hover>.ps__thumb-x,
        .ps__rail-x:focus>.ps__thumb-x,
        .ps__rail-x.ps--clicking .ps__thumb-x {
            background-color: #999;
            height: 11px;
        }

        .ps__rail-y:hover>.ps__thumb-y,
        .ps__rail-y:focus>.ps__thumb-y,
        .ps__rail-y.ps--clicking .ps__thumb-y {
            background-color: #999;
            width: 11px;
        }

        /* MS supports */
        @supports (-ms-overflow-style: none) {
            .ps {
                overflow: auto !important;
            }
        }

        @media screen and (-ms-high-contrast: active),
        (-ms-high-contrast: none) {
            .ps {
                overflow: auto !important;
            }
        }
    </style>
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('css/stellar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stellar-style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset($logo->favicon ?? '') ?? '' }}" type="image/x-icon">
    @stack('styles')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <x-layouts.header setting="reseller.setting.profile" logout="reseller.logout" />
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <x-layouts.sidebar :menu="$menu" setting="reseller.setting.profile" />
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success py-2"><strong>{{ $message }}</strong></div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger py-2"><strong>{{ $message }}</strong></div>
                    @endif
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('js/stellar.js') }}"></script>
    <!-- endinject -->
    <script src="{{ asset('js/misc.js') }}"></script>
    @stack('scripts')
    <script>
        function setSidebarHeight() {
            const viewportHeight = window.innerHeight;
            const headerHeight = 70; // Adjust based on your header height
            const sidebarHeight = viewportHeight - headerHeight;

            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.style.minHeight = `${sidebarHeight}px`;
            }
        }

        // Set the sidebar height on load and resize
        window.addEventListener('load', setSidebarHeight);
        window.addEventListener('resize', setSidebarHeight);
    </script>
    <!-- endinject -->
    <!-- End custom js for this page -->
</body>

</html>
