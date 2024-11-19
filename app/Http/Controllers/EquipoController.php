<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipos = Equipo::with(['user:id,name', 'sede:id,nombre'])->orderByDesc('id')->paginate(8);

        return view('sistema.equipo.index', compact('equipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request('view') == 'create') {
            $users = User::all();
            $sedes = Sede::all();

            return view('sistema.equipo.create', compact('users', 'sedes'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (request('view') == 'store') {
            $request->validate([
                'nombre' => 'required|bail',
                'sede_id' => 'required|bail',
                'user_id' => 'required|bail',
            ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'sede_id.required' => 'La "Sede" es obligatorio.',
                    'user_id.required' => 'El "Supervisor" es obligatorio.',
                ]);
            $equipo = new Equipo;
            $equipo->nombre = request('nombre');
            $equipo->sede_id = request('sede_id');
            $equipo->user_id = request('user_id');
            $equipo->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $view = request('view');
        if ($view === 'show-cambiar-equipo') {
            $user = User::find(request('user_id'));

            return $user;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $equipo = Equipo::find($id);
        if (request('view') == 'edit') {
            $users = User::all();
            $sedes = Sede::all();

            return view('sistema.equipo.edit', compact('equipo', 'users', 'sedes'));
        } elseif (request('view') == 'edit-ejecutivo') {
            $equipos = Equipo::all();

            return view('sistema.equipo.ejecutivo', compact('equipo', 'equipos'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $view = request('view');
        $equipo = Equipo::find($id);
        if ($view === 'update') {
            $request->validate([
                'nombre' => 'required|bail',
                'sede_id' => 'required|bail',
                'user_id' => 'required|bail',
            ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'sede_id.required' => 'La "Sede" es obligatorio.',
                    'user_id.required' => 'El "Supervisor" es obligatorio.',
                ]);
            $equipo->nombre = request('nombre');
            $equipo->sede_id = request('sede_id');
            $equipo->user_id = request('user_id');
            $equipo->save();
        } elseif ($view === 'update-cambiar-equipo') {
            $request->validate(
                [
                    'equipo_id' => 'required|bail',
                ],
                [
                    'equipo_id.required' => 'El "Equipo" es obligatorio.',
                ]
            );
            $user = User::find(request('user_id'));
            if (! $user->equipos->isEmpty()) {
                for ($i = 0; $i < count($user->equipos); $i++) {
                    $user->equipos()->detach($user->equipos[$i]->id);
                }
            }
            $user->equipos()->attach(request('equipo_id'));
            if (! $user->clientes->isEmpty()) {
                foreach ($user->clientes as $value) {
                    $cliente = Cliente::find($value->id);
                    $cliente->equipo_id = request('equipo_id');
                    $cliente->sede_id = $user->sede_id;
                    $cliente->save();
                    $cliente->usersHistorial()->attach($user->id);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipo $equipo)
    {
        //
    }
}
