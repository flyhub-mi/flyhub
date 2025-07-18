@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <h1>
            User
        </h1>
    </section>
    <div class="content">
        @include('tenant.partials.errors')
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    {!! html()->form(route('users.store'))->open() !!}

                        @include('tenant.settings.users.fields')

                    {!! html()->form()->close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
