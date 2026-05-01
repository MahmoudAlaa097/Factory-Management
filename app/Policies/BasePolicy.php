<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Fault;

abstract class BasePolicy
{
    // -----------------------------------------------------------------------
    // Core gate
    // -----------------------------------------------------------------------

    /**
     * Admin always passes. Everyone else must satisfy $condition.
     */
    protected function allow(User $user, bool $condition): bool
    {
        return $this->isAdmin($user) || $condition;
    }

    // -----------------------------------------------------------------------
    // Role checks
    // -----------------------------------------------------------------------


    protected function isAdmin(User $user): bool
    {
        return (bool) $user->employee?->role?->isAdmin();
    }

    protected function isManager(User $user): bool
    {
        return (bool) $user->employee?->role?->isManager();
    }

    protected function isEngineer(User $user): bool
    {
        return (bool) $user->employee?->role?->isEngineer();
    }

    protected function isSupervisor(User $user): bool
    {
        return (bool) $user->employee?->role?->isSupervisor();
    }

    protected function isTechnician(User $user): bool
    {
        return (bool) $user->employee?->role?->isTechnician();
    }

    protected function isOperator(User $user): bool
    {
        return (bool) $user->employee?->role?->isOperator();
    }

    // -----------------------------------------------------------------------
    // Management-type checks
    // -----------------------------------------------------------------------

    protected function isMaintenance(User $user): bool
    {
        return (bool) $user->employee?->management?->type->isMaintenance();
    }

    protected function isProduction(User $user): bool
    {
        return (bool) $user->employee?->management?->type->isProduction();
    }

    // -----------------------------------------------------------------------
    // Combined role + management-type helpers
    // -----------------------------------------------------------------------

    protected function isMaintenanceTechnician(User $user): bool
    {
        return $this->isTechnician($user) && $this->isMaintenance($user);
    }

    protected function isMaintenanceSupervisor(User $user): bool
    {
        return $this->isSupervisor($user) && $this->isMaintenance($user);
    }

    protected function isMaintenanceEngineer(User $user): bool
    {
        return $this->isEngineer($user) && $this->isMaintenance($user);
    }

    protected function isMaintenanceManager(User $user): bool
    {
        return $this->isManager($user) && $this->isMaintenance($user);
    }

    protected function isProductionSupervisor(User $user): bool
    {
        return $this->isSupervisor($user) && $this->isProduction($user);
    }

    protected function isProductionOperator(User $user): bool
    {
        return $this->isOperator($user) && $this->isProduction($user);
    }

    protected function isProductionEngineer(User $user): bool
    {
        return $this->isEngineer($user) && $this->isProduction($user);
    }

    protected function isProductionManager(User $user): bool
    {
        return $this->isManager($user) && $this->isProduction($user);
    }

    // -----------------------------------------------------------------------
    // Scope helpers — generic models (management_id / division_id columns)
    // -----------------------------------------------------------------------

    /**
     * User's management matches the model's management_id column.
     * Use for: Division, Employee, and any model with management_id.
     */
    protected function sameManagement(User $user, $model): bool
    {
        return $user->employee?->management_id === $model->management_id;
    }

    /**
     * User's division matches the model's division_id column.
     */
    protected function sameDivision(User $user, $model): bool
    {
        return $user->employee?->division_id === $model->division_id;
    }

    // -----------------------------------------------------------------------
    // Scope helpers — Fault-specific (uses maintenance_management_id)
    // -----------------------------------------------------------------------

    /**
     * User belongs to the maintenance management that owns this fault.
     */
    protected function faultInUserManagement(User $user, Fault $fault): bool
    {
        return $this->isMaintenance($user)
            && $user->employee?->management_id === $fault->maintenance_management_id;
    }

    /**
     * Fault was raised in the user's division.
     */
    protected function faultInUserDivision(User $user, Fault $fault): bool
    {
        return $user->employee?->division_id === $fault->division_id;
    }

    // -----------------------------------------------------------------------
    // Spatie permission check (kept for non-policy use if needed)
    // -----------------------------------------------------------------------

    protected function can(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission);
    }
}
