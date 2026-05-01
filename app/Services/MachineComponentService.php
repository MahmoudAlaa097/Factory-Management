<?php

namespace App\Services;

use App\Models\MachineComponent;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MachineComponentService extends BaseService
{
    protected string $model          = MachineComponent::class;
    protected array $allowedIncludes = [
        'section',
        'componentType',
    ];
    protected array $allowedSorts    = [
        'id',
        'name',
        'created_at',
    ];

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('machine_section_id'),
            AllowedFilter::exact('component_type_id'),
        ];
    }

    public function listForUser(User $user): LengthAwarePaginator
    {
        $employee = $user->employee->load('management');

        return QueryBuilder::for(MachineComponent::class)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedSorts($this->allowedSorts)
            ->when(! $employee->role->isAdmin(), function ($query) use ($employee) {

                // Maintenance → all components (no additional scope)
                if ($employee->management->type->isMaintenance()) {
                    return;
                }

                // Production → only components of machines in their division
                if ($employee->management->type->isProduction()) {
                    $query->whereHas('machine', function ($q) use ($employee) {
                        $q->where('division_id', $employee->division_id);
                    });
                }
            })
            ->paginate(request('per_page', 15));
    }
}
