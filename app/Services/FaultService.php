<?php

namespace App\Services;

use App\Enums\EmployeeRole;
use App\Enums\FaultStatus;
use App\Models\Fault;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\Api\V1\StoreFaultRequest;
use App\Models\Machine;


class FaultService extends BaseService
{
    protected string $model          = Fault::class;
    protected array $allowedIncludes = [
        'machine',
        'division',
        'maintenanceManagement',
        'reporter',
        'maintenanceApprover',
        'closer',
        'technicians',
        'components',
        'replacements',
    ];
    protected array $allowedSorts    = [
        'id',
        'status',
        'reported_at',
        'closed_at',
    ];

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('machine_id'),
            AllowedFilter::exact('division_id'),
            AllowedFilter::exact('maintenance_management_id'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('reported_by'),
        ];
    }

    public function listForUser(User $user): LengthAwarePaginator
    {
        $employee = $user->employee->load('management');

        return QueryBuilder::for(Fault::class)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedSorts($this->allowedSorts)
            ->when(!$employee->role->isAdmin(), function ($query) use ($employee) {

                // Maintenance — scoped to their management
                if ($employee->management->type->isMaintenance()) {
                    $query->where('maintenance_management_id', $employee->management_id);

                    // Technician — open/in_progress or own assigned faults
                    if ($employee->role->is(EmployeeRole::Technician)) {
                        $query->where(function ($q) use ($employee) {
                            $q->whereIn('status', [
                                FaultStatus::Open->value,
                                FaultStatus::InProgress->value,
                            ])->orWhereHas('technicians', fn($q) =>
                                $q->where('employees.id', $employee->id)
                            );
                        });
                    }
                }

                // Production — scoped to their division
                if ($employee->management->type->isProduction()) {
                    $query->where('division_id', $employee->division_id);

                    // Operator — own faults only
                    if ($employee->role->is(EmployeeRole::Operator)) {
                        $query->where('reported_by', $employee->id);
                    }
                }
            })
            ->paginate(request('per_page', 15));
    }

    public function show(\Illuminate\Database\Eloquent\Model $model): \Illuminate\Database\Eloquent\Model
    {
        return QueryBuilder::for(Fault::class)
            ->allowedIncludes($this->allowedIncludes)
            ->with('technicians')
            ->findOrFail($model->id);
    }

    public function report(StoreFaultRequest $request, User $user): Fault
    {
        $employee = $user->employee;
        $machine  = Machine::findOrFail($request->machine_id);

        return Fault::create([
            'machine_id'                => $machine->id,
            'division_id'               => $machine->division_id,
            'maintenance_management_id' => $request->maintenance_management_id,
            'reported_by'               => $employee->id,
            'status'                    => FaultStatus::Open,
            'description'               => $request->description,
            'reported_at'               => now(),
        ]);
    }
}
