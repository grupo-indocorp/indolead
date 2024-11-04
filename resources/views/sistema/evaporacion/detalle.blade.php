<x-sistema.modal title="Detalle" dialog_id="dialog">
    <p>SERVICIOS GENERALES LUJULY S.A.C.</p>
    <p>20600899709</p>
    <p>Yosip Ibrahim Vizarreta Sandoval</p>

    <section>
        <p>CUENTA FINANCIERA: 748579976</p>
        <table>
            <tr>
                <td>F. de Evaluación:</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Descuento:</td>
                <td>%50</td>
                <td>6 Meses</td>
                <td>11/09/24</td>
            </tr>
            <tr>
                <td>Estado:</td>
                <td>Pendiente</td>
                <td>Ciclo:</td>
                <td>15</td>
            </tr>
        </table>
    </section>

    <section>
        <p>Factura 1</p>
        <table>
            <tr>
                <td>F. Emisión:</td>
                <td>15/08/24</td>
                <td>F. Venc.:</td>
                <td>01/09/24</td>
            </tr>
            <tr>
                <td>Monto:</td>
                <td>S/ 41.71</td>
                <td>Deuda:</td>
                <td>S/ 27.04</td>
            </tr>
            <tr>
                <td>Estado:</td>
                <td>Pendiente</td>
            </tr>
        </table>
    </section>

    <section>
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
            </x-slot>
            <x-slot:tfoot></x-slot>
        </x-ui.table>
    </section>
</x-sistema.modal>
<script>
</script>
