<div class="alert alert-{{ $mensaje['color'] }} alert-dismissible fade show text-slate-900" role="alert">
    <span class="alert-icon">
        <i class="fa-solid fa-hexagon-exclamation"></i>
    </span>
    <span class="alert-text">
        <strong class="text-white">{{ $mensaje['mensaje'] }}</strong>
    </span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="text-white">&times;</span>
    </button>
</div>