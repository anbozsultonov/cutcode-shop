<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('tytle', env('APP_NAME'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/main.sass'])
</head>
<body class="antialiased">
    @include('sheared.flash')

    @include('sheared.header')

    <main class="py-16 lg:py-20">
        <div class="container">
            @yield('content')
        </div>
    </main>

    @include('sheared.footer')
</body>
</html>
