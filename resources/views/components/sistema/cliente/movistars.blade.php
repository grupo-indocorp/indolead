@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'movistar' => '',
])
<x-sistema.card class="m-2 mt-0">
    <div class="relative mb-2 d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Datos Adicionales" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    @if ($config['datosAdicionales']['estadoWick'])
    <div class="form-group w-full max-w-xs mt-2">
        <div class="relative mb-1">
            <select id="estadowick_id" class="block px-2.5 pb-1.5 pt-1.5 w-full text-xs text-[#333333] bg-[#F1F5F9] rounded-lg border-1 border-[#D1D5DB] appearance-none" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
                @foreach ($estadowicks as $value)
                    <option value="{{ $value->id }}" class="text-xs text-[#333333]">{{ $value->nombre }}</option>
                @endforeach
            </select>
            <label for="estadowick_id" class="absolute text-sm text-[#333333] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#F1F5F9] px-2">Estado Wick</label>
        </div>
    </div>
    @endif
    @if ($config['datosAdicionales']['estadoDito'])
        <div class="relative mb-0">
            <select id="estadodito_id" class="block px-2.5 pb-1.5 pt-1.5 w-full text-xs text-[#333333] bg-[#F1F5F9] rounded-lg border-1 border-[#D1D5DB] appearance-none" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
                @foreach ($estadoditos as $value)
                    <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                @endforeach
            </select>
            <label for="estadodito_id" class="absolute text-sm text-[#333333] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#F1F5F9] px-2">Estado Dito</label>
        </div>
    @endif
    <div class="relative mb-2 d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Lineas Telefonicas" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    @if ($config['datosAdicionales']['lineaClaro'])
        <div class="relative mb-3">
            <input class="block px-2.5 pb-1.5 pt-1.5 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="number" id="linea_claro" name="linea_claro" value="{{ $movistar->linea_claro ?? 0 }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
            <label for="linea_claro" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Claro</label>
        </div>
    @endif
    @if ($config['datosAdicionales']['lineaEntel'])
        <div class="relative mb-3">
            <input class="block px-2.5 pb-1.5 pt-1.5 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="number" id="linea_entel" name="linea_entel" value="{{ $movistar->linea_entel ?? 0 }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
            <label for="linea_entel" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Entel</label>
        </div>
    @endif
    @if ($config['datosAdicionales']['lineaBitel'])
        <div class="relative mb-3">
            <input class="block px-2.5 pb-1.5 pt-1.5 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="number" id="linea_bitel" name="linea_bitel" value="{{ $movistar->linea_bitel ?? 0 }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
            <label for="linea_bitel" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Bitel</label>
        </div>
    @endif
    @if ($config['datosAdicionales']['lineaMovistar'])
        <div class="relative mb-3">
            <input class="block px-2.5 pb-1.5 pt-1.5 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="number" id="linea_movistar" name="linea_movistar" value="{{ $movistar->linea_movistar ?? 0 }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
            <label for="linea_movistar" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Movistar</label>
        </div>
    @endif
    @if ($config['datosAdicionales']['tipoCliente'])
        <div class="relative mb-3">
            <select id="clientetipo_id" class="block px-2.5 pb-1.5 pt-1.5 w-full text-xs text-[#333333] bg-[#F1F5F9] rounded-lg border-1 border-[#D1D5DB] appearance-none" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
                @foreach ($clientetipos as $value)
                <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                @endforeach
            </select>
            <label for="clientetipo_id" class="absolute text-sm text-[#333333] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#F1F5F9] px-2">Tipo Cliente</label>
        </div>
    @endif
    @if ($config['datosAdicionales']['ejecutivoSalesforce'])
        <div class="relative mb-3">
            <input class="block px-2.5 pb-1.5 pt-1.5 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="text" id="ejecutivo_salesforce" name="ejecutivo_salesforce" value="{{ $movistar->ejecutivo_salesforce ?? '' }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
            <label for="ejecutivo_salesforce" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9] whitespace-nowrap">
                Ejecutivo Salesforce
            </label>        </div>
    @endif
    @if ($config['datosAdicionales']['agencia'])
        <div class="relative mb-1">
            <select id="agencia_id" class="block px-2.5 pb-1.5 pt-1.5 w-full text-xs text-[#333333] bg-[#F1F5F9] rounded-lg border-1 border-[#D1D5DB] appearance-none" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
                @foreach ($agencias as $value)
                <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                @endforeach
            </select>
            <label for="agencia_id" class="absolute text-sm text-[#333333] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#F1F5F9] px-2">Agencia</label>
        </div>
    @endif
    {{ $botonFooter }}
</x-sistema.card>
<script>
    $('#estadowick_id').on('change', function() {
        if ($(this).val() == 3) {
            $('#estadodito_id').val(3);
            $('#estadodito_id').prop('disabled', true);
        } else {
            $('#estadodito_id').val(1);
            $('#estadodito_id').prop('disabled', false);
        }
    });
</script>
