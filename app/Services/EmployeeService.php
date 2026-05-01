<?php

namespace App\Services;

use App\Enums\EmployeeRole;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeService extends BaseService
{
    protected string $model          = Employee::class;
    protected array $allowedIncludes = [
        'user',
        'management',
        'division',
    ];
    protected array $allowedSorts    = [
        'id',
        'name',
        'code',
        'created_at',
    ];

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('management_id'),
            AllowedFilter::exact('division_id'),
            AllowedFilter::exact('role'),
            AllowedFilter::exact('is_active'),
        ];
    }

    public function listForUser(User $user): LengthAwarePaginator
    {
        $employee = $user->employee->load('management');

        return QueryBuilder::for(Employee::class)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedSorts($this->allowedSorts)
            ->when(! $employee->role->isAdmin(), function ($query) use ($employee) {

                // Manager / Engineer → all in their management
                if ($employee->role->isManager() || $employee->role->isEngineer()) {
                    $query->where('management_id', $employee->management_id);
                    return;
                }

                // Maintenance Supervisor → technicians in their management
                if ($employee->role->isSupervisor() && $employee->management->type->isMaintenance()) {
                    $query->where('management_id', $employee->management_id)
                          ->where('role', EmployeeRole::Technician);
                    return;
                }

                // Production Supervisor → operators in their division
                if ($employee->role->isSupervisor() && $employee->management->type->isProduction()) {
                    $query->where('division_id', $employee->division_id)
                          ->where('role', EmployeeRole::Operator);
                    return;
                }

                // Operator / Technician → self only
                $query->where('id', $employee->id);
            })
            ->paginate(request('per_page', 15));
    }
}
