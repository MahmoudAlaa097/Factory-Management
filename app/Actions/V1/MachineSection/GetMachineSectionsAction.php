<?php

namespace App\Actions\V1\MachineSection;

use App\Models\Machine;
use App\Services\MachineSectionService;
use Illuminate\Database\Eloquent\Collection;

class GetMachineSectionsAction
{
    public function __construct(
        private readonly MachineSectionService $service,
    ) {}

    public function execute(Machine $machine): Collection
    {
        return $this->service->getSectionsForMachine($machine);
    }
}
