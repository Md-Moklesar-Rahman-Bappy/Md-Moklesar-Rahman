<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'manage dashboard']);
        Permission::create(['name' => 'manage profile']);
        Permission::create(['name' => 'manage skills']);
        Permission::create(['name' => 'manage experience']);
        Permission::create(['name' => 'manage education']);
        Permission::create(['name' => 'manage projects']);
        Permission::create(['name' => 'manage services']);
        Permission::create(['name' => 'manage testimonials']);
        Permission::create(['name' => 'manage certifications']);
        Permission::create(['name' => 'manage blog']);
        Permission::create(['name' => 'manage messages']);
        Permission::create(['name' => 'manage newsletter']);
        Permission::create(['name' => 'manage settings']);
        Permission::create(['name' => 'manage seo']);
        Permission::create(['name' => 'manage analytics']);
        Permission::create(['name' => 'manage media']);

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo([
            'manage dashboard', 'manage profile', 'manage skills',
            'manage experience', 'manage education', 'manage projects',
            'manage services', 'manage blog', 'manage messages',
        ]);
    }
}
