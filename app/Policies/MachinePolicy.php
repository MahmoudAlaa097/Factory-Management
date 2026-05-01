<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Machine;

class MachinePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Machine $machine): bool
    {
        return $this->allow($user,
            // Maintenance → all machines
            $this->isMaintenance($user)
            ||
            // Production → own division only
            (
                $this->isProduction($user) &&
                $user->employee?->division_id === $machine->division_id
            )
        );
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Machine $machine): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Machine $machine): bool
    {
        return $this->isAdmin($user);
    }
}
