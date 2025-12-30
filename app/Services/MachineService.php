<?php

namespace App\Services;

use App\Models\Machine;

class MachineService
{
    public function getMachineById(int $machineId)
    {
        return Machine::find($machineId);
    }

    public function getMachinesByDivision(int $divisionId)
    {
        return Machine::byDivision($divisionId)
                      ->orderByRaw('CAST(number AS UNSIGNED)')
                      ->get(['id', 'number']);
    }
}
