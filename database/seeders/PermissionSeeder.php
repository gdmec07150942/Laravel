<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add permission
        Permission::create(['name' => 'admin']);

        // Aad admin Role
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('admin');

        // Assign a role to a specific user
        $user = \App\Models\User::find(1); // Retrieve the user (e.g., user with ID 1)
        $user->assignRole('admin');
    }
}
