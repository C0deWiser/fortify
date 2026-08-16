<html>
<head>
    <title>{{ config('app.name') }} / @yield('title')</title>

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