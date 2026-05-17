<?php

namespace App\Actions\V1\WorkOrder;

use App\Models\Division;
use App\Models\Management;
use App\Models\WorkOrder;

class CreateWorkOrderAction
{
    public function execute(array $data): WorkOrder
    {
        $requesterType = match($data['requester_type'] ?? null) {
            'division'   => Division::class,
            'management' => Management::class,
            default      => null,
        };

        return WorkOrder::create([
            'machine_id'       => $data['machine_id'] ?? null,
            'logged_by'        => $data['logged_by'],
            'type'             => $data['type'],
            'date'             => $data['date'],
            'duration_minutes' => $data['duration_minutes'],
            'start_time'       => $data['start_time'] ?? null,
            'end_time'         => $data['end_time'] ?? null,
            'notes'            => $data['notes'] ?? null,
            'maintenance_type' => $data['maintenance_type'] ?? null,
            'task_title'       => $data['task_title'] ?? null,
            'task_tag'         => $data['task_tag'] ?? null,
            'requester_type'   => $requesterType,
            'requester_id'     => $data['requester_id'] ?? null,
        ]);
    }
}
