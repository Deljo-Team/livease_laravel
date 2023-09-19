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
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" /> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script>
        window.base = {!! json_encode([
            'baseUrl' => url('/'),
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
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
    {{-- @vite('resources/js/admin.js') --}}
</body>
</html>
