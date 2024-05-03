<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $subadmin = User::create([
            'name' => 'subadmin',
            'email' => 'subadmin@admin.com',
            'password' => bcrypt('Pass@123'),
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $subAdminRole = Role::create(['name' => 'subadmin']);

        $admin->assignRole($adminRole);
        $subadmin->assignRole($subAdminRole);

        Permission::create(['name' => 'view-products']);
        Permission::create(['name' => 'create-products']);
        Permission::create(['name' => 'edit-products']);
        Permission::create(['name' => 'delete-products']);

        Permission::create(['name' => 'view-category']);
        Permission::create(['name' => 'create-category']);
        Permission::create(['name' => 'edit-category']);
        Permission::create(['name' => 'delete-category']);

        $adminRole->givePermissionTo([
            'view-products', 'create-products', 'edit-products', 'delete-products',
            'view-category', 'create-category', 'edit-category', 'delete-category',
        ]);

        $subAdminRole->givePermissionTo([
            'view-products', 'create-products',
            'view-category', 'create-category',
        ]);

    }
}
