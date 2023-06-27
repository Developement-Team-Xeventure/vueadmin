<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

        public function run(): void
    {
            
        $roleEditor = Role::create(
            [
                'name' => 'primaryadmin',
                'role_name'=>'Primary Admin',
                'company_id'=>1,
                'guard_name'=>'api',
            ]
        );
        $roleSupervisor = Role::create(
            [
                'name' => 'manager',
                'role_name'=>'Manager',
                'company_id'=>1,
                'guard_name'=>'api',
            ]
        );

        // Define permissions
        $permissions = [
            'can-view-dashboard',
            'can-edit-dashboard',
            'can-publish-dashboard',
            'can-deleted-dashboard',
            'can-share-dashboard',

        ];
        $permissionNames = [
            'Can View Dashboard',
            'Can Edit Dashboard',
            'Can Publish Dashboard',
            'Can Deleted Dashboard',
            'Can Share Dashboard',
        ];

        foreach ($permissions as $key=> $permissionName) {
            $permission = Permission::create([
                'permission_name' => $permissionNames[$key],
                'name' => $permissionName,
                'guard_name' =>'api',
            ]);

            if (in_array($permissionName, [
                'can-view-dashboard',
                'can-edit-dashboard',
                'can-publish-dashboard',
                'can-share-dashboard'
                ])) {
                $roleEditor->givePermissionTo($permission);
            } else {
                $roleSupervisor->givePermissionTo($permission);
            }
        }

    }
}
