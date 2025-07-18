<div class="row justify-content-center">
    <div class="col-12 col-md-9">
        <div class="card card-default">
            <div class="card-header text-center">
                <img src="{{ asset('images/channels/' . strtolower($channel) . '.png') }}" class="img-fluid"
                    alt="{{ $channel }}" style="max-height: 150px;">
                <p>Integração entre {{ $channel }} e FlyHub.</p>
            </div>

            <div class="card-body text-center">
                {!! html()->hidden('code', $channel) !!}
                {!! html()->hidden('name', $channel) !!}

                @foreach ($configFields as $field)
                    <div class="form-group col-sm-12">
                        {!! html()->label($field['label'], 'configs[' . $field['name'] . ']') !!}
                        @if ($field['type'] === 'text' || $field['type'] === 'password')
                            {!! html()->text('configs[' . $field['name'] . ']', null)->class('form-control') !!}
                        @endif

                        @if ($field['type'] === 'checkbox')
                            {!! html()->checkbox('configs[' . $field['name'] . ']', null)->class('form-control') !!}
                        @endif

                        @if ($field['type'] === 'select')
                            {!! html()->select('configs[' . $field['name'] . ']', $field['options'], null)->class('form-control') !!}
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="card-footer text-right">
                <div class="form-group col-sm-12">
                    {!! html()->submit('Ativar')->class('btn btn-primary') !!}
                    <a href="{{ route('channels.index') }}" class="btn btn-default">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>
