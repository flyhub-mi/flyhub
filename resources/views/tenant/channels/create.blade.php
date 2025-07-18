@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Canais</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Configurações</li>
                        <li class="breadcrumb-item active">Canais</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @include('flash::message')
            @include('tenant.partials.errors')

            {!! html()->form('POST', route('channels.store'))->open() !!}

            @if ($channel === 'MercadoLivre')
                @include('tenant.channels.activate.' . strtolower($channel))
            @else
                @include('tenant.channels.activate')
            @endif

            {!! html()->form()->close() !!}
        </div>
    </section>
@endsection
