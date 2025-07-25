@extends('layouts.app')

@section('auth')

    @if(\Request::is('static-sign-up'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')

    @elseif (\Request::is('static-sign-in'))
        @include('layouts.navbars.guest.nav')
            @yield('content')
        @include('layouts.footers.guest.footer')

    @else
        @if (\Request::is('profile'))
            @livewire('sidebar')
            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
                @livewire('nav')
                @yield('content')
            </div>
        @else
            @livewire('sidebar')
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
                @livewire('nav')
                <div class="container-fluid py-4">
                    @yield('content')
                    @livewire('footer')
                </div>
            </main>
        @endif

        @include('components.fixed-plugin')
    @endif

@endsection
