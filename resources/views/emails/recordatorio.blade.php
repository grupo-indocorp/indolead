@component('mail::message')
# {{ $titulo }}
{{ $mensaje }}

@component('mail::button', ['url' => url('/notificacion')])
    Ver Agenda
@endcomponent

@endcomponent