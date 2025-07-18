<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Categorias</h3>
    </div>
    <div class="card-body">
        <ul class="categories-tree">
            @foreach($categories as $item)
                <li>
                    {{ $item->name }}
                    @if(count($item->children))
                        @include('tenant.channels.categories-tree.children',['children' => $item->children])
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
