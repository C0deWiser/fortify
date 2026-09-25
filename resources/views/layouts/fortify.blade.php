<html lang="{{ config('app.locale') }}">
<head>
    <title>{{ config('app.name') }} / @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/vendor/fortify/style.css"/>
</head>
<body>

<x-fortify-nav/>

<main>
    @yield('content')
</main>

@stack('scripts')

</body>
</html>