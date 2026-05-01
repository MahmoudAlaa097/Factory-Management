<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MachineSection;

class MachineSectionPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MachineSection $machineSection): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, MachineSection $machineSection): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, MachineSection $machineSection): bool
    {
        return $this->isAdmin($user);
    }
}
