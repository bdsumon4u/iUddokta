<header class="site__header d-lg-block d-none">
    <div class="site-header">
        <!-- .topbar -->
        @include('partials.topbar')
        <!-- .topbar / end -->
        <div class="site-header__middle container justify-content-between text-white">
            <div class="site-header__logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset($logo->white ?? '') }}" width="{{ config('services.logo.desktop.width', 260) }}" height="{{ config('services.logo.desktop.height', 54) }}" alt="Logo" style="max-width: 100%;">
                </a>
            </div>
            @include('partials.header.menu.desktop')
        </div>
    </div>
</header>