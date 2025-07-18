{!! html()->form(route('roles.destroy', $id), 'delete'))->open() !!}
<div class='btn-group'>
  <a href="{{ route('roles.show', $id) }}" class='btn btn-default btn-xs'>
    <i class="fas fa-eye"></i>
  </a>
  <a href="{{ route('roles.edit', $id) }}" class='btn btn-default btn-xs'>
    <i class="fas fa-edit"></i>
  </a>
  <button class="btn btn-danger btn-xs" onclick="confirmDelete('roles', {{$id}})">
    <i class="fas fa-trash"></i>
  </button>
</div>
{!! html()->form()->close() !!}
