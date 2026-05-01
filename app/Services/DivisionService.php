<?php

namespace App\Services;

use App\Models\Division;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DivisionService extends BaseService
{
    protected string $model          = Division::class;
    protected array $allowedIncludes = [
        'management',
        'parent',
        'children',
        'machines',
        'employees',
    ];
    protected array $allowedFilters  = [
        'management_id',
        'parent_division_id',
        'is_active',
    ];
    protected array $allowedSorts    = [
        'id',
        'name',
        'created_at',
    ];

    public function listForUser(User $user): LengthAwarePaginator
    {
        $employee = $user->employee->load('management');

        return QueryBuilder::for(Division::class)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedSorts($this->allowedSorts)
            ->when(! $employee->role->isAdmin(), function ($query) use ($employee) {

                // Manager / Engineer → all divisions in their management
                if ($employee->role->isManager() || $employee->role->isEngineer()) {
                    $query->where('management_id', $employee->management_id);
                    return;
                }

                // Everyone else (supervisor, technician, operator) → own division only
                $query->where('id', $employee->division_id);
            })
            ->paginate(request('per_page', 15));
    }
}
