<?php

namespace App\Services;

use App\Models\Machine;
use App\Models\MachineSection;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MachineSectionService extends BaseService
{
    protected string $model          = MachineSection::class;
    protected array $allowedIncludes = [
        'machineTypes',
        'components',
    ];
    protected array $allowedSorts    = [
        'id',
        'name',
        'created_at',
    ];

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('machine_type_id'),
        ];
    }

    /**
     * All sections that belong to the given machine's type.
     * Returns a plain Collection (no pagination) — used for select dropdowns.
     */
    public function getSectionsForMachine(Machine $machine): Collection
    {
        $machineTypeId = $machine->machine_type_id;

        return MachineSection::query()
            ->whereHas('machineTypes', fn ($q) => $q->where('machine_types.id', $machineTypeId))
            ->orderBy('name')
            ->get();
    }

    /**
     * All components that belong to the given section.
     * Returns a plain Collection (no pagination) — used for select dropdowns.
     */
    public function getComponentsForSection(MachineSection $section): Collection
    {
        return $section->components()->orderBy('name')->get();
    }
}
