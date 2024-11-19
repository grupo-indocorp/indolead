<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Http\Request;

class ConfiguracionFichaClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sistema.configuracion.ficha_cliente.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $view = request('view');
        if ($view === 'store-datos-adicionales') {
            $configData = [
                'estadoWick' => is_null(request('estadoWick')) ? false : true,
                'estadoDito' => is_null(request('estadoDito')) ? false : true,
                'lineaClaro' => is_null(request('lineaClaro')) ? false : true,
                'lineaEntel' => is_null(request('lineaEntel')) ? false : true,
                'lineaBitel' => is_null(request('lineaBitel')) ? false : true,
                'lineaMovistar' => is_null(request('lineaMovistar')) ? false : true,
                'tipoCliente' => is_null(request('tipoCliente')) ? false : true,
                'ejecutivoSalesforce' => is_null(request('ejecutivoSalesforce')) ? false : true,
                'agencia' => is_null(request('agencia')) ? false : true,
            ];
            Helpers::configuracionDatosAdicionalesJsonPut('datosAdicionales', $configData);

            return redirect()->route('configuracion-ficha-cliente.index')->with('success', 'Accesos de Ficha Cliente Actualizados.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $view = request('view');
        if ($view === 'edit-datos-adicionales') {
            $configDatosAdicionales = Helpers::configuracionDatosAdicionalesJsonGet();

            return view('sistema.configuracion.ficha_cliente.edit_datos_adicionales', compact('configDatosAdicionales'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
