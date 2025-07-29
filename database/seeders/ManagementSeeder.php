<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Management;

class ManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managementNames = [
            'Electrical Maintenance',
            'Mechanical Maintenance',
            'Production',
            'IT',
            'Quality Control',
            'Human Resources',
        ];

        foreach ($managementNames as $name) {
            Management::create(['name' => $name]);
        }
    }
}
