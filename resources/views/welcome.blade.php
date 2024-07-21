@php $sistema = App\Models\Sistema::first(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@if (isset($sistema)) {{ $sistema->nombre }} @else {{ config('app.name', 'Laravel') }} @endif</title>
    <link rel="icon" @if (isset($sistema)) href="{{ Storage::url($sistema->icono) }}" @else href="{{ asset('img/logo.png') }}" @endif >
    <meta name="description" content="INDOTECH es una empresa líder en asesoría y gestión comercial en el campo de las telecomunicaciones. Ofrecemos soluciones integrales en telefonía fija, móvil, internet avanzado, fibra óptica y estrategias de ventas. ¡Contáctanos hoy mismo!">
    <meta name="robots" content="index,follow">
    <meta name="author" content="INDOTECH S.A.C.">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    @livewire('navigation')
    <div class="relative isolate px-6 lg:px-8">
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-20">
            <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                <div
                    class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                    En Indotech, nos enorgullece ofrecer un enfoque personalizado y orientado al cliente.<a href="/indotech/public/" class="font-semibold text-blue-950">{{-- <span
                            class="absolute inset-0" aria-hidden="true"></span>Leer mas<span
                            aria-hidden="true">&rarr;</span> --}}</a>
                </div>
            </div>
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">INDOTECH ES UNA EMPRESA LÍDER
                    EN EL CAMPO DE LA ASESORÍA Y GESTIÓN COMERCIAL</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">Nos destacamos por ofrecer soluciones integrales en áreas clave en telecomunicaciones, telefonía fija, telefonía móvil, internet avanzado, fibra óptica, asesoria personalizada y estrategias de ventas.</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="#"
                        class="rounded-md bg-blue-950 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Empezar</a>
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Leer mas <span
                            aria-hidden="true"> →</span></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
