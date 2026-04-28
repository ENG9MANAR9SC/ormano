<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return Permission::all();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions']);
        $permission = Permission::create(['name' => $request->name]);
        return response()->json($permission, 201);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name,' . $permission->id]);
        $permission->update(['name' => $request->name]);
        return response()->json($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->noContent();
    }
}