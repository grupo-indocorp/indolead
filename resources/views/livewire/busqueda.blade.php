<form>
    <div class="form-group">
        <div class="input-group">
            <button class="input-group-text" type="submit"><i class="fas fa-search"></i></button>
            <input class="form-control form-control-sm" placeholder="Buscar" value="{{ request('query') }}" type="search" id="query" name="query">
        </div>
    </div>
    @if ($mensaje)
        @livewire('alerta', ['mensaje' => $mensaje])
    @endif
</form>