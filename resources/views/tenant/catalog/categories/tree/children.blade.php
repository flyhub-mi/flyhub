<ul>
    @foreach($children as $child)
        <li>
            {{ $child->name }}
            @if(count($child->children))
                @include('tenant.catalog.categories.tree.children',['children' => $child->children])
            @endif
        </li>
    @endforeach
</ul>
