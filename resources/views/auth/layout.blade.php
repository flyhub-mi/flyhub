<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ mix('js/auth.js') }}" defer></script>
    <link href="{{ mix('css/auth.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row no-gutter">
                <div class="col-md-6 d-none d-md-flex bg-image"></div>

                <div class="col-md-6 bg-light">
                    <div class="login d-flex align-items-center py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-10 col-xl-7 mx-auto">
                                    <h3 class="display-4">{{ config('app.name', 'FlyHub') }}</h3>
                                    <p class="text-muted mb-4">Integração de MarketPlaces.</p>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                @yield('title')
                                            </h5>

                                            @yield('content')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
