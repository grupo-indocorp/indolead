<x-sistema.modal title="Detalle" dialog_id="dialog">
    <section class="flex flex-col gap-2">
        <section class="flex flex-col">
            <div class="flex gap-4">
                <span class="text-lg text-slate-900 font-bold">{{ $cuentafinanciera->cliente->ruc }}</span>
                <span class="text-lg text-blue-500 font-bold">{{ $cuentafinanciera->cliente->razon_social }}</span>
            </div>
            <span class="font-bold">{{ $cuentafinanciera->user->name }}</span>
        </section>
    
        <section class="grid grid-cols-3 gap-2">
            <x-sistema.card>
                <div class="flex gap-2">
                    <span class="text-base font-bold">CUENTA FINANCIERA:</span>
                    <div class="form-group w-full">
                        <select class="form-control uppercase"
                            name="cuenta_financiera"
                            id="cuenta_financiera">
                            @foreach ($cantidadCuentafinancieras as $item)
                                <option value="{{ $item->id }}"
                                    @if ($item->id === $cuentafinanciera->id) selected @endif>
                                    {{ $item->cuenta_financiera }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <section id="cuentafinancieraShow"></section>
            </x-sistema.card>
            <x-sistema.card>
                <div class="flex flex-col">
                    <span class="text-base font-bold">COMENTARIO:</span>
                    <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus velit voluptate facilis. Nemo ipsam adipisci alias facere molestiae, eos dignissimos, aspernatur tempora unde aperiam nobis quam. Beatae porro laboriosam a.</p>
                </div>
            </x-sistema.card>
            <x-sistema.card x-data="{
                    editMode: false,
                    isSaving: false,
                    observacion_calidad: '',
                    saveObservacion() {
                        if (this.observacion_calidad.trim() === '') {
                            alert('La observación no puede estar vacía.');
                            return;
                        } else {
                            limpiarError();
                            capturarToken();
    
                            this.isSaving = true;
                            let self = this;
                            $.ajax({
                                url: `{{ url('cuentas-financieras/'. $cuentafinanciera->id) }}`,
                                method: 'PUT',
                                data: {
                                    view: 'update-comentario-calidad',
                                    observacion_calidad: self.observacion_calidad,
                                },
                                success: function(result) {
                                    // Salir del modo edición
                                    self.editMode = false;
                                    alert('Cambios guardados correctamente');
                                    {{-- self.observacion_calidad = ''; --}}
    
                                    // Actualizar fecha_evaluacion de cuenta financiera
                                    cuentafinancieraShow('{{ $cuentafinanciera->id }}');
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
                    }
                }">
                <div class="form-group">
                    <div class="flex justify-between">
                        <label for="observacion_calidad" class="form-control-label">OBSERVACIÓN:</label>
                        <div>
                            <template x-if="!editMode">
                                <span class="hover:cursor-pointer hover:text-slate-500"
                                    @click="editMode = true">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </span>
                            </template>
                            <template x-if="editMode">
                                <span class="hover:cursor-pointer hover:text-slate-500"
                                    @click="if (!isSaving) { saveObservacion(); }"
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
                    </div>
                    <textarea class="form-control"
                        rows="3"
                        id="observacion_calidad"
                        name="observacion_calidad"
                        x-model="observacion_calidad"
                        :disabled="!editMode"></textarea>
                </div>
            </x-sistema.card>
        </section>
    
        <section class="grid grid-cols-3 gap-2" id="cuentafinancieraFacturas"></section>

        <x-sistema.card>
            <section id="cuentafinancieraProductos"></section>
        </x-sistema.card>
    </section>
</x-sistema.modal>
<script>
    function detalleCuentafinanciera(cuentafinanciera_id) {
        $.ajax({
            url: `{{ url('cuentas-financieras/${cuentafinanciera_id}') }}`,
            method: "GET",
            data: {
                view: 'show-cuentafinanciera',
            },
            success: function( result ) {
                $('#contenedorModal').html(result);
                openModal();
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
    // cuenta_financiera
     $(document).ready(function () {
        $('#cuenta_financiera').on('change', function () {
            let cuentafinanciera_id = $(this).val();
            cuentafinancieraShow(cuentafinanciera_id);
            cuentafinancieraProductos(cuentafinanciera_id);
            cuentafinancieraFacturas(cuentafinanciera_id);
        });

        $('#cuenta_financiera').trigger('change');
    });
    function cuentafinancieraShow(cuentafinanciera_id) {
        $.ajax({
            url: `{{ url('cuentas-financieras/${cuentafinanciera_id}') }}`,
            method: "GET",
            data: {
                view: 'show-cuentafinanciera',
            },
            success: function( result ) {
                $('#cuentafinancieraShow').html(result);
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
    function cuentafinancieraProductos(cuentafinanciera_id) {
        $.ajax({
            url: `{{ url('cuentas-financieras/${cuentafinanciera_id}') }}`,
            method: "GET",
            data: {
                view: 'show-productos',
            },
            success: function( result ) {
                $('#cuentafinancieraProductos').html(result);
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
    function cuentafinancieraFacturas(cuentafinanciera_id) {
        $.ajax({
            url: `{{ url('cuentas-financieras/${cuentafinanciera_id}') }}`,
            method: "GET",
            data: {
                view: 'show-facturas',
            },
            success: function( result ) {
                $('#cuentafinancieraFacturas').html(result);
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
</script>
