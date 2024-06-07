<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('sistema.role.index', compact('roles'));
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
        if ($id == 'show-permiso') {
            $role = Role::find(request('role_id'));
            $data = Permission::all();
            $permissions = [];
            foreach ($data as $item) {
                $checked = '';
                foreach ($role->permissions as $value) {
                    if ($value->name == $item->name) {
                        $checked = 'checked';
                    }
                }
                $permissions[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'checked'=> $checked,
                ];
            }
            return view('sistema.role.permisos', compact('role', 'permissions'));
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
        $role = Role::find($id);
        $role->revokePermissionTo(Permission::all());
        $data = Permission::all();
        foreach ($data as $item) {
            if (request($item->id) == 'on') {
                $permission = Permission::find($item['id']);
                $role->givePermissionTo($permission->name);
            }
        }
        return redirect()->route('role.index')->with('success', 'Permisos Actualizados.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
