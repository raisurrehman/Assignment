<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as AppPermissions;
use Spatie\Permission\Models\Role as AppRole;

class RolePermissionsController extends Controller
{
    /**
     * Display a listing of the Role
     *
     */

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $roles = AppRole::select(['id', 'name'])->get();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($role) {
                    return '<button class="btn btn-info edit-role-btn" data-id="' . $role->id . '">Edit</button>'
                    . '<a href="' . route('roles.permissions', $role->id) . '" class="btn btn-warning  ml-1">Permissions</a>';
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.sections.role-permissions.index', [
            'title' => 'Roles',
            'menu_active' => 'roles',
        ]);
    }

    // Store Role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = new AppRole();
        $role->name = $request->name;
        $role->save();

        return response()->json(['role' => $role]);
    }

    // Show the form for editing the specified role
    public function edit($id)
    {
        $role = AppRole::find($id);
        return response()->json($role);
    }

    // Update the role
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = AppRole::find($id);
        $role->name = $request->name;
        $role->save();

        return response()->json(['role' => $role->id]);
    }

    //  permissions

    public function permissions(AppRole $role)
    {
        $role = $role->load('permissions');
        $permissions = AppPermissions::get();

        return view('admin.sections.role-permissions.permissions', [
            'title' => 'Permissions',
            'menu_active' => 'roles',
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function updatePermissions(Request $request, AppRole $role)
    {

        if ($request->has('permissions')) {
            $permissions = AppPermissions::whereIn('id', $request->input('permissions'))->pluck('id');
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles')->with('success', 'Permissions updated successfully.');
    }

}
