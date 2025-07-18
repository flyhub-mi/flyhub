@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Painel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">App</a></li>
                        <li class="breadcrumb-item active">Painel</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 col-lg-3">
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{$ordersCount}}</h3>
                            <p>Novos Pedidos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('orders.index') }}" class="small-box-footer">
                            Mais detalhes <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{$shipmentsCount}}</h3>
                            <p>Envios</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="{{ route('shipments.index') }}" class="small-box-footer">
                            Mais detalhes <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{$productsCount}}</h3>
                            <p>Produtos ativos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <a href="{{ route('products.index') }}" class="small-box-footer">
                            Mais detalhes <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>R$ {{number_format($monthSalesSum,2,",",".")}}</h3>
                            <p>Faturamento mensal</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-check"></i>
                        </div>
                        <a href="{{ route('invoices.index') }}" class="small-box-footer">
                            Mais detalhes <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Faturamento diário</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="dailyBilling" style="min-width: 100%; display: block;" height="250" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        new Chart(document.getElementById('dailyBilling').getContext('2d'), {
            type: 'line',
            data: {
                labels: [{{implode(', ', $daysOfCurrentMonth)}}],
                datasets: [{ data: [{{implode(', ', $salesByDayOfCurrentMonth)}}] }],
            },
            options: {
                title: { display: false },
                legend: { display: false },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                    }],
                },
            },
        });
    </script>
@endsection


