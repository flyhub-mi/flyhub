@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pedido #{{ $order->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
                        <li class="breadcrumb-item">Vendas</li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item active">Visualizando</li>
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
                        <i class="fas fa-globe"></i> nome da empresa
                        <small class="float-right">
                            Data: {{ $order->created_at->formatLocalized('%d de %B de %Y') }}
                        </small>
                    </h4>
                </div>
            </div>
            <div class="row invoice-info">
                @if (!empty($inventorySource->address))
                    <div class="col-sm-4 invoice-col">
                        <h5>Depósito</h5>
                        <address>
                            Endereço: {{ $inventorySource->address->street }}<br>
                            Complemento:{{ $inventorySource->address->complement ?? ' Não informado' }}<br>
                            {{ $inventorySource->address->city }}, {{ $inventorySource->address->state }} -
                            {{ $inventorySource->address->postcode }}<br>
                            Telefone: {{ $inventorySource->phone }}<br>
                            Email: {{ $inventorySource->email }}
                        </address>
                    </div>
                @endif
                <div class="col-sm-4 invoice-col">
                    <h5>Cliente</h5>
                    <strong>{{ $order->customer_name }}</strong><br>
                    @if (!empty($order->billingAddress))
                        <address>
                            Endereço:{{ $order->billingAddress->street }}<br>
                            Complemento:{{ $order->billingAddress->complement ?? ' Não informado' }}<br>
                            {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }} -
                            {{ $order->billingAddress->postcode }}<br>
                        </address>
                    @endif
                    Telefone: {{ $order->customer_phone ?? 'Não informado' }}<br>
                    E-mail: {{ $order->customer_email ?? 'Não informado' }}
                </div>

                <div class="col-sm-4 invoice-col">
                    <h2>Pedido #{{ $order->id }}</h2><br>
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
                                <th>Preço Un.</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->qty_ordered }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>@money($item->price)</td>
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

                    @foreach ($order->payments as $item)
                        <span>{{ $item->method }}</span>
                    @endforeach
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>@money($order->sub_total)</td>
                            </tr>
                            <tr>
                                <th>Impostos</th>
                                <td>@money($order->tax_amount)</td>
                            </tr>
                            <tr>
                                <th>Descontos</th>
                                <td>@money($order->discount_amount)</td>
                            </tr>
                            <tr>
                                <th>Shipping:</th>
                                <td>@money($order->shipping_amount)</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>@money($order->grand_total)</td>
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
                    @if ($invoice)
                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-success">
                            <i class="fas fa-money-check"></i>
                            Visualizar fatura
                        </a>
                    @else
                        <button type="button" class="btn btn-success" onclick="generateInvoice()">
                            <i class="fas fa-money-check"></i>
                            Gerar fatura
                        </button>
                    @endif
                    @unless($invoice)
                        <button type="button" class="btn btn-danger" onclick="cancelOrder()">
                            <i class="fas fa-trash"></i>
                            Cancelar pedido
                        </button>
                    @endunless
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function generateInvoice() {
            Swal.fire({
                title: 'Gerar fatura?',
                text: 'Deseja gerar a fatura deste pedido?',
                icon: 'question',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.value) {
                    new API('/api/v1/invoices').create({
                        order_id: '{{ $order->id }}'
                    }).then((result) => {
                        redirect(`/sales/invoices/${result.data.id}`)
                    });
                }
            })
        }

        function cancelOrder() {
            Swal.fire({
                title: 'Cancelar pedido?',
                text: 'Deseja cancelar este pedido?',
                icon: 'warning',
                focusConfirm: false,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.value) {
                    new API('/api/v1/orders').delete('{{ $order->id }}').then(() => location.reload());
                }
            })
        }
    </script>
@endsection
