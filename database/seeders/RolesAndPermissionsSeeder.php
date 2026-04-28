<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);

        Permission::create(['name' => 'view cases']);
        Permission::create(['name' => 'edit cases']);
        Permission::create(['name' => 'delete cases']);
        Permission::create(['name' => 'create cases']);

        Permission::create(['name' => 'view courts']);
        Permission::create(['name' => 'edit courts']);
        Permission::create(['name' => 'delete courts']);
        Permission::create(['name' => 'create courts']);

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole = Role::create(['name' => 'trainee']);
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['view users']);
    }
}
