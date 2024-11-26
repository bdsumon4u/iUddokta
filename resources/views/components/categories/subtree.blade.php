<ul>
    @foreach($childrens as $children)
        <li class="{{ request('active_id', 0) == $children->id ? 'active' : '' }}">@for($i = $depth; $i; $i--) | -- @endfor <a href="?active_id={{ $children->id }}">{{ $children->name }}</a></li>
        @include('components.categories.subtree', ['childrens' => $children->childrens, 'depth' => $depth + 1])
    @endforeach
</ul>