@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <h1>
            Permisões
        </h1>
    </section>
    <section class="content">
        @include('tenant.partials.errors')
        <div class="card card-primary">
            <div class="card-body">
                {!! html()->modelForm($role, 'PATCH', route('roles.update', $role->id)) !!}

                @include('tenant.admin.roles.fields')

                {!! html()->form()->close() !!}
            </div>
        </div>
    </section>
@endsection
