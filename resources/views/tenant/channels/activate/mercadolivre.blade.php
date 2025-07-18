<?php
$channel = \App\Models\Tenant\Channel::firstOrCreate(['code' => 'MercadoLivre'], ['name' => 'Mercado Livre']);
$auth = new App\Integration\Channels\MercadoLivre\Auth($channel);
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="card card-default">
            <div class="card-body text-center">
                <img src="{{ asset('images/channels/mercado-livre.png')  }}" class="img-fluid" alt="Mercado Livre" style="max-height: 150px;">
                <p>
                    Integração entre Mercado Livre e FlyHub.
                </p>
            </div>
            <div class="card-footer text-right">
                <a href="{{$auth->oAuthUrl()}}" class="btn btn-primary" target="_blank">Conectar</a>
            </div>
        </div>
    </div>
</div>
