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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </x-slot>
    <x-slot:tfoot></x-slot>
</x-ui.table>