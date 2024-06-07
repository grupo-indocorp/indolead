@extends('layouts.app')
@section('content')
    <x-sistema.card-contenedor>
        <x-sistema.card-contenedor-header title="Roles y Permisos">
            <a href="{{ route('role.create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">Agregar</a>
        </x-sistema.card-contenedor-header>
        <div class="p-4">
            <x-sistema.tabla-contenedor>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rol</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Creación</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Permisos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr id="{{ $role->id }}">
                            <td class="align-middle text-center">
                                <h6 class="mb-0 text-xs text-uppercase">{{ $role->name }}</h6>
                                <p class="text-xs text-secondary mb-0"></p>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-normal">{{ $role->created_at }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <a href="javascript:;" class="cursor-pointer" onclick="permisos({{ $role->id }})">
                                    <i class="fa-solid fa-eyes"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-sistema.tabla-contenedor>
        </div>
    </x-sistema.card-contenedor>
@endsection

@section('modal')
<div id="contModal"></div>
@endsection

<script>
    function permisos(role_id) {
        $.ajax({
            url: `{{ url('role/show-permiso') }}`,
            method: "GET",
            data: {
                role_id: role_id
            },
            success: function( result ) {
                $('#contModal').html(result);
                openModal();
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
</script>