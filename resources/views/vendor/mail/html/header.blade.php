@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
{{-- <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo"> --}}
@else
<img src="https://indotechsac.com/img/logo.png" class="logo" alt="Indotech Logo">
<br>
{{ $slot }}
@endif
</a>
</td>
</tr>
