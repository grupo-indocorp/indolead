<x-ui.table id="evaporacion">
    <x-slot:thead>
        <tr>
            <th>{{ __('NUMERO') }}</th>
            <th>{{ __('ORDEN') }}</th>
            <th>{{ __('PRODUCTO') }}</th>
            <th>{{ __('CARGO FIJO') }}</th>
            <th>{{ __('DESCUENTO') }}</th>
            <th>{{ __('VIGENCIA DEL DESCUENTO') }}</th>
            <th>{{ __('FECHA DE SOLICITUD') }}</th>
            <th>{{ __('FECHA DE ACTIVACION') }}</th>
            <th>{{ __('PERIODO') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th></th>
        </tr>
    </x-slot>
    <x-slot:tbody>
        @foreach ($productosEvaporacion as $item)
            <tr>
                <td>{{ $item->numero_servicio }}</td>
                <td>{{ $item->orden_pedido }}</td>
                <td>{{ $item->producto }}</td>
                <td>{{ $item->cargo_fijo }}</td>
                <td>{{ $item->descuento }}</td>
                <td>{{ $item->descuento_vigencia }}</td>
                <td>{{ $item->fecha_solicitud }}</td>
                <td>{{ $item->fecha_activacion }}</td>
                <td>{{ $item->periodo_servicio }}</td>
                <td class="flex flex-col">
                    <b>{{ $item->fecha_estado_linea }}</b>
                    <span>{{ $item->estado_linea }}</span>
                </td>
                <td></td>
            </tr>
        @endforeach
    </x-slot>
    <x-slot:tfoot></x-slot>
</x-ui.table>