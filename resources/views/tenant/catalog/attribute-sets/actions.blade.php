<div class='btn-group'>
    <a href="{{ route('attribute-sets.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-edit"></i>
    </a>
    <button class="btn btn-danger btn-xs" onclick="confirmDelete('attribute-sets', {{$id}})">
        <i class="fas fa-trash"></i>
    </button>
</div>
