@extends('tenant.layout')

@section('content')
<section class="content-header">
    <h1>
        User
    </h1>
</section>
<div class="content">
    <div class="card card-primary">
        <div class="card-body">
            <div class="row" style="padding-left: 20px">
                <!-- Name Field -->
                <div class="form-group">
                    {!! html()->label('Name:', 'name') !!}
                    <p>{{ $user->name }}</p>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    {!! html()->label('Email:', 'email') !!}
                    <p>{{ $user->email }}</p>
                </div>

                <!-- Email Verified At Field -->
                <div class="form-group">
                    {!! html()->label('Email Verified At:', 'email_verified_at') !!}
                    <p>{{ $user->email_verified_at }}</p>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    {!! html()->label('Password:', 'password') !!}
                    <p>{{ $user->password }}</p>
                </div>

                <!-- Remember Token Field -->
                <div class="form-group">
                    {!! html()->label('Remember Token:', 'remember_token') !!}
                    <p>{{ $user->remember_token }}</p>
                </div>

                <!-- Roles Field -->
                <div class="form-group">
                    <strong>Roles:</strong>
                    @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                    @endif
                </div>

                <!-- Tenants -->
                <div class="form-group">
                    <strong>Inquilinos:</strong>
                    @if(!empty($user->getTenantsNames()))
                    @foreach($user->getTenantsNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                    @endif
                </div>

                <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
