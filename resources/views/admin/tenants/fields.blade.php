<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-6">
                {!! html()->label('Nome / Nome Fantasia', 'name') !!}
                {!! html()->text('name', null)->class('form-control') !!}
            </div>

            <div class="form-group col-md-6">
                {!! html()->label('Razão Social:', 'company') !!}
                {!! html()->text('company', null)->class('form-control') !!}
            </div>

            <div class="form-group col-md-6">
                {!! html()->label('E-mail:', 'email') !!}
                {!! html()->email('email', null)->class('form-control') !!}
            </div>

            <div class="form-group col-md-6">
                {!! html()->label('Telefone:', 'phone') !!}
                {!! html()->text('phone', null)->class('form-control') !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                {!! html()->label('CPF / CNPJ:', 'cpf_cnpj') !!}
                {!! html()->text('cpf_cnpj', null)->class('form-control') !!}
            </div>

            <div class="form-group col-md-4">
                {!! html()->label('Inscrição Estadual:', 'ie') !!}
                {!! html()->text('ie', null)->class('form-control') !!}
            </div>
        </div>

        <hr>

        <fieldset>
            <legend>Endereço</legend>

            <div class="row">
                <div class="form-group col-md-6">
                    {!! html()->label('Logradouro:', 'address[street]') !!}
                    {!! html()->text('address[street]', null)->class('form-control') !!}
                </div>

                <div class="form-group col-md-2">
                    {!! html()->label('Número:', 'address[number]') !!}
                    {!! html()->text('address[number]', null)->class('form-control') !!}
                </div>

                <div class="form-group col-md-4">
                    {!! html()->label('Bairro:', 'address[neighborhood]') !!}
                    {!! html()->text('address[neighborhood]', null)->class('form-control') !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    {!! html()->label('Complemento:', 'address[complement]') !!}
                    {!! html()->text('address[complement]', null)->class('form-control') !!}
                </div>

                <div class="form-group col-md-4">
                    {!! html()->label('Telefone (Opcional):', 'address[phone]') !!}
                    {!! html()->text('address[phone]', null)->class('form-control') !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    {!! html()->label('CEP:', 'address[postcode]') !!}
                    {!! html()->text('address[postcode]', null)->class('form-control') !!}
                </div>

                <div class="form-group col-md-4">
                    {!! html()->label('Estado:', 'address[state]') !!}
                    {!! html()->text('address[state]', null)->class('form-control') !!}
                </div>

                <div class="form-group col-md-4">
                    {!! html()->label('Cidade:', 'address[city]') !!}
                    {!! html()->text('address[city]', null)->class('form-control') !!}
                </div>
            </div>
        </fieldset>

        <div class="row">
            <div class="form-group col-sm-12">
                {!! html()->submit('Salvar')->class('btn btn-primary') !!}
                <a href="{{ route('products.index') }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </div>
</div>
