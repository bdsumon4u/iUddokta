<div class="product-list-sidebar clearfix">
    <div class="filter-section clearfix">
        <h4>Category</h4>

        <ul class="filter-category list-inline">
            @foreach (App\Models\Category::formatted() as $category)
                <li class="">
                    <a href="{{ route('reseller.product.by-category', [$category->slug, $category->id]) }}">
                        {{ $category->name }}
                    </a>
                    @includeUnless($category->childrens->isEmpty(), 'reseller.products.partials.sub-cat', [
                        'categories' => $category->childrens,
                    ])
                </li>
            @endforeach
        </ul>
    </div>
</div>
