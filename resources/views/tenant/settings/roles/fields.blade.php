<div class="row">
    <div class="form-group col-sm-12 col-lg-12">
        {!! html()->label('Name:', 'name') !!}
        {!! html()->text('name', null)->class('form-control') !!}
    </div>
</div>

<fieldset>
    <legend>Permisões:</legend>

    <div class="row">
        @foreach($permission as $value)
            <div class="form-group col-sm-3">
                <label>
                    {{ html()->checkbox('permission[]', in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                    {{ $value->name }}
                </label>
            </div>
        @endforeach
    </div>
</fieldset>

<div class="row">
    <div class="form-group col-sm-12">
        {!! html()->submit('Salvar')->class('btn btn-primary') !!}
        <a href="{{ route('roles.index') }}" class="btn btn-default">Cancelar</a>
    </div>
</div>
