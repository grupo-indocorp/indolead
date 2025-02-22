@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'movistar' => '',
])
<x-sistema.card class="m-4 mb-2 mx-0">
    <div class="d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Datos Adicionales" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    @if ($config['datosAdicionales']['estadoWick'])
        <div class="form-group">
            <label for="estadowick_id" class="form-control-label">Estado Wick</label>
            <select class="form-control" id="estadowick_id" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
                @foreach ($estadowicks as $value)
                    <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                @endforeach
            </select>
        </div>
    @endif
    @if ($config['datosAdicionales']['estadoDito'])
        <div class="form-group">
            <label for="estadodito_id" class="form-control-label">Estado Dito</label>
            <select class="form-control" id="estadodito_id" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
                @foreach ($estadoditos as $value)
                    <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                @endforeach
            </select>
        </div>
    @endif
    @if ($config['datosAdicionales']['lineaClaro'])
        <div class="form-group">
            <label for="linea_claro" class="form-control-label">Lineas Claro</label>
            <input class="form-control" type="number" id="linea_claro" name="linea_claro" value="{{ $movistar->linea_claro ?? 0 }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
        </div>
    @endif
    @if ($config['datosAdicionales']['lineaEntel'])
        <div class="form-group">
            <label for="linea_entel" class="form-control-label">Lineas Entel</label>
            <input class="form-control" type="number" id="linea_entel" name="linea_entel" value="{{ $movistar->linea_entel ?? 0 }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
        </div>
    @endif
    @if ($config['datosAdicionales']['lineaBitel'])
        <div class="form-group">
            <label for="linea_bitel" class="form-control-label">Lineas Bitel</label>
            <input class="form-control" type="number" id="linea_bitel" name="linea_bitel" value="{{ $movistar->linea_bitel ?? 0 }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
        </div>
    @endif
    @if ($config['datosAdicionales']['lineaMovistar'])
        <div class="form-group">
            <label for="linea_movistar" class="form-control-label">Lineas Movistar</label>
            <input class="form-control" type="number" id="linea_movistar" name="linea_movistar" value="{{ $movistar->linea_movistar ?? 0 }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
        </div>
    @endif
    @if ($config['datosAdicionales']['tipoCliente'])
        <div class="form-group">
            <label for="clientetipo_id" class="form-control-label">Tipo Cliente</label>
            <select class="form-control" id="clientetipo_id" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
                @foreach ($clientetipos as $value)
                    <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                @endforeach
            </select>
        </div>
    @endif
    @if ($config['datosAdicionales']['ejecutivoSalesforce'])
        <div class="form-group">
            <label for="ejecutivo_salesforce" class="form-control-label">Ejecutivo Salesforce</label>
            <input class="form-control" type="text" id="ejecutivo_salesforce" name="ejecutivo_salesforce" value="{{ $movistar->ejecutivo_salesforce ?? '' }}" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
        </div>
    @endif
    @if ($config['datosAdicionales']['agencia'])
        <div class="form-group">
            <label for="agencia_id" class="form-control-label">Agencia</label>
            <select class="form-control" id="agencia_id" @php echo ($movistar != '' ? 'disabled' : '') @endphp>
                @foreach ($agencias as $value)
                    <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                @endforeach
            </select>
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
