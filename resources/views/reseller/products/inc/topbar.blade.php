<div class="top-nav">
    <div class="container">
        <div class="top-nav-wrapper clearfix">
            
            <div class="top-nav-right pull-right">
                <ul class="list-inline">
                    <form id="logout-form" action="{{ route('reseller.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <li><a href="{{ route('reseller.home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a class="dropdown-item" href="{{ route('reseller.logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-lock"></i> {{ __('Logout') }}
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>