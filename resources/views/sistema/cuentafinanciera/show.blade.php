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
            <span>{{ $cuentafinanciera->estado_evaluacion }}</span>
        </div>
        <div>
            <b>Ciclo:</b>
            <span>{{ $cuentafinanciera->ciclo}}</span>
        </div>
    </div>
</section>