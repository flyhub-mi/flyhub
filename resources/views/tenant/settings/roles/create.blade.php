@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <h1>
            Roles
        </h1>
    </section>
    <section class="content">
        @include('tenant.partials.errors')
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    {!! html()->form(route('roles.store'))->open() !!}
                        @include('tenant.admin.roles.fields')
                    {!! html()->form()->close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
