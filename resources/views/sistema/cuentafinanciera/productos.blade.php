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
            <tr x-data="{
                    editMode: false,
                    isSaving: false,
                    cargoFijo: '{{ $item->cargo_fijo }}',
                    fechaEstadoLinea: '{{ $item->fecha_estado_linea }}',
                    estadoLinea: '{{ $item->estado_linea }}',
                    saveChanges() {
                        limpiarError();
                        capturarToken();

                        this.isSaving = true;
                        let self = this;
                        $.ajax({
                            url: `{{ url('cuentas-financieras/'. $item->cuentafinanciera_id) }}`,
                            method: 'PUT',
                            data: {
                                view: 'update-producto-edit',
                                evaporacion_id: '{{ $item->id }}',
                                cargo_fijo: self.cargoFijo,
                                fecha_estado_linea: self.fechaEstadoLinea,
                                estado_linea: self.estadoLinea,
                            },
                            success: function(result) {
                                self.cargoFijo = result.cargoFijo ?? self.cargoFijo;
                                self.fechaEstadoLinea = result.fechaEstadoLinea ?? self.fechaEstadoLinea;
                                self.estadoLinea = result.estadoLinea ?? self.estadoLinea;

                                // Salir del modo edición
                                self.editMode = false;
                                alert('Cambios guardados correctamente');

                                // Actualizar fecha_evaluacion de cuenta financiera
                                cuentafinancieraShow('{{ $item->cuentafinanciera_id }}');
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
                <td>
                    <template x-if="!editMode">
                        <span x-text="cargoFijo"></span>
                    </template>
                    <template x-if="editMode">
                        <x-ui.input type="number" x-model="cargoFijo" />
                    </template>
                </td>
                <td>{{ $item->descuento }}</td>
                <td>{{ $item->descuento_vigencia }}</td>
                <td>{{ $item->fecha_solicitud }}</td>
                <td>{{ $item->fecha_activacion }}</td>
                <td>{{ $item->periodo_servicio }}</td>
                <td class="flex flex-col">
                    <template x-if="!editMode">
                        <b x-text="fechaEstadoLinea"></b>
                    </template>
                    <template x-if="editMode">
                        <x-ui.input type="date" x-model="fechaEstadoLinea" />
                    </template>

                    <span x-text="estadoLinea"></span>
                    {{-- <template x-if="!editMode">
                        <span x-text="estadoLinea"></span>
                    </template>
                    <template x-if="editMode">
                        <x-ui.input type="text" x-model="estadoLinea" />
                    </template> --}}
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