<ul>
    @foreach($children as $child)
        <li>
            {{ $child->name }} ->
            <button class="btn btn-link btn-xs" onclick="linkCategory({{$child->id}})" type="button">
                Vincular categoria
            </button>
            @if(count($child->children))
                @include('tenant.channels.categories-tree.children',['children' => $child->children])
            @endif
        </li>
    @endforeach
</ul>
