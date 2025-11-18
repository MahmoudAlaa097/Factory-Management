<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Management;

class ManagementSeeder extends Seeder
{
    public function run(): void
    {
        Management::create([
            'name' => 'Production',
            'type' => Management::TYPE_PRODUCTION,
        ]);

        Management::create([
            'name' => 'Electrical Maintenance',
            'type' => Management::TYPE_MAINTENANCE,
        ]);

        Management::create([
            'name' => 'Mechanical Maintenance',
            'type' => Management::TYPE_MAINTENANCE,
        ]);
    }
}
