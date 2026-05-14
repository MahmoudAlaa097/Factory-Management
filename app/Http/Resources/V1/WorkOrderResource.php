<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'type'       => $this->type->value,
            'start_time' => $this->start_time?->toIso8601String(),
            'end_time'   => $this->end_time?->toIso8601String(),
            'duration_minutes' => $this->duration_minutes,
            'notes'      => $this->notes,

            'machine' => [
                'id'     => $this->machine->id,
                'number' => $this->machine->number,
            ],

            'logged_by' => [
                'id'   => $this->loggedBy->id,
                'name' => $this->loggedBy->name,
            ],

            'technicians' => $this->technicians->map(fn ($t) => [
                'id'   => $t->id,
                'name' => $t->name,
                'code' => $t->code,
            ]),

            // fault
            'affected_components' => $this->when(
                $this->type->value === 'fault',
                fn () => $this->components->map(fn ($c) => [
                    'section_id'   => $c->machine_section_id,
                    'section_name' => $c->section->name,
                    'component_id' => $c->machine_component_id,
                    'component_name' => $c->component->name,
                ])
            ),

            // preventive
            'maintenance_type' => $this->when($this->type->value === 'preventive', $this->maintenance_type),
            'is_finished'      => $this->when($this->type->value === 'preventive', $this->is_finished),

            // task
            'task_title'  => $this->when($this->type->value === 'task', $this->task_title),
            'division'    => $this->when(
                $this->type->value === 'task' && $this->division,
                fn () => [
                    'id'   => $this->division->id,
                    'name' => $this->division->name,
                ]
            ),

            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
