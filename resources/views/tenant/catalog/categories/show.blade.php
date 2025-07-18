@extends('tenant.layout')

@section('content')
<section class="content-header">
    <h1>
        Category
    </h1>
</section>
<section class="content">
    <div class="card card-primary">
        <div class="card-body">
            <div class="row" style="padding-left: 20px">
                <!-- Name Field -->
                <div class="form-group">
                    {!! html()->label('Name:', 'name') !!}
                    <p>{{ $category->name }}</p>
                </div>

                <!-- Slug Field -->
                <div class="form-group">
                    {!! html()->label('Slug:', 'slug') !!}
                    <p>{{ $category->slug }}</p>
                </div>

                <!-- Position Field -->
                <div class="form-group">
                    {!! html()->label('Position:', 'position') !!}
                    <p>{{ $category->position }}</p>
                </div>

                <!-- Image Field -->
                <div class="form-group">
                    {!! html()->label('Image:', 'image') !!}
                    <p>{{ $category->image }}</p>
                </div>

                <!-- Status Field -->
                <div class="form-group">
                    {!! html()->label('Status:', 'status') !!}
                    <p>{{ $category->status }}</p>
                </div>

                <!--  Lft Field -->
                <div class="form-group">
                    {!! html()->label(' Lft:', '_lft') !!}
                    <p>{{ $category->_lft }}</p>
                </div>

                <!--  Rgt Field -->
                <div class="form-group">
                    {!! html()->label(' Rgt:', '_rgt') !!}
                    <p>{{ $category->_rgt }}</p>
                </div>

                <!-- Parent Id Field -->
                <div class="form-group">
                    {!! html()->label('Parent Id:', 'parent_id') !!}
                    <p>{{ $category->parent_id }}</p>
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    {!! html()->label('Description:', 'description') !!}
                    <p>{{ $category->description }}</p>
                </div>

                <!-- Meta Title Field -->
                <div class="form-group">
                    {!! html()->label('Meta Title:', 'meta_title') !!}
                    <p>{{ $category->meta_title }}</p>
                </div>

                <!-- Meta Description Field -->
                <div class="form-group">
                    {!! html()->label('Meta Description:', 'meta_description') !!}
                    <p>{{ $category->meta_description }}</p>
                </div>

                <!-- Meta Keywords Field -->
                <div class="form-group">
                    {!! html()->label('Meta Keywords:', 'meta_keywords') !!}
                    <p>{{ $category->meta_keywords }}</p>
                </div>

                <!-- Category Id Field -->
                <div class="form-group">
                    {!! html()->label('Category Id:', 'category_id') !!}
                    <p>{{ $category->category_id }}</p>
                </div>


                <a href="{{ route('categories.index') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</section>
@endsection
