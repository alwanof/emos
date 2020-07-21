<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>{{ config('app.name', 'NULL') }} - @yield('title')</title>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css" href="{{ asset('templates/pwa/styles/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('templates/pwa/styles/style.css') }}">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('templates/pwa/fonts/css/fontawesome-all.min.css') }}">
<link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="icon" href="{{asset('assets/dist/img/log-icon.png')}}" type="image/gif" sizes="16x16">
@yield('css')
</head>

<body class="theme-light" data-background="none" data-highlight="red2">
    <div id="app">
        @yield('content')
    </div>




<script type="text/javascript" src="{{ asset('templates/pwa/scripts/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('templates/pwa/scripts/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('templates/pwa/scripts/custom.js') }}"></script>
<script src="{{ asset('js/app.js') }}" ></script>
@yield('js')
</body>
