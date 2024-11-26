<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ url('/') }}" target="_blank">
            <img src="{{ asset($logo->white ?? '') ?? '' }}" alt="logo" class="logo-dark" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}" target="_blank"><img src="{{ asset($logo->favicon ?? '') ?? '' }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
        <h5 class="mb-0 font-weight-medium d-none d-lg-flex">{{ config('app.name') }} Dashboard!</h5>
        <ul class="navbar-nav navbar-nav-right ml-auto">
            @if($count = $attributes->get('count', false))
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator message-dropdown" href="{{ route('cart.checkout') }}">
                <i class="icon-basket-loaded"></i>
                <span class="count">{{ $count }}</span>
              </a>
            </li>
            @endif
            @php auth()->check() ? $user = auth()->user() : (auth('reseller')->check() ? $user = auth('reseller')->user() : $user = optional()) @endphp
            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                    aria-expanded="false">
                    <img class="img-xs rounded-circle ml-2"
                        src="{{ asset('images/landing/person_' . mt_rand(1, 6) . '.webp') }}" alt="Profile image"> <span
                        class="font-weight-normal"> {{ $user->name }} </span></a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <p class="mb-1 mt-3">{{ $user->name }}</p>
                        <p class="font-weight-light text-muted mb-0">{{ $user->email }}</p>
                    </div>
                    <a href="{{ route($attributes->get('setting', 'admin.settings.edit')) }}" class="dropdown-item"><i
                            class="dropdown-item-icon icon-energy text-primary"></i> Settings</a>

                    @php $logout = $attributes->get('logout', 'logout') @endphp
                    <a class="dropdown-item" href="{{ route($logout) }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        <i class="dropdown-item-icon icon-power text-primary"></i>Sign Out</a>

                    <form id="logout-form" action="{{ route($logout) }}"
                        method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
