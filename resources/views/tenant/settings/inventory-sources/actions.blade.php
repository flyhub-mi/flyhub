<div class='btn-group'>
  <a href="{{ route('inventory-sources.edit', $id) }}" class='btn btn-default btn-xs'>
    <i class="fas fa-edit"></i>
  </a>
  <button class="btn btn-danger btn-xs" onclick="confirmDelete('inventory-sources', {{$id}})">
    <i class="fas fa-trash"></i>
  </button>
</div>
