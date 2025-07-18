<div class='btn-group'>
  <a href="{{ route('tax-groups.edit', $id) }}" class='btn btn-default btn-xs'>
    <i class="fas fa-edit"></i>
  </a>
  <button class="btn btn-danger btn-xs" onclick="confirmDelete('tax-groups', {{$id}})">
    <i class="fas fa-trash"></i>
  </button>
</div>
