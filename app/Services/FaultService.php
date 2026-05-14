<?php

namespace App\Services;

use App\Enums\EmployeeRole;
use App\Enums\FaultStatus;
use App\Events\FaultCreated;
use App\Events\FaultStatusChanged;
use App\Events\TechnicianAssigned;
use App\Events\TechnicianUnassigned;
use App\Events\FaultComponentAttached;
use App\Events\FaultComponentDetached;
use App\Http\Requests\Api\V1\StoreFaultRequest;
use App\Models\Employee;
use App\Models\Fault;
use App\Models\FaultComponent;
use App\Models\Machine;
use App\Models\MachineComponent;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
            ->when(! $employee->role->isAdmin(), function ($query) use ($employee) {

                if ($employee->management->type->isMaintenance()) {
                    $query->where('maintenance_management_id', $employee->management_id);

                    if ($employee->role->is(EmployeeRole::Technician)) {
                        $query->where(function ($q) use ($employee) {
                            $q->whereIn('status', [
                                FaultStatus::Open->value,
                                FaultStatus::InProgress->value,
                            ])->orWhereHas('technicians', fn ($q) =>
                                $q->where('employees.id', $employee->id)
                            );
                        });
                    }
                }

                if ($employee->management->type->isProduction()) {
                    $query->where('division_id', $employee->division_id);

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
        $machine = Machine::findOrFail($request->machine_id);

        $fault = Fault::create([
            'machine_id'                => $machine->id,
            'division_id'               => $machine->division_id,
            'maintenance_management_id' => $request->maintenance_management_id,
            'reported_by'               => $user->employee->id,
            'status'                    => FaultStatus::Open,
            'description'               => $request->description,
            'reported_at'               => now(),
        ]);

        FaultCreated::dispatch($fault);

        return $fault;
    }

    public function respond(Fault $fault, User $user): Fault
    {
        $oldStatus = $fault->status;

        $fault->update([
            'status'                => FaultStatus::InProgress,
            'technician_started_at' => now(),
        ]);

        $fault->technicians()->attach($user->employee->id, [
            'assigned_at' => now(),
        ]);

        FaultStatusChanged::dispatch($fault->fresh(), $oldStatus);

        return $fault->fresh();
    }

    public function resolve(Fault $fault): Fault
    {
        $oldStatus = $fault->status;

        $fault->update([
            'status'      => FaultStatus::Resolved,
            'resolved_at' => now(),
        ]);

        FaultStatusChanged::dispatch($fault->fresh(), $oldStatus);

        return $fault->fresh();
    }

    public function accept(Fault $fault): Fault
    {
        $oldStatus = $fault->status;

        $fault->update([
            'status'               => FaultStatus::OperatorAccepted,
            'operator_accepted_at' => now(),
        ]);

        FaultStatusChanged::dispatch($fault->fresh(), $oldStatus);

        return $fault->fresh();
    }

    public function approveMaintenance(Fault $fault, User $user): Fault
    {
        $oldStatus = $fault->status;

        $fault->update([
            'status'                  => FaultStatus::MaintenanceApproved,
            'maintenance_approved_by' => $user->employee->id,
            'maintenance_approved_at' => now(),
        ]);

        FaultStatusChanged::dispatch($fault->fresh(), $oldStatus);

        return $fault->fresh();
    }

    public function close(Fault $fault, User $user): Fault
    {
        $oldStatus = $fault->status;

        $fault->update([
            'status'        => FaultStatus::Closed,
            'closed_by'     => $user->employee->id,
            'closed_at'     => now(),
            'time_consumed' => (int) round($fault->reported_at->diffInMinutes(now())),
        ]);

        FaultStatusChanged::dispatch($fault->fresh(), $oldStatus);

        return $fault->fresh();
    }

    public function assignTechnician(Fault $fault, int $technicianId): Fault
    {
        $technician = Employee::findOrFail($technicianId);

        if ($technician->management_id !== $fault->maintenance_management_id) {
            throw new AuthorizationException(
                'Technician must belong to the correct maintenance management.'
            );
        }

        if ($fault->technicians()->where('employees.id', $technicianId)->exists()) {
            throw ValidationException::withMessages([
                'technician_id' => ['Technician is already assigned to this fault.'],
            ]);
        }

        $fault->technicians()->attach($technicianId, [
            'assigned_at' => now(),
        ]);

        TechnicianAssigned::dispatch($fault, $technician);

        return $fault->fresh();
    }

    public function unassignTechnician(Fault $fault, Employee $employee): Fault
    {
        $originalTechnicianId = $fault->technicians()
            ->orderBy('fault_technicians.assigned_at')
            ->first()?->id;

        if ($originalTechnicianId === $employee->id) {
            throw ValidationException::withMessages([
                'technician_id' => ['Cannot unassign the original responding technician.'],
            ]);
        }

        $fault->technicians()->detach($employee->id);

        TechnicianUnassigned::dispatch($fault, $employee);

        return $fault->fresh();
    }

    public function detachComponent(Fault $fault, FaultComponent $faultComponent): Fault
    {
        if ($faultComponent->fault_id !== $fault->id) {
            throw new AuthorizationException(
                'Component does not belong to this fault.',
            );
        }

        $faultComponent->delete();

        FaultComponentDetached::dispatch($fault, $faultComponent);

        return $fault->fresh();
    }
}
