<div class="sidebar">
    <ul class="sidebar-content clearfix">
        @foreach (App\Models\Category::formatted() as $category)
            <li class="">
                <a href="{{ route('reseller.product.by-category', [$category->slug, $category->id]) }}">
                    {{ $category->name }}
                </a>
                @includeUnless($category->childrens->isEmpty(), 'reseller.products.partials.sub-cat', [
                    'categories' => $category->childrens,
                    'liclass' => 'submenu',
                ])
            </li>
        @endforeach
    </ul>
    <ul class="vertical nav navbar-nav">
        @foreach (menuItems($header_menu->id ?? null) as $item)
            <li class="menu_item">
                <a href="{{ url($item->url) }}">
                    <span class="menu-icon"></span>
                    <span class="menu-title">{{ $item->title }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
