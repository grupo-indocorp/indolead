<form name="formSelectorPagina">
    <div class="form-group">
        <select class="form-control" id="selectorPagina" name="selectorPagina" onchange="select()">
            @foreach ($views as $view)
                @php
                    $select = (request('selectorPagina') == $view) ? 'selected' : '';
                @endphp
                <option value="{{ $view }}" {{ $select }}>
                    {{ $view }}
                </option>
            @endforeach
        </select>
    </div>
</form>

<script>
    function select() {
        formSelectorPagina.submit();
    }
</script>