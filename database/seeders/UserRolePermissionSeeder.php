<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        collect([
            ['name' => 'Administrators'],
            ['name' => 'Operators'],
            ['name' => 'Users'],
        ])->each(fn($role) => Role::create($role));

        collect([
            ['name' => 'view-permission'],
            ['name' => 'create-permission'],
            ['name' => 'update-permission'],
            ['name' => 'delete-permission'],
            ['name' => 'view-role'],
            ['name' => 'create-role'],
            ['name' => 'update-role'],
            ['name' => 'delete-role'],
            ['name' => 'view-user'],
            ['name' => 'create-user'],
            ['name' => 'update-user'],
            ['name' => 'delete-user'],
        ])->each(fn($permission) => Permission::create($permission)->assignRole('Administrators'));

        User::create([
            'name' => 'Yatim Mandiri',
            'email' => 'scrum@yatimmandiri.org',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // password
        ])->assignRole('Administrators');

        User::create([
            'name' => 'Wakaf Yatim Mandiri',
            'email' => 'wakaf@yatimmandiri.org',
            'password' => Hash::make('operators'),
            'email_verified_at' => now(),
        ])->assignRole('Operators');
    }
}
