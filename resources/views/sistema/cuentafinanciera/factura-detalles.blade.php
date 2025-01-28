<x-ui.table>
    <x-slot:thead>
        <tr>
            <th>{{ __('NUMERO') }}</th>
            <th>{{ __('ORDEN') }}</th>
            <th>{{ __('PRODUCTO') }}</th>
            <th>{{ __('CARGO FIJO') }}</th>
            <th>{{ __('MONTO') }}</th>
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
        @foreach ($facturadetalles as $item)
            <tr x-data="{
                    editMode: false,
                    isSaving: false,
                    error: '',
                    monto: '{{ $item->monto }}',
                    fechaEstadoProducto: '{{ $item->fecha_estadoproducto }}',
                    estadoProducto: '{{ $item->estadoproducto->name }}',
                    estadoProductoId: '{{ $item->estadoproducto_id }}',
                    saveChanges() {
                        limpiarError();
                        capturarToken();

                        if (this.estadoProductoId === '') {
                            this.error = 'Por favor, selecciona un estado válido.';
                            return;
                        }
                        if (this.fechaEstadoProducto === '') {
                            this.error = 'Por favor, selecciona una fecha válida.';
                            return;
                        }

                        this.isSaving = true;
                        let self = this;
                        $.ajax({
                            url: `{{ url('cuentas-financieras/'. $item->factura->cuentafinanciera_id) }}`,
                            method: 'PUT',
                            data: {
                                view: 'update-factura-detalles',
                                facturadetalle_id: '{{ $item->id }}',
                                monto: self.monto,
                                fecha_estadoproducto: self.fechaEstadoProducto,
                                estadoproducto_id: self.estadoProductoId,
                            },
                            success: function(result) {
                                self.monto = result.monto ?? self.monto;
                                self.fechaEstadoProducto = result.fechaEstadoProducto ?? self.fechaEstadoProducto;
                                self.estadoProducto = result.estadoProducto ?? self.estadoProducto;

                                // Salir del modo edición
                                self.editMode = false;
                                alert('Cambios guardados correctamente');

                                // Actualizar fecha_evaluacion de cuenta financiera
                                cuentafinancieraShow('{{ $item->factura->cuentafinanciera_id }}');
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
                <td>{{ $item->numero_servicio }}</td>
                <td>{{ $item->orden_pedido }}</td>
                <td>{{ $item->producto }}</td>
                <td>{{ $item->cargo_fijo }}</td>
                <td>
                    <template x-if="!editMode">
                        <span x-text="monto"></span>
                    </template>
                    <template x-if="editMode">
                        <x-ui.input type="number" x-model="monto" />
                    </template>
                </td>
                <td>{{ $item->descuento }}</td>
                <td>{{ $item->descuento_vigencia }}</td>
                <td>{{ $item->fecha_solicitud }}</td>
                <td>{{ $item->fecha_activacion }}</td>
                <td>{{ $item->periodo_servicio }}</td>
                <td class="flex flex-col">
                    <template x-if="!editMode">
                        <b x-text="fechaEstadoProducto"></b>
                    </template>
                    <template x-if="editMode">
                        <x-ui.input type="date" x-model="fechaEstadoProducto" />
                        <p class="text-red-500 text-sm mt-2" x-show="error" x-text="error"></p>
                    </template>
                    <template x-if="!editMode">
                        @switch($item->estadoproducto->id_name)
                            @case('activo')
                                <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-50 text-green-500 border border-green-500"
                                    x-text="estadoProducto"></span>
                                @break
                            @case('corte_deuda_parcial')
                                <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-500"
                                    x-text="estadoProducto"></span>
                                @break
                            @default
                                <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500"
                                    x-text="estadoProducto"></span>
                        @endswitch
                    </template>
                    <template x-if="editMode">
                        <div class="form-group">
                            <select class="form-control uppercase"
                                x-model="estadoProductoId">
                                <option value="">---Seleccionar---</option>
                                @foreach ($estadoproductos as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-red-500 text-sm mt-2" x-show="error" x-text="error"></p>
                        </div>
                    </template>
                </td>
                <td>
                    <template x-if="!editMode">
                        <span class="hover:cursor-pointer hover:text-slate-900" @click="editMode = true">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </span>
                    </template>
                    <template x-if="editMode">
                        <div class="flex gap-2">
                            <span class="hover:cursor-pointer hover:text-slate-900"
                                :class="{ 'opacity-50 cursor-not-allowed': isSaving }"
                                @click="if (!isSaving) { saveChanges(); }"
                                :disabled="isSaving">
                                <i class="fa-solid fa-floppy-disk"></i>
                            </span>
                            <span class="hover:cursor-pointer hover:text-slate-900" @click="editMode = false">
                                <i class="fa-solid fa-xmark"></i>
                            </span>
                        </div>
                    </template>
                </td>
            </tr>
        @endforeach
    </x-slot>
    <x-slot:tfoot></x-slot>
</x-ui.table>