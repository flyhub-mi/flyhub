@extends('tenant.layout')

@section('content')
<section class="content-header">
    <h1>
        Attribute
    </h1>
</section>
<section class="content">
    <div class="card card-primary">
        <div class="card-body">
            <div class="row" style="padding-left: 20px">
                <!-- Code Field -->
                <div class="form-group">
                    {!! html()->label('Code:', 'code') !!}
                    <p>{{ $attribute->code }}</p>
                </div>

                <!-- Admin Name Field -->
                <div class="form-group">
                    {!! html()->label('Admin Name:', 'admin_name') !!}
                    <p>{{ $attribute->admin_name }}</p>
                </div>

                <!-- Type Field -->
                <div class="form-group">
                    {!! html()->label('Type:', 'type') !!}
                    <p>{{ $attribute->type }}</p>
                </div>

                <!-- Validation Field -->
                <div class="form-group">
                    {!! html()->label('Validation:', 'validation') !!}
                    <p>{{ $attribute->validation }}</p>
                </div>

                <!-- Position Field -->
                <div class="form-group">
                    {!! html()->label('Position:', 'position') !!}
                    <p>{{ $attribute->position }}</p>
                </div>

                <!-- Is Required Field -->
                <div class="form-group">
                    {!! html()->label('Is Required:', 'is_required') !!}
                    <p>{{ $attribute->is_required }}</p>
                </div>

                <!-- Is Unique Field -->
                <div class="form-group">
                    {!! html()->label('Is Unique:', 'is_unique') !!}
                    <p>{{ $attribute->is_unique }}</p>
                </div>

                <!-- Value Per Channel Field -->
                <div class="form-group">
                    {!! html()->label('Value Per Channel:', 'value_per_channel') !!}
                    <p>{{ $attribute->value_per_channel }}</p>
                </div>

                <!-- Is Filterable Field -->
                <div class="form-group">
                    {!! html()->label('Is Filterable:', 'is_filterable') !!}
                    <p>{{ $attribute->is_filterable }}</p>
                </div>

                <!-- Is Configurable Field -->
                <div class="form-group">
                    {!! html()->label('Is Configurable:', 'is_configurable') !!}
                    <p>{{ $attribute->is_configurable }}</p>
                </div>

                <!-- Is User Defined Field -->
                <div class="form-group">
                    {!! html()->label('Is User Defined:', 'is_user_defined') !!}
                    <p>{{ $attribute->is_user_defined }}</p>
                </div>

                <!-- Is Visible On Front Field -->
                <div class="form-group">
                    {!! html()->label('Is Visible On Front:', 'is_visible_on_front') !!}
                    <p>{{ $attribute->is_visible_on_front }}</p>
                </div>

                <!-- Use In Flat Field -->
                <div class="form-group">
                    {!! html()->label('Use In Flat:', 'use_in_flat') !!}
                    <p>{{ $attribute->use_in_flat }}</p>
                </div>

                <!-- Swatch Type Field -->
                <div class="form-group">
                    {!! html()->label('Swatch Type:', 'swatch_type') !!}
                    <p>{{ $attribute->swatch_type }}</p>
                </div>


                <a href="{{ route('attributes.index') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</section>
@endsection
