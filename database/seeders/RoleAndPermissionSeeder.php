<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'superadmin',
            'admin',
            'user',
        ];
        
        $permissions = [
            'create post',
            'edit post',
            'delete post',
            'view post',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            if ($roleName === 'superadmin') {
                $role->syncPermissions(Permission::all());
            } elseif ($roleName === 'admin') {
                $role->syncPermissions($permissions);
            } elseif ($roleName === 'user') {
                $role->syncPermissions(['view post']);
            } 
        }
    }
}