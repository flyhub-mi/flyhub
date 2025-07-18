<div class="row">
    <div class="form-group col-sm-6">
        {!! html()->label('Nome:', 'name') !!}
        {!! html()->text('name', null)->class('form-control') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! html()->label('Email:', 'email') !!}
        {!! html()->email('email', null)->class('form-control') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! html()->label('Senha:', 'password') !!}
        {!! html()->password('password')->class('form-control') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! html()->label('Confirmação de Senha:', 'password_confirmation') !!}
        {!! html()->password('password_confirmation')->class('form-control') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! html()->label('Acesso:', 'roles') !!}
        {!! html()->select('roles[]', $roles, null, array('class' => 'form-control','multiple')) !!}
    </div>

    <div class="form-group col-sm-12">
        {!! html()->submit('Salvar')->class('btn btn-primary') !!}
        <a href="{{ route('users.index') }}" class="btn btn-default">Cancelar</a>
    </div>
</div>
