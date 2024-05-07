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
                    return '<a href="' . route('users.assign-role', $user->id) . '" class="btn btn-info">Assign Role</a>';
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.sections.users.index', [
            'title' => 'Users',
            'menu_active' => 'users',
        ]);
    }

    public function assignRole(User $user)
    {

        $user = $user->load('roles');
        $roles = AppRole::get();

        return view('admin.sections.users.roles.assign', [
            'title' => 'Users',
            'menu_active' => 'users',
            'user' => $user,
            'roles' => $roles,
        ]);

    }

    public function updateAssignedRoles(Request $request, User $user)
    {
        $user->roles()->detach();

        foreach ($request->roles as $roleId) {
            $role = AppRole::find($roleId);
            $user->assignRole($role);
        }

        return redirect()->route('users')->with('success', 'Roles assigned successfully');
    }

}
