<div class="nav-panel__nav-links nav-links">
    <ul class="nav-links__list">
        <li class="nav-links__item">
            <a href="{{ url('/') }}">
                <span>Home</span>
            </a>
        </li>
        <li class="nav-links__item">
            <a href="{{ route('products') }}">
                <span>Products</span>
            </a>
        </li>
        <li class="nav-links__item">
            <a href="{{ route('faqs') }}">
                <span>FAQs</span>
            </a>
        </li>
        <li class="nav-links__item">
            <a href="{{ route('reseller.login') }}">
                <span>Login</span>
            </a>
        </li>
        <li class="nav-links__item">
            <a href="{{ route('reseller.register') }}">
                <span class="border">Become a Reseller</span>
            </a>
        </li>
    </ul>
</div>