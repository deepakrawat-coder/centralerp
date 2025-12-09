<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    private $superAdminPermissions = [
       

    ];



    public function run(): void
    {
        foreach ($this->superAdminPermissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }
        $role = Role::create(['name' => 'Super Admin']);
        $managementRoles = Role::create(['name' => 'Center'], ['name' => 'Sub-Center'], ['name' => 'Operation-Head']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
    }
}
