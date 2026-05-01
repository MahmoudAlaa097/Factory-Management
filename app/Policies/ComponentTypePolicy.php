<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ComponentType;

class ComponentTypePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ComponentType $componentType): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, ComponentType $componentType): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, ComponentType $componentType): bool
    {
        return $this->isAdmin($user);
    }
}
