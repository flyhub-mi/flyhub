@extends('layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inquilinos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Admin</li>
                        <li class="breadcrumb-item">Inquilinos</li>
                        <li class="breadcrumb-item active">Novo</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @include('partials.errors')
            <div class="card card-primary">
                <div class="card-body">
                    {!! html()->form(route('tenants.store'))->open() !!}
                    @include('admin.admin.tenants.fields')
                    {!! html()->form()->close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
