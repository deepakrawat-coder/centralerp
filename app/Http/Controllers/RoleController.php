<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $roles = Role::with('permissions')->get();
    //         $serial = 1;

    //         return response()->json([
    //             'data' => $roles->map(function ($role) use (&$serial) {

    //                 $editUrl = route('roles.edit', $role->id);
    //                 $deleteUrl = route('roles.destroy', $role->id);
    //                 $rolePermissions = route('roles.permissions', $role->id);
    //                 $action = '
    //                 <a onclick="rolePermissions(\'' . $rolePermissions . '\', \'modal-lg\')" 
    //                    class="text-primary"
    //                    data-bs-toggle="tooltip"
    //                    data-bs-placement="top"
    //                    title="Edit Role">
    //                     <i class="ri-add-circle-fill fs-5"></i>
    //                 </a>
    //                 <a onclick="edit(\'' . $editUrl . '\', \'modal-md\')" 
    //                    class="text-warning"
    //                    data-bs-toggle="tooltip"
    //                    data-bs-placement="top"
    //                    title="Edit Role">
    //                     <i class="ri-edit-circle-line fs-5"></i>
    //                 </a>
    //                 <a onclick="destroy(\'' . $deleteUrl . '\', \'role-table\')" 
    //                    class="text-danger deleteBtn"
    //                    data-bs-toggle="tooltip"
    //                    data-bs-placement="top"
    //                    title="Delete Role">
    //                     <i class="ri-delete-bin-line fs-5"></i>
    //                 </a>
    //             ';

    //                 return [
    //                     'serial'      => $serial++,
    //                     'name'        => $role->name,
    //                     'permissions' => $role->permissions->pluck('name')->implode(', '),
    //                     'action'      => $action,
    //                 ];
    //             })
    //         ]);
    //     }

    //     return view('user-control.roles.index');
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $roles = Role::with('permissions')->get();
            $serial = 1;

            return response()->json([
                'data' => $roles->map(function ($role) use (&$serial) {

                    // Extract unique module names (before dot)
                    $modules = $role->permissions
                        ->map(function ($p) {
                            // Extract module name (before first space)
                            $parts = explode(' ', $p->name); // if your permission is "User Create"
                            return $parts[0];
                        })
                        ->unique()
                        ->values();

                    $fullModules = $modules->implode(', ');
                    // If too long → show button instead
                    if (strlen($fullModules) > 25) {
                        $permissionColumn = '<button class="btn btn-sm btn-primary" 
        onclick="rolePermissionsView(\'' . addslashes($role->name) . '\', \'' . addslashes($fullModules) . '\')">
        View
    </button>';
                    } else {
                        $permissionColumn = $fullModules;
                    }




                    // Action Buttons
                    $editUrl = route('roles.edit', $role->id);
                    $deleteUrl = route('roles.destroy', $role->id);
                    $rolePermissions = route('roles.permissions', $role->id);

                    $action = '
                    <a onclick="rolePermissions(\'' . $rolePermissions . '\', \'modal-lg\')" class="text-primary" title="Assign Permissions">
                        <i class="ri-add-circle-fill fs-5"></i>
                    </a>
                    <a onclick="edit(\'' . $editUrl . '\', \'modal-md\')" class="text-warning" title="Edit Role">
                        <i class="ri-edit-circle-line fs-5"></i>
                    </a>
                    <a onclick="destroy(\'' . $deleteUrl . '\', \'role-table\')" class="text-danger deleteBtn" title="Delete Role">
                        <i class="ri-delete-bin-line fs-5"></i>
                    </a>
                ';

                    return [
                        'serial'      => $serial++,
                        'name'        => $role->name,
                        'permissions' => $permissionColumn,
                        'action'      => $action,
                    ];
                })
            ]);
        }

        return view('user-control.roles.index');
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('user-control.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return response()->json(['status' => 'success', 'message' => 'Role created successfully']);
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('user-control.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return response()->json(['status' => 'success', 'message' => 'Role updated successfully']);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['status' => 'success', 'message' => 'Role deleted successfully']);
    }
    // public function assignPermissions(Role $role)
    // {
    //     // Get all permissions
    //     $permissions = Permission::orderBy('id', 'ASC')->get();
    //     // dd($permissions);
    //     // Prepare permission list in "Module Permission" format
    //     $permissionList = [];
    //     foreach ($permissions as $permission) {
    //         $parts = explode('.', $permission->name);

    //         if (count($parts) >= 2) {
    //             // Format: Users View, Users Create, etc.
    //             $module = ucfirst($parts[0]);
    //             $action = ucfirst($parts[1]);
    //             $displayName = $module . ' ' . $action;
    //         } else {
    //             // If no dot, just use the name
    //             $displayName = ucfirst($permission->name);
    //         }

    //         $permissionList[$permission->id] = $displayName;
    //     }

    //     // Get already assigned permissions
    //     $allotedPermissions = $role->permissions->pluck('id')->toArray();

    //     // Group by first word (module) for better organization
    //     $groupedPermissions = [];
    //     foreach ($permissionList as $id => $name) {
    //         $firstWord = explode(' ', $name)[0]; // Get module name
    //         $groupedPermissions[$firstWord][$id] = $name;
    //     }

    //     // Sort modules alphabetically
    //     ksort($groupedPermissions);

    //     return view('user-control.roles.assign-permissions', compact('role', 'groupedPermissions', 'allotedPermissions'));
    // }
    public function assignPermissions(Role $role)
    {
        // Get all permissions ordered by ID ascending (oldest → latest)
        $permissions = Permission::orderBy('id', 'ASC')->get();

        $permissionList = [];
        foreach ($permissions as $permission) {
            $parts = explode('.', $permission->name);

            if (count($parts) >= 2) {
                $module = ucfirst($parts[0]);
                $action = ucfirst($parts[1]);
                $displayName = $module . ' ' . $action;
            } else {
                $displayName = ucfirst($permission->name);
            }

            $permissionList[$permission->id] = $displayName;
        }

        $allotedPermissions = $role->permissions->pluck('id')->toArray();

        // Group by module
        $groupedPermissions = [];
        foreach ($permissionList as $id => $name) {
            $firstWord = explode(' ', $name)[0]; // Module name
            $groupedPermissions[$firstWord][$id] = $name;
        }

        // Sort modules alphabetically
        ksort($groupedPermissions);

        // Sort permissions inside each module by ID ascending (oldest → latest)
        foreach ($groupedPermissions as &$modulePermissions) {
            asort($modulePermissions); // keeps latest last
        }
        // dd([
        //     'role' => $role->toArray(),
        //     'groupedPermissions' => $groupedPermissions,
        //     'allotedPermissions' => $allotedPermissions
        // ]);
        return view('user-control.roles.assign-permissions', compact('role', 'groupedPermissions', 'allotedPermissions'));
    }


    public function updatePermissions(Request $request, Role $role)
    {
        // dd($request->all());
        $permissionNames = Permission::whereIn('id', $request->permissions ?? [])
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissionNames);

        return response()->json([
            'status' => 'success',
            'message' => 'Permissions updated successfully'
        ]);
    }
}
