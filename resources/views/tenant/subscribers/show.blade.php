@extends('tenant.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Assinantes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item">Clientes</li>
                    <li class="breadcrumb-item active">Inscritos</li>
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
                <div class="row" style="padding-left: 20px">
                    <!-- Email Field -->
                    <div class="form-group">
                        {!! html()->label('Email:', 'email') !!}
                        <p>{{ $subscriber->email }}</p>
                    </div>

                    <!-- Is Subscribed Field -->
                    <div class="form-group">
                        {!! html()->label('Is Subscribed:', 'is_subscribed') !!}
                        <p>{{ $subscriber->is_subscribed }}</p>
                    </div>

                    <!-- Token Field -->
                    <div class="form-group">
                        {!! html()->label('Token:', 'token') !!}
                        <p>{{ $subscriber->token }}</p>
                    </div>

                    <!-- Channel Id Field -->
                    <div class="form-group">
                        {!! html()->label('Channel Id:', 'channel_id') !!}
                        <p>{{ $subscriber->channel_id }}</p>
                    </div>


                    <a href="{{ route('subscribers.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
