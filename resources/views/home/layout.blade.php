<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ mix('css/style.css') }}" rel="stylesheet">
</head>

<body class="font-inter antialiased bg-white text-gray-900 tracking-tight">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>
    <div id="root"></div>
    <script type="module" src="{{ mix('js/main.js') }}"></script>
</body>

</html>
