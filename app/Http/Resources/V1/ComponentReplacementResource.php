<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComponentReplacementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'fault'         => new FaultResource($this->whenLoaded('fault')),
            'machine'       => new MachineResource($this->whenLoaded('machine')),
            'old_component' => new MachineComponentResource($this->whenLoaded('oldComponent')),
            'new_component' => new MachineComponentResource($this->whenLoaded('newComponent')),
            'replaced_by'   => new EmployeeResource($this->whenLoaded('replacedBy')),
            'replaced_at'   => $this->replaced_at,
            'created_at'    => $this->created_at,
        ];
    }
}
