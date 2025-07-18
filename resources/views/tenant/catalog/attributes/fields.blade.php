<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Code:', 'code') !!}
    {!! html()->text('code', null)->class('form-control') !!}
</div>

<!-- Admin Name Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Admin Name:', 'admin_name') !!}
    {!! html()->text('admin_name', null)->class('form-control') !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Type:', 'type') !!}
    {!! html()->text('type', null)->class('form-control') !!}
</div>

<!-- Validation Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Validation:', 'validation') !!}
    {!! html()->text('validation', null)->class('form-control') !!}
</div>

<!-- Position Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Position:', 'position') !!}
    {!! html()->number('position', null)->class('form-control') !!}
</div>

<!-- Is Required Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Is Required:', 'is_required') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('is_required', 0) !!}
        {!! html()->checkbox('is_required', '1', null) !!}
    </label>
</div>


<!-- Is Unique Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Is Unique:', 'is_unique') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('is_unique', 0) !!}
        {!! html()->checkbox('is_unique', '1', null) !!}
    </label>
</div>


<!-- Value Per Channel Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Value Per Channel:', 'value_per_channel') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('value_per_channel', 0) !!}
        {!! html()->checkbox('value_per_channel', '1', null) !!}
    </label>
</div>


<!-- Is Filterable Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Is Filterable:', 'is_filterable') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('is_filterable', 0) !!}
        {!! html()->checkbox('is_filterable', '1', null) !!}
    </label>
</div>


<!-- Is Configurable Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Is Configurable:', 'is_configurable') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('is_configurable', 0) !!}
        {!! html()->checkbox('is_configurable', '1', null) !!}
    </label>
</div>


<!-- Is User Defined Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Is User Defined:', 'is_user_defined') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('is_user_defined', 0) !!}
        {!! html()->checkbox('is_user_defined', '1', null) !!}
    </label>
</div>


<!-- Is Visible On Front Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Is Visible On Front:', 'is_visible_on_front') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('is_visible_on_front', 0) !!}
        {!! html()->checkbox('is_visible_on_front', '1', null) !!}
    </label>
</div>


<!-- Use In Flat Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Use In Flat:', 'use_in_flat') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('use_in_flat', 0) !!}
        {!! html()->checkbox('use_in_flat', '1', null) !!}
    </label>
</div>


<!-- Swatch Type Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Swatch Type:', 'swatch_type') !!}
    {!! html()->text('swatch_type', null)->class('form-control') !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! html()->submit('Salvar')->class('btn btn-primary') !!}
    <a href="{{ route('attributes.index') }}" class="btn btn-default">Cancelar</a>
</div>
