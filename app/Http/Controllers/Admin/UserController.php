<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }

}
