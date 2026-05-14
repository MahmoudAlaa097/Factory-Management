<?php

namespace App\Actions\V1\WorkOrder;

use App\Models\WorkOrder;

class AttachTechniciansAction
{
    public function execute(WorkOrder $workOrder, array $technicianIds): void
    {
        $workOrder->technicians()->attach($technicianIds);
    }
}
