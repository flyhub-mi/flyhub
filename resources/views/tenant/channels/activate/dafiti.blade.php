<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="card card-default">
            <div class="card-body text-center">
                <img src="{{ asset('images/channels/dafiti.png')  }}" class="img-fluid" alt="Dafiti" style="max-height: 150px;">
                <p>
                    Integração Dafiti e FlyHub.
                </p>
            </div>
            <div class="card-body text-center">

                {!! Form::hidden('code', 'Dafiti') !!}
                {!! Form::hidden('name', 'Dafiti') !!}

                <div class="form-group col-sm-12">
                    {!! Form::label('configs[url]', 'Url da api:') !!}
                    {!! Form::text('configs[url]', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::label('configs[api_user]', 'Usuário') !!}
                    {!! Form::text('configs[api_user]', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-sm-12">
                    {!! Form::label('configs[api_key]', 'Chave da API') !!}
                    {!! Form::text('configs[api_key]', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="card-footer text-right">
                <div class="form-group col-sm-12">
                    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                    <a href="{{ route('channels.index') }}" class="btn btn-default">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>
