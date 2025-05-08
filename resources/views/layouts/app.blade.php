<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
    <title>@yield('title')</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="bg-light">
    @include('layouts.alert')
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @stack('scripts')
    @livewireScripts
  </body>
</html>