{!! html()->form(route('subscribers.destroy', $id), 'delete'))->open() !!}
<div class='btn-group'>
    <a href="{{ route('subscribers.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('subscribers.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-edit"></i>
    </a>
    <button class="btn btn-danger btn-xs" onclick="confirmDelete('subscribers', {{$id}})">
      <i class="fas fa-trash"></i>
    </button>
</div>
{!! html()->form()->close() !!}
