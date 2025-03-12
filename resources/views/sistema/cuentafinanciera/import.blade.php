<x-sistema.modal class="" style="width: 500px;" title="Importar Excel">
    <section class="p-4 pb-0">
        <form action="{{ route('import.evaporacion') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <x-ui.label for="categoria_id">{{ __('Categoría *:') }}</x-ui.label>
                <select class="form-control uppercase" name="categoria_id" id="categoria_id" required>
                    @foreach ($categorias as $value)
                        <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <x-ui.label for="sede_id">{{ __('Sede *:') }}</x-ui.label>
                <select class="form-control uppercase" name="sede_id" id="sede_id" required>
                    @foreach ($sedes as $value)
                        <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <x-ui.label for="user_evaporacion">{{ __('Ejecutivo *:') }}</x-ui.label>
                <select class="form-control uppercase" name="user_evaporacion" id="user_evaporacion" required>
                    @foreach ($users as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">{{ __('Selecciona el archivo Excel *:') }}</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <x-ui.button type="submit">Subir</x-ui.button>
        </form>
    </section>
</x-sistema.modal>