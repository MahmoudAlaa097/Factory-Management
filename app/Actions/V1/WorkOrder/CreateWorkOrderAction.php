<?php

namespace App\Actions\V1\WorkOrder;

use App\Models\WorkOrder;

class CreateWorkOrderAction
{
    public function execute(array $data): WorkOrder
    {
        return WorkOrder::create([
            'machine_id'       => $data['machine_id'],
            'logged_by'        => $data['logged_by'],
            'type'             => $data['type'],
            'start_time'       => $data['start_time'],
            'end_time'         => $data['end_time'] ?? null,
            'notes'            => $data['notes'] ?? null,

            // preventive
            'maintenance_type' => $data['maintenance_type'] ?? null,
            'is_finished'      => $data['is_finished'] ?? null,

            // task
            'task_title'       => $data['task_title'] ?? null,
            'division_id'      => $data['division_id'] ?? null,
        ]);
    }
}
