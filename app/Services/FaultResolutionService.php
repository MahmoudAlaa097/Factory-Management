<?php

namespace App\Services;

use App\Http\Requests\Api\V1\UpdateFaultResolutionRequest;
use App\Models\Fault;
use App\Models\FaultComponent;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FaultResolutionService
{
    public function updateResolution(UpdateFaultResolutionRequest $request, Fault $fault): Fault
    {
        return DB::transaction(function () use ($request, $fault) {

            // Update fault-level fields if present
            $fault->fill(array_filter([
                'resolution_notes' => $request->resolution_notes,
                'time_consumed'    => $request->time_consumed,
            ], fn ($value) => $value !== null))->save();

            // Update component notes if provided
            if ($request->has('components')) {
                foreach ($request->components as $item) {
                    $component = FaultComponent::find($item['id']);

                    // Ensure the component belongs to this fault
                    if (! $component || $component->fault_id !== $fault->id) {
                        throw ValidationException::withMessages([
                            'components' => ["Component {$item['id']} does not belong to this fault."],
                        ]);
                    }

                    $component->update([
                        'notes' => $item['notes'] ?? $component->notes,
                    ]);
                }
            }

            return $fault->fresh();
        });
    }
}
