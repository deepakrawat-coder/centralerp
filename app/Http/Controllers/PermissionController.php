<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $permissions = Permission::all();
        $serial = 1;

        return response()->json([
            'data' => $permissions->map(function ($permission) use (&$serial) {

                // Define URLs
                $editUrl = route('permissions.edit', $permission->id);
                $deleteUrl = route('permissions.destroy', $permission->id);

                // Define actions
                $action = '
                    <a onclick="edit(\'' . $editUrl . '\', \'modal-md\')" 
                       class="text-warning"
                       data-bs-toggle="tooltip"
                       data-bs-placement="top"
                       title="Edit Permission">
                        <i class="ri-edit-circle-line fs-5"></i>
                    </a>

                    <a onclick="destroy(\'' . $deleteUrl . '\', \'permission-table\')" 
                       class="text-danger deleteBtn"
                       data-bs-toggle="tooltip"
                       data-bs-placement="top"
                       title="Delete Permission">
                        <i class="ri-delete-bin-line fs-5"></i>
                    </a>
                ';

                return [
                    'serial'     => $serial++,
                    'name'       => $permission->name,
                    'guard_name' => $permission->guard_name,
                    'action'     => $action,
                ];
            }),
        ]);
    }

    return view('user-control.permissions.index');
}


    public function create()
    {
        return view('user-control.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return response()->json(['status' => 'success', 'message' => 'Permission created successfully']);
    }

    public function edit(Permission $permission)
    {
        return view('user-control.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        
        $request->validate([
            'name' => 'unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return response()->json(['status' => 'success', 'message' => 'Permission updated successfully']);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json(['status' => 'success', 'message' => 'Permission deleted successfully']);
    }

}
