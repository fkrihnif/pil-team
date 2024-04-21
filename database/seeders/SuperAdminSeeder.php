<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'SuperAdmin', 
            'username' => 'superadmin', 
            'email' => 'superadmin@pil.com',
            'department' => 'SuperAdmin',
            'password' => Hash::make('password123**')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin', 
            'username' => 'admin', 
            'email' => 'admin@pil.com',
            'department' => 'Admin',
            'password' => Hash::make('password**')
        ]);
        $admin->assignRole('Admin');
    }
}
