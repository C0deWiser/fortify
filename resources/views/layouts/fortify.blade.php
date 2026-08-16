<html>
<head>
    <title>{{ config('app.name') }} / @yield('title')</title>

    <link rel="stylesheet" href="/vendor/fortify/style.css"/>
</head>
<body>

<div class="codewiser-fortify">

    <x-fortify-nav/>

<main>
    @yield('content')
</main>
</div>

@stack('scripts')

</body>
</html>