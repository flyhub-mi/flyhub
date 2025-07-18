@extends('tenant.layout')

@section('content')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Produtos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Catálogo</li>
            <li class="breadcrumb-item">Produtos</li>
            <li class="breadcrumb-item active">Editar</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    @include('tenant.partials.errors')
    <div id="product-form" model='{{ $product }}'/>
  </section>
@endsection
