<header class="site__header d-lg-none">
    @include('partials.topbar')
    <div class="mobile-header mobile-header--sticky mobile-header--stuck">
        <div class="mobile-header__panel">
            <div class="container">
                <div class="mobile-header__body">
                    <a class="mobile-header__logo" href="{{ url('/') }}">
                        <img src="{{ asset($logo->white ?? '') }}" width="{{ config('services.logo.mobile.width', 192) }}" height="{{ config('services.logo.mobile.height', 40) }}" alt="Logo" style="max-width: 100%;">
                    </a>
                    <div class="mobile-header__indicators">
                        <div class="indicator indicator--mobile-search indicator--mobile d-sm-none">
                            <a href="{{ route('products') }}" class="indicator__button">
                                <strong class="indicator__area">
                                    Products
                                </strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>