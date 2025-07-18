<div class='btn-group'>
  <a href="{{ route('taxes.show', $id) }}" class='btn btn-default btn-xs'>
    <i class="fas fa-eye"></i>
  </a>
  <a href="{{ route('taxes.edit', $id) }}" class='btn btn-default btn-xs'>
    <i class="fas fa-edit"></i>
  </a>
  <button class="btn btn-danger btn-xs" onclick="confirmDelete('taxes', {{$id}})">
    <i class="fas fa-trash"></i>
  </button>
</div>
