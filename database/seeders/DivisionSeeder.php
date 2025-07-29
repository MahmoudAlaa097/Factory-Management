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
        // Example data for divisions
        $divisions = [
            ['name' => 'Electrical', 'management_id' => 1],
            ['name' => 'Traceability', 'management_id' => 1],
            ['name' => 'Quality Assurance', 'management_id' => 2],
            ['name' => 'Quality Control', 'management_id' => 3],
            ['name' => 'Human Resources', 'management_id' => 4],
            ['name' => 'Finance', 'management_id' => 5],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
