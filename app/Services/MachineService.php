<?php

namespace App\Services;

use App\Models\Machine;

class MachineService
{
    public function getMachinesByDivision(int $divisionId)
    {
        return Machine::division($divisionId)
                      ->orderBy('number')
                      ->get(['id', 'number']);
    }
}
