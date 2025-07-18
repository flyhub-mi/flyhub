<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-4">
                        {!! html()->label('Nome:', 'name') !!}
                        {!! html()->text('name', null)->class('form-control') !!}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                {!! html()->submit('Salvar')->class('btn btn-primary') !!}
                <a href="{{ route('attribute-sets.index') }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </div>
</div>
