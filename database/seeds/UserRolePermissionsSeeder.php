<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class UserRolePermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = config('defaults.permissions');
        $roles = config('defaults.roles');
        $roleHasPermissions = config('defaults.role_has_permissions');

        foreach ($permissions as $permission) {
            try {
                Permission::findByName($permission);
            } catch (PermissionDoesNotExist $e) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }

        foreach ($roles as $role) {
            try {
                Role::findByName($role);
            } catch (RoleDoesNotExist $e) {
                Role::create([
                    'name' => $role
                ]);
            }
        }

        foreach ($roleHasPermissions as $role => $permissions) {
            try {
                $role = Role::findByName($role);
                $role->givePermissionTo($permissions);
            } catch (RoleDoesNotExist $e) {

            }
        }
    }
}
