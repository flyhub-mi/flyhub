<a href="{{ route('products.edit', $id) }}" class='btn btn-default btn-md'>
  <i class="fas fa-edit"></i>
</a>
<button class="btn btn-danger btn-md" onclick="confirmDelete('products', {{$id}})">
  <i class="fas fa-trash"></i>
</button>
