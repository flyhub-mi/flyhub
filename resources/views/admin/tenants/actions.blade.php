{!! html()->form('DELETE', route('tenants.destroy', $id))->open() !!}
<div class='btn-group'>
    <!-- <a href="{{ route('tenants.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-eye"></i>
    </a> -->
    <a href="{{ route('tenants.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fas fa-edit"></i>
    </a>
    <button class="btn btn-danger btn-xs" onclick="confirmDelete('tenants', {{ $id }})">
        <i class="fas fa-trash"></i>
    </button>
</div>
{!! html()->form()->close() !!}
