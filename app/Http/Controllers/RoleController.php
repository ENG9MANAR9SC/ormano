<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return Role::with('permissions')->get();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles']);
        $role = Role::create(['name' => $request->name]);
        if ($request->permissions) {
            $role->givePermissionTo($request->permissions);
        }
        return response()->json($role, 201);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|string|unique:roles,name,' . $role->id]);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->noContent();
    }
}