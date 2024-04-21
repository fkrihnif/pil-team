<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['group' => 'role', 'name' => 'create-role']);
        Permission::create(['group' => 'role', 'name' => 'edit-role']);
        Permission::create(['group' => 'role', 'name' => 'delete-role']);
        Permission::create(['group' => 'user', 'name' => 'create-user']);
        Permission::create(['group' => 'user', 'name' => 'edit-user']);
        Permission::create(['group' => 'user', 'name' => 'delete-user']);
    }
}
