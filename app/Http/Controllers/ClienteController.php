<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Etapa;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = request('view');
        if ($view === 'create') {
            $etapas = Etapa::all();
            return view('sistema.cliente.create', compact('etapas'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $view = request('view');
        if ($view === 'store') {
            if (request('dni') != '') {
                $request->validate(
                    [
                        'nombre' => 'required|bail',
                        'dni' => 'required|numeric|digits:8|bail',
                        'celular' => 'required|bail',
                        'cargo' => 'required|bail',
                    ],
                    [
                        'nombre.required' => 'El "Nombre" es obligatorio.',
                        'dni.required' => 'El "DNI" es obligatorio.',
                        'dni.numeric' => 'El "DNI" debe ser numérico.',
                        'dni.digits' => 'El "DNI" debe tener exactamente 8 dígitos.',
                        'celular.required' => 'El "Celular" es obligatorio.',
                        'cargo.required' => 'El "Cargo" es obligatorio.',
                    ]
                );
            }
            $this->clienteService->clienteStore($request);
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
        //
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
