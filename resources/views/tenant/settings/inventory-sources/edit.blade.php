@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Origem do inventário</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Configurações</li>
                        <li class="breadcrumb-item">Origem do inventário</li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @include('flash::message')
            <div class="card card-primary">
                <div class="card-body">
                    {!! html()->modelForm($inventorySource, 'PATCH', route('inventory-sources.update', $inventorySource->id)) !!}
                    @include('tenant.settings.inventory-sources.fields')
                    {!! html()->form()->close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection

