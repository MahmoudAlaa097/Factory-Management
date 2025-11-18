<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Management;
use App\Models\Division;


class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $production = Management::production()->first();

        // Parent divisions
        $assembly = Division::create([
            'name' => 'Assembly',
            'management_id' => $production->id,
            'parent_division_id' => null,
        ]);

        $packaging = Division::create([
            'name' => 'Packaging',
            'management_id' => $production->id,
            'parent_division_id' => null,
        ]);

        // Assembly subdivisions
        $assemblyDivisions = [
            'Automatic Assembly',
            'Manual Assembly',
            'Insert',
            'Vacuum',
            'Thermo Forming',
            'Scissors',
        ];

        // Create assembly subdivisions
        foreach ($assemblyDivisions as $divisionName) {
            Division::create([
                'name' => $divisionName,
                'management_id' => $production->id,
                'parent_division_id' => $assembly->id,
            ]);
        }

        // Packaging subdivisions
        $packagingDivisions = [
            'Packaging',
            'Blister',
            'Mini Blister',
        ];

        // Create packaging subdivisions
        foreach ($packagingDivisions as $divisionName) {
            Division::create([
                'name' => $divisionName,
                'management_id' => $production->id,
                'parent_division_id' => $packaging->id,
            ]);
        }
    }
}
