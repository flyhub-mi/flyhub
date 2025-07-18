@extends('tenant.layout')

@section('content')
{!! html()->form(route('products.store'))->open() !!}
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Produtos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Catálogo</li>
                    <li class="breadcrumb-item">Produtos</li>
                    <li class="breadcrumb-item active">Criar</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card card-default">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group col-sm-6">
                        {!! html()->label('Conjunto de Atributos:', 'attribute_set_id') !!}
                        {!! html()->select('attribute_set_id', $attributeSets, null)->class('form-control') !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group col-sm-6">
                        {!! html()->label('SKU:', 'sku') !!}
                        {!! html()->text('sku', null)->class('form-control') !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group col-sm-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="new" id="new" value="true">
                            <label class="form-check-label" for="new">Novo</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="new" id="used" value="false">
                            <label class="form-check-label" for="used">Usado</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            {!! html()->submit('Salvar')->class('btn btn-primary') !!}
            <a href="{{ route('products.index') }}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
</section>
{!! html()->form()->close() !!}
@endsection
