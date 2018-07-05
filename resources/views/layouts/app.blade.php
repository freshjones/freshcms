<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') | {{ config('settings.company', 'Fresh CMS') }}@else{{ config('settings.company', 'Fresh CMS') }}@endif</title>

    <meta name="description" content="@hasSection('meta_description')@yield('meta_description')@else{{ config('settings.meta_description', '') }}@endif" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @auth
    <script src="{{ asset('js/admin.js') }}" defer></script>
    @endauth
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @auth
            @include('admin.nav')
        @endauth
        @yield('body')
        {{-- <Settings ref="settings"></Settings> --}}
    </div>
</body>
</html>
