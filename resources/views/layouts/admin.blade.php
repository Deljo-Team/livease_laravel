<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />


    <!-- Scripts -->
    @vite([
        'resources/sass/app.scss',
         'resources/js/app.js',
        ])
</head>
<body>
    <div id="app">
        @include('admin.partials.sidebar')
        {{-- @include('admin.header') --}}

        <main class="main-content py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
