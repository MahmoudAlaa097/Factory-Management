<?php

namespace App\Actions\V1\MachineSection;

use App\Models\MachineSection;
use App\Services\MachineSectionService;
use Illuminate\Database\Eloquent\Collection;

class GetSectionComponentsAction
{
    public function __construct(
        private readonly MachineSectionService $service,
    ) {}

    public function execute(MachineSection $section): Collection
    {
        return $this->service->getComponentsForSection($section);
    }
}
