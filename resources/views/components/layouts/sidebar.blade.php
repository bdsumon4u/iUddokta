<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ route($attributes->get('setting', 'admin.settings.edit')) }}" class="nav-link">
                <div class="profile-image">
                    <img class="img-xs rounded-circle" src="{{ asset('images/landing/person_' . mt_rand(1, 6) . '.webp') }}"
                        alt="profile image">
                    <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                    <p class="profile-name">{{ (auth()->check() ? auth()->user() : (auth('reseller')->check() ? auth('reseller')->user() : optional()))->name }}</p>
                    <p class="designation">Administrator</p>
                </div>
            </a>
        </li>
        @foreach ($menu as $single)
            @switch($single['style'])
                @case('title')
                    <li class="nav-item nav-category"><span class="nav-link">{{ $single['name'] }}</span></li>
                @break

                @case('dropdown')
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                            data-target="#submenu-{{ $loop->index }}" aria-controls="submenu-{{ $loop->index }}">
                            <span class="menu-title">{{ $single['name'] }}</span>
                            <i class="menu-icon {{ $single['icon'] ?? '' }}"></i>
                            @if (array_key_exists('badge', $single))
                                <span
                                    class="badge badge-{{ $single['badge']['variant'] ?? 'primary' }}">{{ $single['badge']['data'] }}</span>
                            @endif
                        </a>
                        <div id="submenu-{{ $loop->index }}" class="collapse submenu" style="">
                            <ul class="nav flex-column sub-menu">
                                @foreach ($single['items'] as $item)
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ isset($item['route']) ? route($item['route'], $item['param'] ?? []) : (isset($item['url']) ? url($item['url']) : '') }}">
                                            <i class="nav-icon {{ $item['icon'] ?? '' }}"></i> {{ $item['name'] }}
                                            @if (array_key_exists('badge', $item))
                                                <span
                                                    class="badge badge-{{ $item['badge']['variant'] ?? 'primary' }}">{{ $item['badge']['data'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @break

                @case('simple')
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ isset($single['route']) ? route($single['route'], $single['param'] ?? []) : (isset($single['url']) ? url($single['url']) : '') }}">
                            <span class="menu-title">{{ $single['name'] }}</span>
                            <i class="menu-icon {{ $single['icon'] ?? '' }}"></i>
                            @if (array_key_exists('badge', $single))
                                <span
                                    class="badge badge-{{ $single['badge']['variant'] ?? 'primary' }}">{{ $single['badge']['data'] }}</span>
                            @endif
                        </a>
                    </li>
                @break
            @endswitch
        @endforeach
    </ul>
    @if(auth('reseller')->check())
    @include('reseller.aside.account')
    @endif
</nav>
