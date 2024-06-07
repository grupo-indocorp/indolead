<x-sistema.modal title="Acceso Descarga Excel" dialog_id="dialog">
    <form action="{{ route('configuracion-excel.store') }}" method="post" class="m-0">
        @csrf
        <input type="hidden" name="view" id="view" value="store">
        <div id="cont-permisos">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="excelIndotech" name="excelIndotech" @if ($indotech) checked @endif>
                <label class="form-check-label" for="excelIndotech">Excel Indotech</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="excelSecodi" name="excelSecodi" @if ($secodi) checked @endif>
                <label class="form-check-label" for="excelSecodi">Excel Secodi</label>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn bg-gradient-primary m-0">Guardar</button>
        </div>
    </form>
</x-sistema.modal>
