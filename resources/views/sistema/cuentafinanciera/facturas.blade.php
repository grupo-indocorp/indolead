<x-sistema.card x-data="{
        editMode: false,
        isSaving: false,
        montoFactura: '{{ $facturasEvaporacion->monto_facturado1 }}',
        deudaFactura: '{{ $facturasEvaporacion->deuda1 }}',
        estadoFactura: '{{ $facturasEvaporacion->estado_facturacion1 }}',
        saveFactura() {
            limpiarError();
            capturarToken();

            this.isSaving = true;
            let self = this;
            $.ajax({
                url: `{{ url('cuentas-financieras/'. $facturasEvaporacion->cuentafinanciera_id) }}`,
                method: 'PUT',
                data: {
                    view: 'update-factura',
                    monto_factura: self.montoFactura,
                    deuda_factura: self.deudaFactura,
                    estado_factura: self.estadoFactura,
                },
                success: function(result) {
                    // Salir del modo edición
                    self.editMode = false;

                    // Actualizar fecha_evaluacion de cuenta financiera
                    cuentafinancieraShow('{{ $facturasEvaporacion->cuentafinanciera_id }}');
                },
                error: function(response) {
                    mostrarError(response);
                    alert('Hubo un error al guardar los cambios');
                },
                complete: function() {
                    self.isSaving = false;
                }
            });
        }
    }">
    <section class="flex justify-between">
        <h5>Factura 1</h5>
        <div>
            <template x-if="!editMode">
                <span class="hover:cursor-pointer hover:text-slate-500"
                    @click="editMode = true">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
            </template>
            <template x-if="editMode">
                <span class="hover:cursor-pointer hover:text-slate-500"
                    @click="if (!isSaving) { saveFactura(); }"
                    :disabled="isSaving">
                    <i class="fa-solid fa-floppy-disk"></i>
                </span>
            </template>
            <template x-if="editMode">
                <span class="hover:cursor-pointer hover:text-slate-500"
                    @click="editMode = false">
                    <i class="fa-solid fa-xmark"></i>
                </span>
            </template>
        </div>
    </section>
    <section>
        <b>Fecha Emisión:</b>
        <span>{{ $facturasEvaporacion->fecha_emision1 }}</span>
    </section>
    <section>
        <b>Fecha Vencimiento:</b>
        <span>{{ $facturasEvaporacion->fecha_vencimiento1 }}</span>
    </section>
    <section class="flex gap-6">
        <div>
            <b>Monto:</b>
            <template x-if="!editMode">
                <span x-text="montoFactura"></span>
            </template>
            <template x-if="editMode">
                <x-ui.input type="number" x-model="montoFactura" />
            </template>
        </div>
        <div>
            <b>Deuda:</b>
            <template x-if="!editMode">
                <span x-text="deudaFactura"></span>
            </template>
            <template x-if="editMode">
                <x-ui.input type="number" x-model="deudaFactura" />
            </template>
        </div>
    </section>
    <section>
        <b>Estado:</b>
        <template x-if="!editMode">
            <span x-text="estadoFactura"></span>
        </template>
        <template x-if="editMode">
            <div class="form-group">
                <select class="form-control uppercase"
                    name="estado_factura"
                    id="estado_factura">
                    @foreach ($estadofacturas as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </template>
    </section>
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