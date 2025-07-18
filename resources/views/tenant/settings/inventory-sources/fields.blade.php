<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Nome:', 'name') !!}
        {!! html()->text('name', null)->class('form-control') !!}
    </div>

    <!-- Contact Name Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Nome de contato:', 'contact_name') !!}
        {!! html()->text('contact_name', null)->class('form-control') !!}
    </div>

    <!-- Contact Email Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('E-mail de contato :', 'contact_email') !!}
        {!! html()->text('contact_email', null)->class('form-control') !!}
    </div>

    <!-- Contact Number Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Telefone de Contato:', 'contact_number') !!}
        {!! html()->text('contact_number', null)->class('form-control') !!}
    </div>

    <!-- Contact Fax Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Fax do Contato:', 'contact_fax') !!}
        {!! html()->text('contact_fax', null)->class('form-control') !!}
    </div>

    <!-- State Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Estado:', 'state') !!}
        {!! html()->text('state', null)->class('form-control') !!}
    </div>

    <!-- City Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Cidade:', 'city') !!}
        {!! html()->text('city', null)->class('form-control') !!}
    </div>

    <!-- Street Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Logradouro:', 'street') !!}
        {!! html()->text('street', null)->class('form-control') !!}
    </div>

    <!-- Postcode Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('CEP:', 'postcode') !!}
        {!! html()->text('postcode', null)->class('form-control') !!}
    </div>

    <!-- Priority Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Prioridade:', 'priority') !!}
        {!! html()->number('priority', null)->class('form-control') !!}
    </div>

    <!-- Latitude Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Latitude:', 'latitude') !!}
        {!! html()->number('latitude', null)->class('form-control') !!}
    </div>

    <!-- Longitude Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Longitude:', 'longitude') !!}
        {!! html()->number('longitude', null)->class('form-control') !!}
    </div>

    <!-- Status Field -->
    <div class="form-group col-sm-6">
        {!! html()->label('Status:', 'status') !!}
        <label class="checkbox-inline">
            {!! html()->hidden('status', 0) !!}
            {!! html()->checkbox('status', '1', null) !!}
        </label>
    </div>

    <!-- Description Field -->
    <div class="form-group col-sm-12">
        {!! html()->label('Descrição', 'description') !!}
        {!! html()->textarea('description', null)->class('form-control')->attribute('rows', '2') !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! html()->submit('Salvar')->class('btn btn-primary') !!}
        <a href="{{ route('inventory-sources.index') }}" class="btn btn-default">Cancelar</a>
    </div>
</div>