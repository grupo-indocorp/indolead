<section class="flex flex-col">
    <div>
        <b>F. de Evaluación:</b>
        <span>{{ $cuentafinanciera->fecha_evaluacion ?? '' }}</span>
    </div>
    <div>
        <b>Descuento Backoffice:</b>
        <span class="mx-1">{{ $cuentafinanciera->backoffice_descuento }}</span>
        <span class="mx-1">{{ $cuentafinanciera->backoffice_descuento_vigencia }}</span>
    </div>
    <div>
        <b>Descuento Calidad:</b>
        <template x-if="!editMode">
            <div>
                <span class="mx-1" x-text="descuento"></span>
                <span class="mx-1" x-text="descuentoVigencia"></span>
                <span class="mx-1" x-text="fechaDescuento"></span>
            </div>
        </template>
        <template x-if="editMode">
            <div>
                <x-ui.input type="number" x-model="descuento" />
                <x-ui.input type="text" x-model="descuentoVigencia" />
                <x-ui.input type="date" x-model="fechaDescuento" />
            </div>
        </template>
    </div>
    <div class="flex gap-4">
        <div>
            <b>Estado:</b>
            @if (!is_null($cuentafinanciera->estadofactura_id))
                @if ($cuentafinanciera->estadofactura->id_name === 'pagado')
                    <span class="uppercase text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-50 text-green-500 border border-green-500">
                        {{ $cuentafinanciera->estadofactura->name }}
                    </span>
                @elseif ($cuentafinanciera->estadofactura->id_name === 'pagado_ajuste' || $cuentafinanciera->estadofactura->id_name === 'pagado_reclamo')
                    <span class="uppercase text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-500">
                        {{ $cuentafinanciera->estadofactura->name }}
                    </span>
                @else
                    <span class="uppercase text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">
                        {{ $cuentafinanciera->estadofactura->name }}
                    </span>
                @endif
            @endif
        </div>
        <div>
            <b>Ciclo:</b>
            <span>{{ $cuentafinanciera->ciclo }}</span>
        </div>
    </div>
</section>