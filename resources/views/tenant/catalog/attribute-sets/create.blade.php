@extends('tenant.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Criar conjunto de atributos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item">Catalogo</li>
                    <li class="breadcrumb-item"><a href="{{ route('attribute-sets.index') }}">Conjuntos</a></li>
                    <li class="breadcrumb-item active">Criar</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    @include('tenant.partials.errors')
    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                {!! html()->form(route('attribute-sets.store'))->open() !!}
                @include('tenant.catalog.attribute-sets.fields')
                {!! html()->form()->close() !!}
            </div>
        </div>
    </div>
</section>
@endsection
