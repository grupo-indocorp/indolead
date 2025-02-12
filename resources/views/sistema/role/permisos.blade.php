<x-sistema.modal class="w-auto max-w-md" :title="$role->name">
    <form action="{{ route('role.update', $role->id) }}" method="post" class="m-0">
        @csrf
        @method('put')

        <div id="cont-permisos">
            @foreach ($permissions as $permission)
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="{{ $permission['id'] }}" name="{{ $permission['id'] }}" {{ $permission['checked'] }}>
                    <label class="form-check-label" for="{{ $permission['id'] }}">{{ $permission['name'] }}</label>
                </div>
            @endforeach
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn bg-gradient-primary m-0">Actualizar</button>
        </div>
    </form>
</x-sistema.modal>
