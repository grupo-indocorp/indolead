<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ListaUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['sede', 'permissions', 'roles', 'equipos']);
        if (auth()->user()->hasRole('sistema')) {
        } else {
            $users->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'sistema');
            });
        }
        $users = $users->orderByDesc('id')->get();
        return view('sistema.lista_usuario.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request('view') == 'create') {
            $sedes = Sede::all();
            $roles = Role::all();
            $equipos = Equipo::all();
            return view('sistema.lista_usuario.create', compact('sedes', 'roles', 'equipos'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (request('view') == 'store') {
            $request->validate([
                'name' => 'required|bail',
                'email' => 'required|email|unique:users|bail',
                'password' => 'required|min:8|bail',
                'sede_id' => 'required|bail',
                'role_id' => 'required|bail',
            ],
            [
                'name.required' => 'El "Nombre" es obligatorio.',
                'email.required' => 'El "Correo" es obligatorio.',
                'email.email' => 'El "Correo" no es válido, (email@example.com).',
                'email.unique' => 'El "Correo" debe ser único en los Usuarios.',
                'password.required' => 'La "Contraseña" es obligatorio.',
                'password.min' => 'La "Contraseña" debe contener como mínimo 8 caracteres.',
                'sede_id.required' => 'La "Sede" es obligatorio.',
                'role_id.required' => 'El "Rol" es obligatorio.',
            ]);
            // Si es Ejecutivo, obligar Equipo
            if (request('role_id') === '4') {
                $request->validate(
                    [
                        'equipo_id' => 'required|bail',
                    ],
                    [
                        'equipo_id.required' => 'El "Equipo" es obligatorio.',
                    ]
                );
            }
            $role = Role::find(request('role_id'));
            $user = new User;
            $user->name = request('name');
            $user->email = request('email');
            $user->identity_document = request('identity_document') ?? '';
            $user->password = bcrypt(request('password'));
            $user->sede_id = request('sede_id');
            $user->assignRole($role->name);
            $user->save();
            // Si es Ejecutivo, registrar Equipo
            if (request('role_id') === '4') {
                $user->equipos()->attach(request('equipo_id'));
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $lista_usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (request('view') == 'edit') {
            $sedes = Sede::all();
            return view('sistema.lista_usuario.edit', compact('user', 'sedes'));
        } elseif (request('view') == 'edit-asignar-equipo') {
            $equipos = Equipo::all();
            return view('sistema.lista_usuario.asignar-equipo', compact('user', 'equipos'));
        } elseif (request('view') == 'edit-asignar-rol') {
            $roles = Role::all();
            return view('sistema.lista_usuario.asignar-rol', compact('user', 'roles'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (request('view') == 'update') {
            $request->validate([
                'name' => 'required|bail',
                'email' => 'required|bail',
                'sede_id' => 'required|bail',
            ],
            [
                'name.required' => 'El "Nombre" es obligatorio.',
                'email.required' => 'El "Correo" es obligatorio.',
                'sede_id.required' => 'La "Sede" es obligatorio.',
            ]);
            if (request('password') != '') {
                $request->validate([
                    'password' => 'required|min:8|bail',
                ],
                [
                    'password.required' => 'La "Contraseña" es obligatorio.',
                    'password.min' => 'La "Contraseña" debe tener 8 dígitos como mínimo.',
                ]);
            }
            $user = User::find($id);
            $user->name = request('name');
            $user->identity_document = request('identity_document');
            $user->email = request('email');
            $user->sede_id = request('sede_id');
            if (request('password') != '') {
                $user->password = bcrypt(request('password'));
            }
            $user->save();
        } elseif (request('view') == 'update-asignar-equipo') {
            $request->validate([
                'equipo_id' => 'required|bail',
            ],
            [
                'equipo_id.required' => 'El "Equipo" es obligatorio.',
            ]);
            if (!$user->equipos->isEmpty()) {
                for ($i=0; $i < count($user->equipos); $i++) {
                    $user->equipos()->detach($user->equipos[$i]->id);
                }
            }
            $user->equipos()->attach(request('equipo_id'));
            if (!$user->clientes->isEmpty()) {
                foreach ($user->clientes as $value) {
                    $cliente = Cliente::find($value->id);
                    $cliente->equipo_id = request('equipo_id');
                    $cliente->save();
                }
            }
        } elseif (request('view') == 'update-asignar-rol') {
            $request->validate([
                'role_id' => 'required|bail',
            ],
            [
                'role_id.required' => 'El "Rol" es obligatorio.',
            ]);
            $role = Role::find(request('role_id'));
            foreach ($user->getRoleNames() as $value) {
                $user->removeRole($value);
            }
            $user->assignRole($role->name);
        } elseif (request('view') == 'update-user') {
            if (request('password') != '') {
                $request->validate([
                    'password' => 'required|min:8|bail',
                ],
                [
                    'password.required' => 'La "Contraseña" es obligatorio.',
                    'password.min' => 'La "Contraseña" debe tener 8 dígitos como mínimo.',
                ]);
                $user = User::find($id);
                $user->password = bcrypt(request('password'));
                $user->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $lista_usuario)
    {
        //
    }
}
