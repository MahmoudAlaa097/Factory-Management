<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Machine;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machines = array_map(function($i) {
            return [
                'machine_type_id' => 1,
                'division_id' => 3,
                'number' => (string) $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, range(1, 37));

        Machine::insert($machines);
    }
}
