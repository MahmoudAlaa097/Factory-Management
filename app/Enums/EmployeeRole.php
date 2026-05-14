<?php

namespace App\Enums;

enum EmployeeRole: string
{
    case Admin      = 'admin';
    case Manager    = 'manager';
    case Engineer   = 'engineer';
    case Supervisor = 'supervisor';
    case Technician = 'technician';
    case Operator   = 'operator';

    public function is(self $role): bool
    {
        return $this === $role;
    }

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    public function isManager(): bool
    {
        return $this === self::Manager;
    }

    public function isEngineer(): bool
    {
        return $this === self::Engineer;
    }

    public function isSupervisor(): bool
    {
        return $this === self::Supervisor;
    }

    public function isTechnician(): bool
    {
        return $this === self::Technician;
    }

    public function isOperator(): bool
    {
        return $this === self::Operator;
    }
}
