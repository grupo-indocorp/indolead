<x-sistema.modal title="Acceso Ficha Cliente" dialog_id="dialog">
    <form action="{{ route('configuracion-ficha-cliente.store') }}" method="post" class="m-0">
        @csrf
        <input type="hidden" name="view" id="view" value="store-datos-adicionales">
        <div id="cont-permisos">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="estadoWick" name="estadoWick" @if ($configDatosAdicionales['datosAdicionales']['estadoWick']) checked @endif>
                <label class="form-check-label" for="estadoWick">Estado Wick</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="estadoDito" name="estadoDito" @if ($configDatosAdicionales['datosAdicionales']['estadoDito']) checked @endif>
                <label class="form-check-label" for="estadoDito">Estado Dito</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="lineaClaro" name="lineaClaro" @if ($configDatosAdicionales['datosAdicionales']['lineaClaro']) checked @endif>
                <label class="form-check-label" for="lineaClaro">Línea Claro</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="lineaEntel" name="lineaEntel" @if ($configDatosAdicionales['datosAdicionales']['lineaEntel']) checked @endif>
                <label class="form-check-label" for="lineaEntel">Línea Entel</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="lineaBitel" name="lineaBitel" @if ($configDatosAdicionales['datosAdicionales']['lineaBitel']) checked @endif>
                <label class="form-check-label" for="lineaBitel">Línea Bitel</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="lineaMovistar" name="lineaMovistar" @if ($configDatosAdicionales['datosAdicionales']['lineaMovistar']) checked @endif>
                <label class="form-check-label" for="lineaMovistar">Línea Movistar</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="tipoCliente" name="tipoCliente" @if ($configDatosAdicionales['datosAdicionales']['tipoCliente']) checked @endif>
                <label class="form-check-label" for="tipoCliente">Tipo Cliente</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="ejecutivoSalesforce" name="ejecutivoSalesforce" @if ($configDatosAdicionales['datosAdicionales']['ejecutivoSalesforce']) checked @endif>
                <label class="form-check-label" for="ejecutivoSalesforce">Ejecutivo Salesforce</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="agencia" name="agencia" @if ($configDatosAdicionales['datosAdicionales']['agencia']) checked @endif>
                <label class="form-check-label" for="agencia">Agencia</label>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn bg-gradient-primary m-0">Guardar</button>
        </div>
    </form>
</x-sistema.modal>
