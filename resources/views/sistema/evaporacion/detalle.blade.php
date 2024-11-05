<x-sistema.modal title="Detalle" dialog_id="dialog">
    <section class="flex flex-col">
        <span>{{ $evaporacion->razon_social }}</span>
        <span>{{ $evaporacion->ruc }}</span>
        <span>{{ $evaporacion->ejecutivo }}</span>
    </section>

    <section class="p-3 rounded-lg bg-slate-300">
        <span>CUENTA FINANCIERA: {{ $evaporacion->cuenta_financiera }}</span>
        <table>
            <tr>
                <td>F. de Evaluación:</td>
                <td colspan="3">{{ $evaporacion->fecha_evaluacion }}</td>
            </tr>
            <tr>
                <td>Descuento:</td>
                <td>{{ $evaporacion->evaluacion_descuento }}</td>
                <td>{{ $evaporacion->evaluacion_descuento_vigencia }}</td>
                <td>{{ $evaporacion->fecha_evaluacion_descuento_vigencia }}</td>
            </tr>
            <tr>
                <td>Estado:</td>
                <td>
                    @if ($evaporacion->estado_facturacion1 != 'pagado')
                        {{ $evaporacion->estado_facturacion1 }}
                    @elseif($evaporacion->estado_facturacion2 != 'pagado')
                        {{ $evaporacion->estado_facturacion2 }}
                    @else
                        {{ $evaporacion->estado_facturacion3 }}
                    @endif
                </td>
                <td>Ciclo:</td>
                <td>{{ $evaporacion->ciclo_factuacion }}</td>
            </tr>
        </table>
    </section>

    @if ($evaporacion->estado_facturacion1 != 'pagado')
        <section class="p-3 rounded-lg bg-slate-300">
            <p>Factura 1</p>
            <table>
                <tr>
                    <td>F. Emisión:</td>
                    <td>{{ $evaporacion->fecha_emision1 }}</td>
                    <td>F. Venc.:</td>
                    <td>{{ $evaporacion->fecha_vencimiento1 }}</td>
                </tr>
                <tr>
                    <td>Monto:</td>
                    <td>{{ $evaporacion->monto_facturado1 }}</td>
                    <td>Deuda:</td>
                    <td>{{ $evaporacion->deuda1 }}</td>
                </tr>
                <tr>
                    <td>Estado:</td>
                    <td>{{ $evaporacion->estado_facturacion1 }}</td>
                </tr>
            </table>
        </section>
    @elseif($evaporacion->estado_facturacion2 != 'pagado')
        <section class="p-3 rounded-lg bg-slate-300">
            <p>Factura 2</p>
            <table>
                <tr>
                    <td>F. Emisión:</td>
                    <td>{{ $evaporacion->fecha_emision2 }}</td>
                    <td>F. Venc.:</td>
                    <td>{{ $evaporacion->fecha_vencimiento2 }}</td>
                </tr>
                <tr>
                    <td>Monto:</td>
                    <td>{{ $evaporacion->monto_facturado2 }}</td>
                    <td>Deuda:</td>
                    <td>{{ $evaporacion->deuda2 }}</td>
                </tr>
                <tr>
                    <td>Estado:</td>
                    <td>{{ $evaporacion->estado_facturacion2 }}</td>
                </tr>
            </table>
        </section>
    @else
        <section class="p-3 rounded-lg bg-slate-300">
            <p>Factura 3</p>
            <table>
                <tr>
                    <td>F. Emisión:</td>
                    <td>{{ $evaporacion->fecha_emision3 }}</td>
                    <td>F. Venc.:</td>
                    <td>{{ $evaporacion->fecha_vencimiento3 }}</td>
                </tr>
                <tr>
                    <td>Monto:</td>
                    <td>{{ $evaporacion->monto_facturado3 }}</td>
                    <td>Deuda:</td>
                    <td>{{ $evaporacion->deuda3 }}</td>
                </tr>
                <tr>
                    <td>Estado:</td>
                    <td>{{ $evaporacion->estado_facturacion3 }}</td>
                </tr>
            </table>
        </section>
    @endif

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
