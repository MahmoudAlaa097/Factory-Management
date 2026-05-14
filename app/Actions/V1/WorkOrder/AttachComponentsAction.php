<?php

namespace App\Actions\V1\WorkOrder;

use App\Models\WorkOrder;

class AttachComponentsAction
{
    public function execute(WorkOrder $workOrder, array $components): void
    {
        $rows = array_map(fn ($c) => [
            'work_order_id'        => $workOrder->id,
            'machine_section_id'   => $c['section_id'],
            'machine_component_id' => $c['component_id'],
            'created_at'           => now(),
            'updated_at'           => now(),
        ], $components);

        $workOrder->components()->insert($rows);
    }
}
