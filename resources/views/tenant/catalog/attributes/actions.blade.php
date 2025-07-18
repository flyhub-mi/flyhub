<div class='btn-group'>
  <a href="{{ route('attributes.show', $id) }}" class='btn btn-default btn-xs'>
    <i class="fas fa-eye"></i>
  </a>
  <a href="{{ route('attributes.edit', $id) }}" class='btn btn-default btn-xs'>
    <i class="fas fa-edit"></i>
  </a>
  <button class="btn btn-danger btn-xs" onclick="confirmDelete('attributes', {{$id}})">
    <i class="fas fa-trash"></i>
  </button>
</div>
