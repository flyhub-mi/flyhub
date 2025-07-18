@extends('layout')

@section('content')
    <section class="content-header">
        <h1>
            Tenant
        </h1>
    </section>
    <div class="content">
        <div class="card card-primary">
            <div class="card-body">
                <div class="row" style="padding-left: 20px">
                    <!-- Company Field -->
                    <div class="form-group">
                        {!! html()->label('Company:', 'company') !!}
                        <p>{{ $tenant->company }}</p>
                    </div>

                    <!-- Cnpj Field -->
                    <div class="form-group">
                        {!! html()->label('Cnpj:', 'cnpj') !!}
                        <p>{{ $tenant->cnpj }}</p>
                    </div>

                    <!-- Cpf Field -->
                    <div class="form-group">
                        {!! html()->label('Cpf:', 'cpf') !!}
                        <p>{{ $tenant->cpf }}</p>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        {!! html()->label('Email:', 'email') !!}
                        <p>{{ $tenant->email }}</p>
                    </div>


                    <a href="{{ route('tenants.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
