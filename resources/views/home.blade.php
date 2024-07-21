<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="INDOTECH es una empresa líder en asesoría y gestión comercial en el campo de las telecomunicaciones. Ofrecemos soluciones integrales en telefonía fija, móvil, internet avanzado, fibra óptica y estrategias de ventas. ¡Contáctanos hoy mismo!">
    <meta name="robots" content="index,follow">
    <meta name="author" content="INDOTECH S.A.C.">
    <title>{{ config('app.name', 'Indotech') }}</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">
    {{-- header --}}
    <x-web.header />

    {{-- main --}}
    <x-web.main />

    {{-- footer --}}
    <x-web.footer />
</body>
</html>