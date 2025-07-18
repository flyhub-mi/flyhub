@extends('tenant.layout')

@section('content')
<section class="content-header">
    <h1>
        Channel
    </h1>
</section>

<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Integração</h3>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('images/channels/mercado-livre.png')  }}" class="img-fluid" alt="Mercado Livre">
                <h3>Integração entre Mercado Livre e FlyHub.</h3>
                <p>Já salvamos seu Código de integração, agora precisamos gerar uma chave de acesso.</p>
            </div>
            <div class="card-footer text-right">
                <a href="{{$url}}" class="btn btn-primary" target="_blank">Gerar chave de acesso</a>
            </div>
        </div>
    </div>
</div>
@endsection
