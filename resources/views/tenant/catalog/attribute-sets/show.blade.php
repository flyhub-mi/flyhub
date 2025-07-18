@extends('tenant.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Exibir Conjunto</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item">Catalogo</li>
                    <li class="breadcrumb-item"><a href="{{ route('attribute-sets.index') }}">Conjuntos</a></li>
                    <li class="breadcrumb-item active">Exibir</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card card-primary">
        <div class="card-body">
            <div class="row" style="padding-left: 20px">
                <!-- Name Field -->
                <div class="form-group">
                    {!! html()->label('Name:', 'name') !!}
                    <p>{{ $attributeSet->name }}</p>
                </div>

                <a href="{{ route('attribute-sets.index') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</section>
@endsection
