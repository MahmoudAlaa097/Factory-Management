<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Management;
use App\Models\Division;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch managements
        $production = Management::production()->first();
        $electrical = Management::maintenance()->where('name', 'LIKE', '%Electrical%')->first();
        $mechanical = Management::maintenance()->where('name', 'LIKE', '%Mechanical%')->first();

        // Fetch divisions
        $automaticAssembly = Division::where('name', 'Automatic Assembly')->first();

        $employeesData = [
            // Production Management
            [
                'user' => [
                    'username' => 'prod_manager',
                    'password' => Hash::make('123'),
                    'name' => 'Production Manager',
                ],
                'employee' => [
                    'code' => '0001',
                    'management_id' => $production->id,
                    'division_id' => null,
                    'position' => 'manager',
                ],
                'role' => 'manager',
            ],
            [
                'user' => [
                    'username' => 'prod_engineer',
                    'password' => Hash::make('123'),
                    'name' => 'Production Engineer',
                ],
                'employee' => [
                    'code' => '0002',
                    'management_id' => $production->id,
                    'division_id' => null,
                    'position' => 'engineer',
                ],
                'role' => 'engineer',
            ],

            // Electrical Maintenance
            [
                'user' => [
                    'username' => 'elec_manager',
                    'password' => Hash::make('123'),
                    'name' => 'Electrical Manager',
                ],
                'employee' => [
                    'code' => '0003',
                    'management_id' => $electrical->id,
                    'division_id' => null,
                    'position' => 'manager',
                ],
                'role' => 'manager',
            ],
            [
                'user' => [
                    'username' => 'elec_engineer',
                    'password' => Hash::make('123'),
                    'name' => 'Electrical Engineer',
                ],
                'employee' => [
                    'code' => '0004',
                    'management_id' => $electrical->id,
                    'division_id' => null,
                    'position' => 'engineer',
                ],
                'role' => 'engineer',
            ],
            [
                'user' => [
                    'username' => 'elec_supervisor',
                    'password' => Hash::make('123'),
                    'name' => 'Electrical Supervisor',
                ],
                'employee' => [
                    'code' => '0005',
                    'management_id' => $electrical->id,
                    'division_id' => null,
                    'position' => 'supervisor',
                ],
                'role' => 'supervisor',
            ],
            [
                'user' => [
                    'username' => 'elec_tech',
                    'password' => Hash::make('123'),
                    'name' => 'Electrical Technician',
                ],
                'employee' => [
                    'code' => '0006',
                    'management_id' => $electrical->id,
                    'division_id' => null,
                    'position' => 'technician',
                ],
                'role' => 'technician',
            ],

            // Mechanical Maintenance
            [
                'user' => [
                    'username' => 'mech_engineer',
                    'password' => Hash::make('123'),
                    'name' => 'Mechanical Engineer',
                ],
                'employee' => [
                    'code' => '0007',
                    'management_id' => $mechanical->id,
                    'division_id' => null,
                    'position' => 'engineer',
                ],
                'role' => 'engineer',
            ],

            // Operators
            [
                'user' => [
                    'username' => 'operator',
                    'password' => Hash::make('123'),
                    'name' => 'Operator 1',
                ],
                'employee' => [
                    'code' => '0008',
                    'management_id' => $production->id,
                    'division_id' => $automaticAssembly->id,
                    'position' => 'operator',
                ],
                'role' => 'operator',
            ],
        ];

        // Create users and employees
        foreach ($employeesData as $data) {
            $user = User::create($data['user']);
            $user->assignRole($data['role']);

            $employeeData = $data['employee'];
            $employeeData['user_id'] = $user->id;
            Employee::create($employeeData);
        }

        // Employee without user account
        Employee::create([
            'user_id' => null,
            'code' => '0009',
            'management_id' => $production->id,
            'division_id' => $automaticAssembly->id,
            'position' => 'operator',
        ]);
    }
}
