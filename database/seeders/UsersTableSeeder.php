<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Pass@123'),
        ]);

        $subadminUser = User::create([
            'name' => 'Subadmin',
            'email' => 'subadmin@admin.com',
            'password' => bcrypt('Pass@123'),
        ]);

    }
}
