<ul>
    @foreach($categories as $category)
        <li class="{{ request('active_id', 0) == $category->id ? 'active' : '' }}"><a href="?active_id={{ $category->id }}">{{ $category->name }}</a></li>
        @include('components.categories.subtree', ['childrens' => $category->childrens, 'depth' => 1])
    @endforeach
</ul>