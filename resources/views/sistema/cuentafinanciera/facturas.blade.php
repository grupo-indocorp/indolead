<x-sistema.card>
    <p>Factura 1</p>
    <table>
        <tr>
            <td>F. Emisión:</td>
            <td>{{ $facturasEvaporacion->fecha_emision1 }}</td>
            <td>F. Venc.:</td>
            <td>{{ $facturasEvaporacion->fecha_vencimiento1 }}</td>
        </tr>
        <tr>
            <td>Monto:</td>
            <td>{{ $facturasEvaporacion->monto_facturado1 }}</td>
            <td>Deuda:</td>
            <td>{{ $facturasEvaporacion->deuda1 }}</td>
        </tr>
        <tr>
            <td>Estado:</td>
            <td>{{ $facturasEvaporacion->estado_facturacion1 }}</td>
        </tr>
    </table>
</x-sistema.card>
<x-sistema.card>
    <p>Factura 2</p>
    <table>
        <tr>
            <td>F. Emisión:</td>
            <td>{{ $facturasEvaporacion->fecha_emision2 }}</td>
            <td>F. Venc.:</td>
            <td>{{ $facturasEvaporacion->fecha_vencimiento2 }}</td>
        </tr>
        <tr>
            <td>Monto:</td>
            <td>{{ $facturasEvaporacion->monto_facturado2 }}</td>
            <td>Deuda:</td>
            <td>{{ $facturasEvaporacion->deuda2 }}</td>
        </tr>
        <tr>
            <td>Estado:</td>
            <td>{{ $facturasEvaporacion->estado_facturacion2 }}</td>
        </tr>
    </table>
</x-sistema.card>
<x-sistema.card>
    <p>Factura 3</p>
    <table>
        <tr>
            <td>F. Emisión:</td>
            <td>{{ $facturasEvaporacion->fecha_emision3 }}</td>
            <td>F. Venc.:</td>
            <td>{{ $facturasEvaporacion->fecha_vencimiento3 }}</td>
        </tr>
        <tr>
            <td>Monto:</td>
            <td>{{ $facturasEvaporacion->monto_facturado3 }}</td>
            <td>Deuda:</td>
            <td>{{ $facturasEvaporacion->deuda3 }}</td>
        </tr>
        <tr>
            <td>Estado:</td>
            <td>{{ $facturasEvaporacion->estado_facturacion3 }}</td>
        </tr>
    </table>
</x-sistema.card>