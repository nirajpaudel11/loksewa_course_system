<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@loksewa.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole($adminRole);

        // Create Regular User
        $student = User::firstOrCreate(
            ['email' => 'user@loksewa.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('user123'),
            ]
        );
        $student->assignRole($userRole);
    }
}
