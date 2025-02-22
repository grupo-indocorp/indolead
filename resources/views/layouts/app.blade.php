@php $sistema = App\Models\Sistema::first(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if (isset($sistema))
            {{ $sistema->nombre }}
        @else
            {{ config('app.name', 'Laravel') }}
        @endif
    </title>
    <link rel="icon"
        @if (isset($sistema)) href="{{ Storage::url($sistema->icono) }}" @else href="{{ asset('img/logo.png') }}" @endif>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://d3vimg.github.io/fontawesone/css/all.min.css">
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="{{ asset('DataTables/datatables.css') }}" rel="stylesheet" />
    <script src="{{ asset('DataTables/datatables.js') }}"></script>
    {{-- Select2 --}}
    <link href="{{ asset('Select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('Select2/dist/js/select2.min.js') }}"></script>

</head>

<body class="flex bg-gray-400">
    @guest
        @yield('guest')
    @endguest

    {{-- Sidebar --}}
    @livewire('sidebar')

    {{-- Contenido --}}
    <div class="flex flex-col h-screen w-full p-2">
        @livewire('nav')
        <main class="flex-initial h-full w-full overflow-y-auto">
            @yield('content')
            @yield('modal')
        </main>
        @livewire('footer')
    </div>

    {{-- Contenerdor nuevo de modal --}}
    <div id="contenedorModal"></div>

    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
            <p class="m-0">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Contenedor de Frases --}}
    {{-- @livewire('frases') --}}

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    @stack('modals')
    @stack('dashboard')

    @livewireScripts

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
    {{-- Funciones globales --}}
    <script src="{{ asset('js/indotech.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    @yield('script')
</body>

</html>
