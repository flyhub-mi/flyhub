@extends('tenant.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Clientes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">{{$customer->id}} - {{$customer->name}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @include('flash::message')
        <div class="card card-primary">

            <div class="card-body">
                <div class="row row-cols-auto" style="padding-left: 20px">
                    <!-- Channel Id Field -->

                    <div class="form-group col-xs-12 col-md-3 col-2">
                        {!! html()->label('ID:', 'id') !!}
                        <p>{{ $customer->id }}</p>
                    </div>

                    <!-- First Name Field -->
                    <div class="form-group col-xs-12 col-md-3 col-2">
                        {!! html()->label('Name:', 'name') !!}
                        <p>{{ $customer->name }}</p>
                    </div>

                    <!-- Gender Field -->
                    <div class="form-group col-xs-12 col-md-3 col-2">
                        {!! html()->label('Gender:', 'gender') !!}
                        <p>{{ $customer->gender }}</p>
                    </div>

                    <!-- Date Of Birth Field -->
                    <div class="form-group col-xs-12 col-md-3 col-2">
                        {!! html()->label('Ano de Nascimento:', 'birthdate') !!}
                        <p>{{ $customer->birthdate }}</p>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group col-xs-12 col-md-3 col-2">
                        {!! html()->label('Email:', 'email') !!}
                        <p>{{ $customer->email }}</p>
                    </div>

                    <!-- Status Field -->
                    <div class="form-group col-xs-12 col-md-3 col-2">
                        {!! html()->label('Status:', 'status') !!}
                        <p>{{ $customer->status }}</p>
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group col-xs-12 col-md-3 col-2">
                        {!! html()->label('Phone:', 'phone') !!}
                        <p>{{ $customer->phone }}</p>
                    </div>



                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @include('flash::message')

        <div class="card card-primary">

            <div class="card">
                <div class="card-header" >

                    <h3>Pedidos realizados</h3>

                </div>
            </div>
            <div class="card-body">
                <table class="table">
                <thead >
                    <tr>
                      <th scope="col">Cod:</th>
                      <th scope="col">Valor</th>
                      <th scope="col">Data pedido</th>
                      <th scope="col">Canal</th>
                    </tr>
                  </thead>



                        <tbody class="thead-light">
                            @foreach ($customer->orders as $order)
                        <tr>

                            <td>{{ $order->id }}</td>
                            <td>{{ $order->grand_total}}</td>
                            <td>{{ $order->created_at }}</td>
                            <td> {{ $order->channel_name }} </td>
                            <td style="max-width: 80px">
                               <button type="button" class="btn btn-link">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-default">Detalhes</a>
                            </button>
                            </td>

                        </tr>
                           @endforeach
                        </tbody>
                    </table>







            </div>
        </div>
    </div>
</section>
@endsection
