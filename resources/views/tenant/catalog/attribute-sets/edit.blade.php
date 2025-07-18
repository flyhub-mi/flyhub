@extends('tenant.layout')

@section('content')
<section class="content-header px-4">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Adicionar Conjunto</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item">Catalogo</li>
                    <li class="breadcrumb-item"><a href="{{ route('attribute-sets.index') }}">Conjuntos de atributos</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content px-4">
    @include('tenant.partials.errors')
    <div id="attribute-set-form" model='{{ $attributeSet ?? '{}' }}' action="{{route('attribute-sets.update', ['attribute_set' => 1])}}" method="patch" errors="{{$errors ?? '[]'}}" />
</section>
@endsection
