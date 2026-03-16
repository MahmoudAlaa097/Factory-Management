<?php

namespace App\Services;

use App\Http\Requests\Api\V1\StoreComponentReplacementRequest;
use App\Models\ComponentReplacement;
use App\Models\Fault;
use App\Models\MachineComponent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\ValidationException;

class ComponentReplacementService extends BaseService
{
    protected string $model          = ComponentReplacement::class;
    protected array $allowedIncludes = [
        'fault',
        'machine',
        'oldComponent',
        'newComponent',
        'replacedBy',
    ];
    protected array $allowedSorts    = [
        'id',
        'replaced_at',
        'created_at',
    ];

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('fault_id'),
            AllowedFilter::exact('machine_id'),
            AllowedFilter::exact('old_component_id'),
            AllowedFilter::exact('new_component_id'),
        ];
    }

    public function list(): LengthAwarePaginator
    {
        return QueryBuilder::for(ComponentReplacement::class)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedSorts($this->allowedSorts)
            ->with(['oldComponent', 'newComponent', 'replacedBy', 'machine'])
            ->paginate(request('per_page', 15));
    }

    public function show(Model $model): Model
    {
        return QueryBuilder::for(ComponentReplacement::class)
            ->allowedIncludes($this->allowedIncludes)
            ->with(['oldComponent', 'newComponent', 'replacedBy', 'machine'])
            ->findOrFail($model->id);
    }

    public function log(StoreComponentReplacementRequest $request, Fault $fault, User $user): ComponentReplacement
    {
        $machine      = $fault->machine;
        $oldComponent = MachineComponent::findOrFail($request->old_component_id);
        $newComponent = MachineComponent::findOrFail($request->new_component_id);

        // Validate both components belong to machine type sections
        $validSectionIds = $machine->machineType->sections()
            ->pluck('machine_sections.id');

        if (!$validSectionIds->contains($oldComponent->machine_section_id)) {
            throw ValidationException::withMessages([
                'old_component_id' => ['Old component does not belong to this machine type.'],
            ]);
        }

        if (!$validSectionIds->contains($newComponent->machine_section_id)) {
            throw ValidationException::withMessages([
                'new_component_id' => ['New component does not belong to this machine type.'],
            ]);
        }

        return ComponentReplacement::create([
            'fault_id'         => $fault->id,
            'machine_id'       => $machine->id,
            'old_component_id' => $request->old_component_id,
            'new_component_id' => $request->new_component_id,
            'replaced_by'      => $user->employee->id,
            'replaced_at'      => $request->replaced_at,
        ]);
    }
}
