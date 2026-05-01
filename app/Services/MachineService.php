<?php

namespace App\Services;

use App\Models\Machine;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MachineService extends BaseService
{
    protected string $model          = Machine::class;
    protected array $allowedIncludes = [
        'division',
        'machineType',
        'faults',
        'componentReplacements',
    ];
    protected array $allowedSorts    = [
        'id',
        'number',
        'created_at',
    ];

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('division_id'),
            AllowedFilter::exact('machine_type_id'),
            AllowedFilter::exact('is_active'),
        ];
    }

    public function listForUser(User $user): LengthAwarePaginator
    {
        $employee = $user->employee->load('management');

        return QueryBuilder::for(Machine::class)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedSorts($this->allowedSorts)
            ->when(! $employee->role->isAdmin(), function ($query) use ($employee) {

                // Maintenance → all machines (no additional scope)
                if ($employee->management->type->isMaintenance()) {
                    return;
                }

                // Production → own division only
                if ($employee->management->type->isProduction()) {
                    $query->where('division_id', $employee->division_id);
                }
            })
            ->paginate(request('per_page', 15));
    }
}
