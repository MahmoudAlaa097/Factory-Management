<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MachineComponent;

class MachineComponentPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user)
            || $this->isMaintenance($user)
            || $this->isProduction($user);
    }

    public function view(User $user, MachineComponent $component): bool
    {
        return $this->allow($user,
            // Maintenance → all components
            $this->isMaintenance($user)
            ||
            // Production → components belonging to machines in their division
            (
                $this->isProduction($user) &&
                $user->employee?->division_id === $component->machine->division_id
            )
        );
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, MachineComponent $component): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, MachineComponent $component): bool
    {
        return $this->isAdmin($user);
    }
}
