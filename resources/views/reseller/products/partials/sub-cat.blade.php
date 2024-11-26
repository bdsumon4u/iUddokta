
<ul>
    @foreach($categories as $category)
    <li class="{{ $liclass ?? '' }}">
        <a href="{{ route('reseller.product.by-category', [$category->slug, $category->id]) }}">
            {{ $category->name }}
        </a>
        @includeUnless($category->childrens->isEmpty(), 'reseller.products.partials.sub-cat', ['categories' => $category->childrens])
    </li>
    @endforeach
</ul>