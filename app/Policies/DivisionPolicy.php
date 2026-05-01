<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Division;

class DivisionPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Division $division): bool
    {
        return $this->allow($user,
            // Manager / Engineer → all divisions in their management
            (
                ($this->isManager($user) || $this->isEngineer($user)) &&
                $this->sameManagement($user, $division)
            )
            ||
            // Everyone else → own division only
            $this->sameDivision($user, $division)
        );
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Division $division): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Division $division): bool
    {
        return $this->isAdmin($user);
    }
}
