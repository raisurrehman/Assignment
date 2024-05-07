<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role as AppRole;

class UserController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email'])->get();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($user) {
                    return '<button class="btn btn-primary assign-role" data-id="' . $user->id . '">Assign Role</button>';
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.sections.users.index', [
            'title' => 'Users',
            'menu_active' => 'users',
        ]);
    }

    public function assignRole($userId)
    {

        $user = User::find($userId)->load('roles');
        $roles = AppRole::get();
        return view('admin.sections.users.roles.assign', [
            'title' => 'Users',
            'menu_active' => 'users',
            'user' => $user,
            'roles' => $roles,
        ]);

    }

    public function updateAssignedRoles(Request $request, $userId)
    {
        $user = User::find($userId);
        $user->roles()->detach();

        foreach ($request->roles as $roleId) {
            $role = AppRole::find($roleId);
            $user->assignRole($role);
        }

        return response()->json(['message' => 'Role updated successfully'], 200);
    }

}
