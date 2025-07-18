@extends('layout')

@section('content')
    <section class="content-header">
        <h1>
            Tenant
        </h1>
    </section>
    <div class="content">
        @include('partials.errors')
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    {!! html()->modelForm($tenant, 'PATCH', route('tenants.update', $tenant->id)]) !!}

                    @include('admin.admin.tenants.fields')

                    {!! html()->form()->close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
