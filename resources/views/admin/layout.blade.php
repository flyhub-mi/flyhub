<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>FlyHub</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png"') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="FlyHub">
    <meta name="application-name" content="FlyHub">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @include('admin.partials.styles')
    @yield('css')
</head>

<body class="hold-transition sidebar-mini-md sidebar-collapse layout-fixed">
    <div class="wrapper">
        @include('admin.partials.navbar')
        @include('admin.partials.sidebar')

        <div class="content-wrapper px-4 py-2">
            @yield('content')
        </div>

        <footer class="main-footer text-center">
            <img src="{{ asset('images/logo.png') }}" alt="FlyHub" class="brand-image img-sm">
            <strong>FlyHub</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>

    @include('admin.partials.scripts')
    @yield('scripts')

</body>

</html>
