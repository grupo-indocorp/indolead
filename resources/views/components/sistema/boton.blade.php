@props(['type' => 'middle', 'title', 'count', 'color' => '#ccc', 'active' => false])

<div class="etapa-item etapa-{{ $type }} {{ $active ? 'active' : '' }}" 
     style="--bg-color: {{ $color }}">
    <button 
        {{ $attributes->merge(['class' => 'etapa-btn' . ($active ? ' active' : '')]) }}
        onclick="{{ $attributes->get('onclick') }}"
    >
        <div class="etapa-content">
            <span class="etapa-title">{{ $title }}</span>
            <span class="etapa-count">{{ $count }}</span>
        </div>
    </button>
</div>

<style>
    .etapa-grid-container {
        width: 100%;
        overflow-x: auto;
        padding: 0.5rem 0;
        display: flex;
        justify-content: center; /* Centra el contenido horizontalmente */
    }

    .etapa-grid {
        display: grid;
        grid-auto-flow: column;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        width: 90%; /* Ocupa el 90% del ancho del contenedor */
        gap: 0;
        justify-content: center; /* Centra los botones horizontalmente */
    }

    .etapa-item {
        position: relative;
        height: 80px; /* Aumenta la altura para acomodar más texto */
        flex: 1 1 0;
    }

    .etapa-btn {
        width: 95%; /* Ocupa el 100% del ancho de su contenedor (.etapa-item) */
        height: 100%;
        border: none;
        background: var(--bg-color);
        color: #1e293b;
        font-weight: 700;
        position: relative;
        padding: 0 10px; /* Reduce el padding para dar más espacio al texto */
        transition: all 0.3s ease;
        cursor: pointer;
        clip-path: polygon(95% 0, 100% 50%, 95% 100%, 0% 100%, 5% 50%, 0% 0%);
        margin-right: -25px;
    }

    .etapa-btn.active {
        color: white !important; /* Cambia el color del texto a blanco cuando el botón está activo */
        z-index: 2;
        transform: scale(1.15);
        filter: brightness(1) contrast(1);
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.3); /* Agrega un contorno al botón activo */
    }

    .etapa-item:last-child .etapa-btn {
        margin-right: 0;
        clip-path: polygon(100% 0, 100% 50%, 100% 100%, 0% 100%, 5% 50%, 0% 0%);
    }

    .etapa-item:first-child .etapa-btn {
        clip-path: polygon(95% 0, 100% 50%, 95% 100%, 0% 100%, 0% 50%, 0% 0%);
    }

    .etapa-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
    }

    .etapa-title {
        font-size: 0.70rem;
        line-height: 1.2;
        text-align: center; /* Centra el texto */
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limita el texto a 2 líneas */
        -webkit-box-orient: vertical;
    }

    .etapa-count {
        font-size: 1.1rem;
        font-weight: 900;
        margin-top: 2px;
    }

    @media (max-width: 600px) {
        .etapa-grid {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        }
        
        .etapa-title {
            font-size: 0.7rem;
        }
        
        .etapa-count {
            font-size: 1rem;
        }
    }
</style>