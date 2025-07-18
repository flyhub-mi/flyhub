<!-- Name Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! html()->label('Name:', 'name') !!}
    {!! html()->textarea('name', null)->class('form-control') !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Slug:', 'slug') !!}
    {!! html()->text('slug', null)->class('form-control') !!}
</div>

<!-- Position Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Position:', 'position') !!}
    {!! html()->number('position', null)->class('form-control') !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Image:', 'image') !!}
    {!! html()->text('image', null)->class('form-control') !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Status:', 'status') !!}
    <label class="checkbox-inline">
        {!! html()->hidden('status', 0) !!}
        {!! html()->checkbox('status', '1', null) !!}
    </label>
</div>


<!--  Lft Field -->
<div class="form-group col-sm-6">
    {!! html()->label(' Lft:', '_lft') !!}
    {!! html()->number('_lft', null)->class('form-control') !!}
</div>

<!--  Rgt Field -->
<div class="form-group col-sm-6">
    {!! html()->label(' Rgt:', '_rgt') !!}
    {!! html()->number('_rgt', null)->class('form-control') !!}
</div>

<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Parent Id:', 'parent_id') !!}
    {!! html()->number('parent_id', null)->class('form-control') !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! html()->label('Description:', 'description') !!}
    {!! html()->textarea('description', null)->class('form-control') !!}
</div>

<!-- Meta Title Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! html()->label('Meta Title:', 'meta_title') !!}
    {!! html()->textarea('meta_title', null)->class('form-control') !!}
</div>

<!-- Meta Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! html()->label('Meta Description:', 'meta_description') !!}
    {!! html()->textarea('meta_description', null)->class('form-control') !!}
</div>

<!-- Meta Keywords Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! html()->label('Meta Keywords:', 'meta_keywords') !!}
    {!! html()->textarea('meta_keywords', null)->class('form-control') !!}
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! html()->label('Category Id:', 'category_id') !!}
    {!! html()->number('category_id', null)->class('form-control') !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! html()->submit('Salvar')->class('btn btn-primary') !!}
    <a href="{{ route('categories.index') }}" class="btn btn-default">Cancelar</a>
</div>
