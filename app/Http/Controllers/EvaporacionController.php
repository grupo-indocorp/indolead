<?php

namespace App\Http\Controllers;

use App\Models\Evaporacion;
use App\Services\EvaporacionService;
use Illuminate\Http\Request;

class EvaporacionController extends Controller
{
    protected $evaporacionService;

    public function __construct(EvaporacionService $evaporacionService)
    {
        $this->evaporacionService = $evaporacionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $filter = [
            'estado' => request('filtro_estado') ?? null,
            'fechainicio' => request('filtro_fechainicio') ?? null,
            'fechafin' => request('filtro_fechafin') ?? null,
        ];
        $evaporacion = $this->evaporacionService->evaporacionGet($user, $filter);

        return view('sistema.evaporacion.index', compact('evaporacion'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $view = request('view');
        if ($view === 'show-evaporacion') {
            $evaporacion = Evaporacion::find($id);

            return view('sistema.evaporacion.detalle', compact('evaporacion'));
        }
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
