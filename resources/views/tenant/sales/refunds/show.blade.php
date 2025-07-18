@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <h1>
            Refund
        </h1>
    </section>
    <div class="content">
        <div class="card card-primary">
            <div class="card-body">
                <div class="row" style="padding-left: 20px">
                    @include('tenant.sales.refunds.show_fields')
                    <a href="{{ route('refunds.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
