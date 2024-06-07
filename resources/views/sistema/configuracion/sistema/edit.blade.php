<x-sistema.modal title="Editar Etapa" dialog_id="dialog">
    <form action="{{ route('configuracion-sistema.update', $sistema->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="view" id="view" value="update-sistema">
        <div class="form-group">
            <label for="nombre" class="form-control-label">Nombre:</label>
            <input class="form-control" type="text" value="{{ $sistema->nombre }}" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="logo" class="form-control-label">Logo</label>
            <input class="form-control" type="file" accept="image/*" id="logo" name="logo">
            <img id="preview_logo" src="{{ Storage::url($sistema->logo) }}" alt="Vista previa del logo" style="display: block; width:200px;">
        </div>
        <div class="form-group">
            <label for="icono" class="form-control-label">Icono</label>
            <input class="form-control" type="file" accept="image/*" id="icono" name="icono">
            <img id="preview_icono" src="{{ Storage::url($sistema->icono) }}" alt="Vista previa del icono" style="display: block; width:200px;">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn bg-gradient-primary m-0">Guardar</button>
        </div>
    </form>
</x-sistema.modal>
<script>
    $('#logo').change(function(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_logo').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
    $('#icono').change(function(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_icono').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
