<table>
    <tr>
        <td class="font-bold">F. de Evaluación:</td>
        <td colspan="3">{{ $cuentafinanciera->fecha_evaluacion ?? '--/--/--' }}</td>
    </tr>
    <tr>
        <td class="font-bold">Descuento:</td>
        <td>{{ $cuentafinanciera->descuento }}</td>
        <td>{{ $cuentafinanciera->descuento_vigencia }}</td>
        <td>{{ $cuentafinanciera->fecha_descuento ?? '--/--/--' }}</td>
    </tr>
    <tr>
        <td class="font-bold">Estado:</td>
        <td>{{ $cuentafinanciera->estado_evaluacion ?? '-----' }}</td>
        <td class="font-bold">Ciclo:</td>
        <td>{{ $cuentafinanciera->ciclo}}</td>
    </tr>
</table>