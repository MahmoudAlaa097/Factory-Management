<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example data for roles
        $roles = [
            'manager',
            'assistant manager',
            'engineer',
            'supervisor',
            'technician',
            'operator',
            'warehouse keeper',
        ];

        // Create roles
        foreach ($roles as $role) {
            Role::Create(['name' => $role]);
        }

        // Example data for permissions
        $permissions = [
            // Fault Report Permissions
            'view-faults',
            'create-faults',

            // Fault Assignment Permissions
            'view-assignments',
            'assign-faults',
            'reassign-faults',

            // Fault Resolution Permissions
            'resolve-faults',
            'view-resolutions',

            // Machine Downtime Permissions
            'view-downtime',
            'manage-downtime',

            // Reports
            'view-reports',
            'generate-reports',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions
        $manager = Role::findByName('manager');
        $manager->givePermissionTo(Permission::all());

        $engineer = Role::findByName('engineer');
        $engineer->givePermissionTo(['view-faults', 'assign-faults']);

        $operator = Role::findByName('operator');
        $operator->givePermissionTo(['create-faults']);
    }
}
