<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Name field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Name field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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
