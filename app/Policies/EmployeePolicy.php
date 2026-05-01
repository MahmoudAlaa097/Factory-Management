<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
use App\Enums\EmployeeRole;

class EmployeePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Employee $employee): bool
    {
        return $this->allow($user,
            // Manager / Engineer → anyone in their management
            (
                ($this->isManager($user) || $this->isEngineer($user)) &&
                $this->sameManagement($user, $employee)
            )
            ||
            // Maintenance Supervisor → technicians in their management
            (
                $this->isMaintenanceSupervisor($user) &&
                $employee->role === EmployeeRole::Technician &&
                $this->sameManagement($user, $employee)
            )
            ||
            // Production Supervisor → operators in their division
            (
                $this->isProductionSupervisor($user) &&
                $employee->role === EmployeeRole::Operator &&
                $this->sameDivision($user, $employee)
            )
            ||
            // Self (operator, technician, anyone)
            $user->employee?->id === $employee->id
        );
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Employee $employee): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $this->isAdmin($user);
    }
}
