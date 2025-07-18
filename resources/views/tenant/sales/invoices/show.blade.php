@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Faturas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                        <li class="breadcrumb-item">Faturas</li>
                        <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item active">#{{$invoice->id}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-globe"></i> {{$inventorySource->company}}.
                        <small class="float-right">
                            Data: {{$invoice->created_at->formatLocalized('%d de %B de %Y')}}
                        </small>
                    </h4>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <h5>Depósito</h5>
                    <address>
                        {{$inventorySource->address1}}<br>
                        {{$inventorySource->address2}}<br>
                        {{$inventorySource->city}}, {{$inventorySource->state}} - {{$inventorySource->postcode}}<br>
                        Telefone: {{$inventorySource->phone}}<br>
                        Email: {{$inventorySource->email}}
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <h5>Cliente</h5>
                    <address>
                        <strong>{{$invoice->customer_name}}</strong><br>
                        {{$invoice->order->shippingAddress->address1}}<br>
                        {{$invoice->order->shippingAddress->city}},
                        {{$invoice->order->shippingAddress->state}} -
                        {{$invoice->order->shippingAddress->postcode}}<br>
                        Telefone: {{$invoice->order->shippingAddress->phone}}<br>
                        E-mail: {{$invoice->order->shippingAddress->email}}
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <h2>Pedido #{{$invoice->id}}</h2><br>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Qtd.</th>
                            <th>Produto</th>
                            <th>SKU</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($invoice->order->items as $item)
                            <tr>
                                <td>{{ $item->qty_invoiceed  }}</td>
                                <td>{{ $item->name  }}</td>
                                <td>{{ $item->sku  }}</td>
                                <td>@money($item->total)</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <p class="lead">Metodos de pagamento:</p>

                    @foreach ($invoice->order->payments as $item)
                        <span>{{$item->method}}</span>
                    @endforeach
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>@money($item->sub_total)</td>
                            </tr>
                            <tr>
                                <th>Impostos</th>
                                <td>@money($item->tax_amount)</td>
                            </tr>
                            <tr>
                                <th>Frete:</th>
                                <td>@money($item->shipping_amount)</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>@money($item->grand_total)</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-6">
                    <button onclick="window.print()" class="btn btn-default">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-money-check"></i>
                        Gerar fatura
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-trash"></i>
                        Cancelar pedido
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
