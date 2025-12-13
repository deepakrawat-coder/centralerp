<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
  public function index(Request $request)
{
    if ($request->ajax()) {
        $users = User::with('roles')->get();
        $serial = 1;

        return response()->json([
            'data' => $users->map(function ($user) use (&$serial) {

                $editUrl = route('users.edit', $user->id);
                $deleteUrl = route('users.destroy', $user->id);

                $action = '
                    <a onclick="edit(\'' . $editUrl . '\', \'modal-md\')" 
                       class="text-warning"
                       data-bs-toggle="tooltip"
                       data-bs-placement="top"
                       title="Edit User">
                        <i class="ri-edit-circle-line fs-5"></i>
                    </a>

                    <a onclick="destroy(\'' . $deleteUrl . '\', \'user-table\')" 
                       class="text-danger deleteBtn"
                       data-bs-toggle="tooltip"
                       data-bs-placement="top"
                       title="Delete User">
                        <i class="ri-delete-bin-line fs-5"></i>
                    </a>
                ';

                return [
                    'serial' => $serial++,
                    'name'   => $user->name,
                    'email'  => $user->email,
                    'roles'  => $user->roles->pluck('name')->implode(', '),
                    'action' => $action,
                ];
            })
        ]);
    }

    return view('user-control.users.index');
}




    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        // dd($roles);
        return view('user-control.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles'    => 'required|string'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign roles
        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        // return redirect()->route('users.index')
        //     ->with('success', 'User created successfully.');
         return response()->json([
            'status'  => 'success',
            'message' => 'User created successfully!'
        ]);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('user-control.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load('roles');

        return view('user-control.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user, including roles.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'string|max:255',
            'email'    => 'email|unique:users,email,' . $user->id,
            'roles'    => 'string',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        $user->syncRoles($request->roles);

        return response()->json([
            'status'  => 'success',
            'message' => 'User updated successfully!'
        ]);
    }

    /**
     * Remove the specified user from storage.
     */
   public function destroy($id)
{
    // dd($id);
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found!'
        ], 404);
    }

    $user->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'User deleted successfully!'
    ]);
}

}
