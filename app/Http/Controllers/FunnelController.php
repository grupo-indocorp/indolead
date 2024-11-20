<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Etapa;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class FunnelController extends Controller
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
        if (auth()->user()->hasRole('administrador')) {
            $data = Cliente::orderByDesc('id')->get();
        } else {
            $data = auth()->user()->clientes()->orderByDesc('id')->get();
        }
        $clientes = $this->clienteService->obtenerClientes($data);
        $etapas = Etapa::all();

        return view('sistema.funnel.index', compact('clientes', 'etapas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request('view') == 'create') {
            $etapas = Etapa::all();

            return view('sistema.funnel.create', compact('etapas'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (request('view') == 'detalle') {
            $data = $this->clienteService->obtenerClienteDetalle($id);

            return view('sistema.funnel.detalle', compact('data'));
        } elseif (request('view') == 'show-funnel') {
            if (auth()->user()->hasRole('administrador')) {
                $data = Cliente::orderByDesc('id')->get();
            } else {
                $data = auth()->user()->clientes()->orderByDesc('id')->get();
            }
            $clientes = $this->clienteService->obtenerClientes($data);
            $etapas = Etapa::all();
            $data = [
                'clientes' => $clientes,
                'etapas' => $etapas,
            ];

            return response()->json($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
