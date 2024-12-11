<section class="grid grid-cols-3 gap-2">
    @foreach ($facturas as $key => $item)
        @php $key++; @endphp
        <x-sistema.card x-data="{
                editMode: false,
                isSaving: false,
                montoFactura: '{{ $item->monto }}',
                deudaFactura: '{{ $item->deuda }}',
                estadoFactura: '{{ $item->estadofactura->name }}',
                saveFactura() {
                    limpiarError();
                    capturarToken();
    
                    this.isSaving = true;
                    let self = this;
                    $.ajax({
                        url: `{{ url('cuentas-financieras/'. $item->cuentafinanciera_id) }}`,
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
            <section class="flex justify-between">
                <h5>Factura {{ $key }}</h5>
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
                <span>{{ $item->fecha_emision }}</span>
            </section>
            <section>
                <b>Fecha Vencimiento:</b>
                <span>{{ $item->fecha_vencimiento }}</span>
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
                    <span x-text="estadoFactura" class="uppercase"></span>
                </template>
                <template x-if="editMode">
                    <div class="form-group">
                        <select class="form-control uppercase"
                            name="estado_factura"
                            id="estado_factura">
                            @foreach ($estadofacturas as $item)
                                <option value="{{ $item->id }}" @if ($item->estadofactura_id === $item->id) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </template>
            </section>
        </x-sistema.card>
    @endforeach

    {{-- agregar nueva factura --}}
    <section x-data="{
            addMode: false,
            isSaving: false,
            montoFactura: '0',
            deudaFactura: '0',
            addFactura() {
                limpiarError();
                capturarToken();

                this.isSaving = true;
                let self = this;
                $.ajax({
                    url: `{{ url('cuentas-financieras/'. $cuentafinanciera->id) }}`,
                    method: 'PUT',
                    data: {
                        view: 'update-store-factura',
                        monto_factura: self.montoFactura,
                        deuda_factura: self.deudaFactura,
                    },
                    success: function(result) {
                        // Salir del modo edición
                        self.addMode = false;

                        // Actualizar facturas
                        cuentafinancieraShow('{{ $cuentafinanciera->id }}');
                        cuentafinancieraFacturas({{ $cuentafinanciera->id }});
                    },
                    error: function(response) {
                        mostrarError(response);
                        alert('Hubo un error al guardar los cambios');
                    },
                    complete: function() {
                        self.isSaving = false;
                    }
                });

                console.log('agregando una factura xd');
            }
        }">
        <template x-if="!addMode">
            <span class="hover:cursor-pointer hover:text-slate-500"
                @click="addMode = true">
                <i class="fa-solid fa-plus"></i>
            </span>
        </template>
        <template x-if="addMode">
            <x-sistema.card>
                <section class="flex justify-between">
                    <h5>Nueva Factura</h5>
                    <div>
                        <template x-if="!addMode">
                            <span class="hover:cursor-pointer hover:text-slate-500"
                                @click="addMode = true">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </span>
                        </template>
                        <template x-if="addMode">
                            <span class="hover:cursor-pointer hover:text-slate-500"
                                @click="if (!isSaving) { addFactura(); }"
                                :disabled="isSaving">
                                <i class="fa-solid fa-floppy-disk"></i>
                            </span>
                        </template>
                        <template x-if="addMode">
                            <span class="hover:cursor-pointer hover:text-slate-500"
                                @click="addMode = false">
                                <i class="fa-solid fa-xmark"></i>
                            </span>
                        </template>
                    </div>
                </section>
                <section>
                    <b>Fecha Emisión:</b>
                    <span></span>
                </section>
                <section>
                    <b>Fecha Vencimiento:</b>
                    <span></span>
                </section>
                <section class="flex gap-6">
                    <div>
                        <b>Monto:</b>
                        <template x-if="addMode">
                            <x-ui.input type="number" x-model="montoFactura" />
                        </template>
                    </div>
                    <div>
                        <b>Deuda:</b>
                        <template x-if="addMode">
                            <x-ui.input type="number" x-model="deudaFactura" />
                        </template>
                    </div>
                </section>
                <section>
                    <b>Estado:</b>
                    <template x-if="addMode">
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
        </template>
    </section>
</section>