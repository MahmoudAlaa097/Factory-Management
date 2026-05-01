<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MachineType;

class MachineTypePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MachineType $machineType): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, MachineType $machineType): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, MachineType $machineType): bool
    {
        return $this->isAdmin($user);
    }
}
