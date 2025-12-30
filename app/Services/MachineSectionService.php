<?php

namespace App\Services;

use App\Models\MachineSection;

class MachineSectionService
{
    public function getMachineSectionsByType(int $typeId)
    {
        return MachineSection::machineType($typeId)
                      ->orderBy('id')
                      ->get(['id', 'name']);
    }
}
