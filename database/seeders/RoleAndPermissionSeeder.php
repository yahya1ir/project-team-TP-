<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Seed roles, permissions, and sample users.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage users',
            'manage formations',
            'view formations',
            'manage sessions',
            'manage inscriptions',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $teacherRole = Role::firstOrCreate(['name' => 'Teacher', 'guard_name' => 'web']);
        $studentRole = Role::firstOrCreate(['name' => 'Student', 'guard_name' => 'web']);

        $superAdminRole->syncPermissions($permissions);
        $adminRole->syncPermissions($permissions);
        $teacherRole->syncPermissions([
            'manage formations',
            'view formations',
            'manage sessions',
            'view dashboard',
        ]);
        $studentRole->syncPermissions([
            'view formations',
        ]);

        $superAdmin = User::updateOrCreate(
            ['email' => 'yahya@gmail.com'],
            [
                'name' => 'Yahya Super Admin',
                'phone' => '0600000001',
                'password' => Hash::make('12345678'),
                'language' => 'en',
                'status' => 'active',
                'role' => 'admin',
            ]
        );
        $superAdmin->syncRoles([$superAdminRole]);

        $adminUsers = [
            ['email' => 'laadam@gmail.com', 'name' => 'Laadam'],
            ['email' => 'ezzaytouni@gmail.com', 'name' => 'Ezzaytouni'],
            ['email' => 'irfane@gmail.com', 'name' => 'Irfane'],
            ['email' => 'bahloul@gmail.com', 'name' => 'Bahloul'],
            ['email' => 'mousalim@gmail.com', 'name' => 'Mousalim'],
        ];

        foreach ($adminUsers as $index => $adminUser) {
            $admin = User::updateOrCreate(
                ['email' => $adminUser['email']],
                [
                    'name' => $adminUser['name'],
                    'phone' => '06000000'.str_pad((string) ($index + 2), 2, '0', STR_PAD_LEFT),
                    'password' => Hash::make('12345678'),
                    'language' => 'en',
                    'status' => 'active',
                    'role' => 'admin',
                ]
            );

            $admin->syncRoles([$adminRole]);
        }

        $teacher = User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'name' => 'Lead Teacher',
                'phone' => '0600000007',
                'password' => Hash::make('12345678'),
                'language' => 'en',
                'status' => 'active',
                'role' => 'formateur',
            ]
        );
        $teacher->syncRoles([$teacherRole]);

        $teacherExample = User::updateOrCreate(
            ['email' => 'teacher@exemple.com'],
            [
                'name' => 'Teacher Example',
                'phone' => '0600000009',
                'password' => Hash::make('12345678'),
                'language' => 'en',
                'status' => 'active',
                'role' => 'formateur',
            ]
        );
        $teacherExample->syncRoles([$teacherRole]);

        $student = User::updateOrCreate(
            ['email' => 'normal.user@gmail.com'],
            [
                'name' => 'Normal User',
                'phone' => '0600000008',
                'password' => Hash::make('12345678'),
                'language' => 'fr',
                'status' => 'active',
                'role' => 'participant',
            ]
        );
        $student->syncRoles([$studentRole]);
    }
}
