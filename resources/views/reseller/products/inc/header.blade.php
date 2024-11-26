<section class="header-wrapper">
    <div class="header-inner">
        <div class="container">
            <button class="navbar-toggle visible-sm visible-xs pull-left" type="button">
                <span class="top-bar icon-bar"></span>
                <span class="middle-bar icon-bar"></span>
                <span class="bottom-bar icon-bar"></span>
            </button>

            <a href="{{ route('reseller.product.index') }}" class="website-logo pull-left">
                <img src="{{ asset($logo->color) ?? '' }}"
                    alt="header-logo">
            </a>

            @include('reseller.products.partials.mini-cart')
            <div class="search-area pull-left">
                <form action="{{ request()->route()->getName() == 'reseller.product.by-category' ? url()->current() : route('reseller.product.index') }}" method="GET" id="search-box-form">
                    <div class="search-box hidden-sm hidden-xs">
                        <input type="text" name="s" class="search-box-input" placeholder="Search for products..."
                            value="">

                        <div class="search-box-button">
                            <button class="search-box-btn btn btn-primary" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Search
                            </button>
                        </div>
                    </div>

                    <div class="mobile-search visible-sm visible-xs">
                        <div class="dropdown">
                            <div class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </div>

                            <div class="dropdown-menu">
                                <div class="search-box">
                                    <input type="text" name="s" class="search-box-input"
                                        placeholder="Search for products..." value="">

                                    <div class="search-box-button">
                                        <button type="submit" class="search-box-btn btn btn-primary">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>