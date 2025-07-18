@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <h1>
            Category
        </h1>
    </section>
    <section class="content">
        @include('tenant.partials.errors')
        <div class="card card-primary">
            <div class="card-body">
                <div class="row">
                    {!! html()->modelForm($category, 'PATCH', route('categories.update', $category->id)) !!}

                    @include('tenant.catalog.categories.fields')

                    {!! html()->form()->close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
